<?php
/*
	
	remark  : mysqli通用操作类，兼容STMT模式，使用单例模式
	author  : stch12132324
	version	: 1.0.1
	time	: 2015-06-18
	php		: >5.3.0+
	
*/
class Db_mysqli{

//------------------ 定义参数 -----------------------------
    private $conn;
    private $debug   = 1;
    var $dbpre;
    var $rs_type    = MYSQLI_ASSOC; // 结果显示方式 array('name'=>'abc')
    var $unbuffered = false; // 是否不缓存
    var $safe_type  = 0; // 是否开始stmt模式

    var $table_name; // 表名称
    var $result;
    var $paramType; // stmt 模式下 insert 参数类型
    var $_where , $_field , $_limit , $_order , $_parameters , $_primary;

    //DEBUG 下查询
    var $query_number = 0;  // 查询次数
    var $query_times;       // 查询时间
    var $last_query_string = '';   // 最后一次查询的sql语句

    private static $_instance;

//------------------ 构造函数 -----------------------------
    function __construct($dname = ''){
        $this->connect($dname);
    }
    private function __clone(){

    }
    public static function getInstance()    {
        if(! (self::$_instance instanceof self) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
//------------------连接-----------------------------
    public function connect($dname = ''){
        // 多数据库模式
        $dname = $dname == '' ? 'default' : $dname;
        $dbConfig = json_decode(DB_CONFIG);
        $dbConfig = $dbConfig->$dname;
        $this->conn    = new mysqli( $dbConfig->dbhost, $dbConfig->dbuser, $dbConfig->dbpw, $dbConfig->dbname );
        $this->charset = $dbConfig->charset;
        $this->dbpre   = $dbConfig->dbpre;

        if (mysqli_connect_errno()) throw_exception(mysqli_connect_error());
        if($this->version() > '4.1'){
            $serverset = $this->charset ? "SET NAMES ".$this->charset : '';
            $serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',')." sql_mode='' ") : '';
            $this->conn->query($serverset);
        }
        return $this->connid;
    }

//------------------query-----------------------------
    function query($sql){
        if(!is_object($this->conn)){
            $this->connect();
        }
        $start_time = $this->time_used();
        $func = $this->unbuffered && function_exists("mysqli_multi_query") ? "mysqli_multi_query" : "mysqli_query";
        $this->result = @$func($this->conn,$sql);
        if(!$this->result){
            $this->show_error($this->conn->error,$sql);
            return false;
        }else{
            $this->recordOneResult($start_time);
            $this->last_query_string = $sql;
            return $this->result;
        }
    }
//------------------stmt模式下query-----------------------------
    public function stmt_query(&$sql='' , &$data=''){
        $start_time = $this->time_used();
        $stmt = $this->conn->stmt_init();
        $stmt->prepare($sql);
        $bind_params_r = array();
        // insert update 操作
        if(is_array($data)){
            if($this->_parameters!=''){
                $_where_arr = explode(",",$this->_parameters);
            }
            $bind_params_r[] = $this->paramType.$_where_arr[0]; // param && where 的类型 iis
            // param 预定义数值
            foreach($data as $key=>$d){
                $bind_params_r[] = $d;
            }
            if($this->_parameters!=''){
                // where 预定义数值
                $_where_len = count($_where_arr);
                for($nn=1;$nn<$_where_len;$nn++){
                    $bind_params_r[] = $_where_arr[$nn];
                }
            }
            call_user_func_array(array($stmt,"bind_param"), self::refValues($bind_params_r));
        }else{
            // 其他操作
            if($this->_parameters!=''){
                $bind_params_r = explode(",",$this->_parameters);
                call_user_func_array(array($stmt,"bind_param"), self::refValues($bind_params_r));
            }
        }
        if($stmt->execute()){
            $this->recordOneResult($start_time);
            if(!is_array($data)){ // 查询时候
                return $stmt;
            }else{
                return true;
            }
        }else{
            $this->show_error($stmt->error,$sql);
            return false;
        }
        $stmt->close();
    }
//------------------多结果查询-----------------------------
    public function get_all($sql='', $primary=''){
        $result = $this->safe_type==0 ? $this->query($sql) : $this->stmt_query($sql);
        if(!$result) return false;
        $start_time = $this->time_used();
        $rlt = array();
        if($this->safe_type==1){
            $result = $result->get_result();
        }
        while($rows = $result->fetch_array($this->rs_type)){
            if($primary && $rows[$primary]){
                $rlt[$rows[$primary]] = $rows;
            }else{
                $rlt[] = $rows;
            }
        }
        $end_time = $this->time_used();
        $this->query_times += round($end_time - $start_time,5); // 累加查询时间
        return (!empty($rlt) ? $rlt : false);
    }
    // 兼容旧的程序
    public function select($sql='',$primary=''){
        return $this->get_all($sql,$primary);
    }
//------------------ 一条结果查询-----------------------------
    public function get_one($sql=''){
        $result = $this->safe_type==0?$this->query($sql):$this->stmt_query($sql);
        if(!$result) return false;
        $start_time = $this->time_used();
        if($this->safe_type==1){
            $result = $result->get_result();
        }
        $rows = mysqli_fetch_array($result,$this->rs_type);
        $end_time = $this->time_used();
        $this->query_times += round($end_time - $start_time,5);#[查询时间]
        return $rows;
    }

//------------------高级查询方式-----------------------------
    public function fetch(){
        $this->_field = $this->_field==''?'*':$this->_field;
        $where = $this->_where?' where '.$this->_where:'';
        $limit = $this->_limit?' limit '.$this->_limit:'';
        $order = $this->_order?' order by '.$this->_order:'';
        $sql = "select ".$this->_field." from ".$this->table_name." ".$where.$order.$limit;
        return $this->get_one($sql);
    }
    public function fetch_all(){
        $this->_field = $this->_field==''?'*':$this->_field;
        $where = $this->_where?' where '.$this->_where:'';
        $limit = $this->_limit?' limit '.$this->_limit:'';
        $order = $this->_order?' order by '.$this->_order:'';
        $primary = $this->_primary?$this->_primary:'';
        $sql = "select ".$this->_field." from ".$this->table_name." ".$where.$order.$limit;
        return $this->get_all($sql,$primary);
    }
//------------------删除-----------------------------
    public function delete(){
        $where = $this->_where?' where '.$this->_where:'';
        $order = $this->_order?' order by '.$this->_order:'';
        $limit = $this->_limit?' limit '.$this->_limit:'';
        $sql = "delete from ".$this->table_name." ".$where.$order.$limit;
        // 普通模式
        if($this->safe_type==0){
            return $this->query($sql);
        }else{
            // stmt模式
            $stmt = $this->stmt_query($sql);
            if($stmt->affected_rows>=1){
                return true;
            }else{
                return false;
            }
        }
    }
//------------------插入-----------------------------
    public function insert(&$data = ''){
        if(is_array($data)){
            foreach($data as $key=>$val){
                $keys[] = $key;
                $vals[] = $val;
            }
            $sql = 'insert into '.$this->table_name.' (';
            foreach($keys as $key){
                $sql .= '`'.$key.'`,';
            }
            $sql = trim($sql ,',').') values (';
            // stmt 模式
            if($this->safe_type==1){
                foreach($vals as $val){
                    $sql .= "?,";
                }
                $sql = trim($sql ,',').')';
                $this->stmt_query($sql,$data);
            }else{
                // 正常模式
                foreach($vals as $val){
                    if(is_string($val)){
                        $sql .= "'".$val."',";
                    }else{
                        $sql .= $val.",";
                    }
                }
                $sql = trim($sql ,',').')';
                $this->result = $this->query($sql);
            }
            return $this->insert_id();
        }else{
            return false;
        }
    }
    public function stmt_insert($data){
        $this->safe_type = 1;
        $this->insert($data);
    }
//------------------更新-----------------------------
    public function update(&$data = ''){
        $where = $this->_where ? ' where '. $this->_where : '';
        if(is_array($data)){
            $sql = 'update '.$this->table_name.' set ';
            // stmt 模式
            if($this->safe_type==1){
                foreach($data as $key=>$val){
                    if(is_string($val)){
                        $sql .= "`".$key."`=?,";
                    }else{
                        $sql .= "`".$key."`=?,";
                    }
                }
                $sql = trim($sql ,',').$where;
                return $this->stmt_query($sql,$data);
            }else{
                // 正常模式
                foreach($data as $key=>$val){
                    if(is_string($val)){
                        $sql .= "`".$key."`='".$val."',";
                    }else{
                        $sql .= "`".$key."`=".$val.",";
                    }
                }
                $sql = trim($sql ,',').$where;
                return $this->query($sql);
            }
        }else{
            return false;
        }
    }
//------------------连缀参数操作-----------------------------
    public function where($sql=''){
        $sql = trim($sql);
        if($sql != ''){
            $sql = preg_replace("/^and/" , "" , $sql);
        }
        $this->_where = $sql;
        return $this;
    }
    public function limit($limit=''){
        $this->_limit = $limit;
        return $this;
    }
    public function fields($string=''){
        $this->_field = $string;
        return $this;
    }
    public function primary($primary=''){
        $this->_primary = $primary;
        return $this;
    }
    public function order($order=''){
        $this->_order = $order;
        return $this;
    }
    public function parameters($param=''){
        $this->_parameters = $param;
        return $this;
    }
    public function table($table_name=''){
        $this->table_name = $this->dbpre.$table_name;
        return $this;
    }
    public function paramType($param){
        $this->paramType = $param;
        return $this;
    }
//------------------数组conditions操作-----------------------------
    public function conditions( $array = array() ){
        $whereFlag = 0;
        if( !empty($array) ){
            foreach($array as $key => $val){
                switch( $key ){
                    case 'table':
                        $this->table_name = $this->dbpre.$val;
                        break;
                    case 'fields':
                        $this->_field = $val;
                        break;
                    case 'limit':
                        $this->_limit = $val;
                        break;
                    case 'order':
                        $this->_order = $val;
                        break;
                    default:
                        if( $whereFlag == 0){
                            $whereFlag = 1;
                        }else{
                            $_and = ' and ';
                        }
                        // 字符串
                        if(is_string($val)){
                            $this->_where .= $_and.$key."='".$val."'";
                        }else{
                            $this->_where .= $_and.$key."=".$val;
                        }
                        break;
                }
            }
        }
        return $this;
    }
//------------------插入的ID-----------------------------
    public function insert_id(){
        return $this->conn->insert_id;
    }
//------------------每句sql完成后的记录-----------------------------
    function recordOneResult($start_time){
        $this->query_number++;
        $end_time = $this->time_used();
        $this->query_times += round($end_time - $start_time,5);// 查询时间累加
        $this->_where = $this->_limit = $this->_field = $this->_order = $this->_primary = $this->_parameters = $this->paramType ='';
    }
//------------------开销时间-----------------------------
    function time_used(){
        $time = explode(" ",microtime());
        $used_time = $time[0] + $time[1];
        return $used_time;
    }

//------------------注销-----------------------------
    public function close(){
        if(is_resource($this->conn)){
            return $this->conn->close();
        }else{
            return true;
        }
    }
    function __destruct() {
        $this->close();
    }
//------------------错误显示-----------------------------
    private function show_error($error,$sql = ''){
        if(DB_SHOW_ERROR==1){
            echo 'MYSQL_ERROR:'.$error.' on ('.$sql.')';
            exit;
        }
    }
//-------------------数据库版本-----------------------------
    private function version(){
        return mysqli_get_client_version();
    }
//------------------PHP 5.3.0 BUG 处理-----------------------------
    function refValues($arr){
        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
            $refs = array();
            foreach($arr as $key => $value){
                $refs[$key] = &$arr[$key];
            }
            return $refs;
        }
        return $arr;
    }
}
?>