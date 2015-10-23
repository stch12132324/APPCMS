<?php
/*
 * Base
 *
 */
class Base{
    public $_action;	// app.class.php 初始化时候就会注入
    public $_module;	// 同上
    public $_group;		// 同上
    public $_log;		// 同上
    public $_filter;
    public $db;  // 数据库操作默认对象
    public $dbs; // 数据库操作对象组
    public $redis;

    /*
    * Mysql Base 部分 ------------------------------------------------------
    */
    public function _init_mysql($dname = 'default'){
        if(is_array($dname)){
            foreach($dname as $dn){
                $this->sdb($dn);
            }
        }else{
            $this->sdb($dname);
        }
    }
    //@ set某个数据库对象 , 也做了单对象处理（简单单例）
    public function sdb($dname){
        if( !is_object($this->dbs[$dname]) ){
            $this->dbs[$dname] = LC("db_mysqli" , $dname);
            // 兼容旧版 默认 $this->db
            if( $dname =='default' ){
                $this->db = &$this->dbs[$dname];
            }
        }
    }
    //@ 数据库多组时，选定某个数据库对象，不填则用$this->db 否则 $this->dbd('aa')
    public function cdb($dname = 'default'){
        return $this->dbs[$dname];
    }


    /*
    * Redis Base 部分 ------------------------------------------------------
    */
    public function _init_redis(){
        if(!is_object($this->redis)){
            $this->redis = LC("myRedis");
        }
    }

    /*
    * Cache Base 部分 ------------------------------------------------------
    */
    public function Cache( $type = 'file' ){
        $cache = LC("Cache");
        $cache->type = $type;
        return $cache;
    }
    /*
    * 传值过滤 ------------------------------------------------------
    */
    // POST传值过滤
    public function getPost($keyName='' , $filterTypeArr = array()){
        $val = isset($_POST[$keyName]) ? $_POST[$keyName] : '';
        if(!empty($filterTypeArr)){
            if( is_array($val) ){
                $arr = array();
                foreach($val as $key=>$v){
                    $arr[$key] = $this->actionFilter($v , $filterTypeArr);
                }
                $val = $arr;
            }else{
                $val = $this->actionFilter($val , $filterTypeArr);
            }
        }
        return $val;
    }

    /*
    * GET传值过滤
    */
    public function getGet($keyName='' , $filterTypeArr = array()){
        $val = isset($_GET[$keyName]) ? $_GET[$keyName] : '';
        if(!empty($filterTypeArr)){
            $val = $this->actionFilter($val , $filterTypeArr);
        }
        return $val;
    }

	/*
	* 总传值过滤
	*/
	public function getParams($keyName='' , $filterTypeArr = array()){
        $val = isset($_GET[$keyName]) ? $_GET[$keyName] : '';
        if( $val =='' ){
		    $val = isset($_POST[$keyName]) ? $_POST[$keyName] : '';
        }
        if(!empty($filterTypeArr)){
            $val = $this->actionFilter($val , $filterTypeArr);
        }
        return $val;
    }

    /*
    * post 和 get 过滤直接替换，与判断类型有区别
    */
    private function actionFilter($val ='' , $filterTypeArr= '')
    {
        if(is_array($filterTypeArr)){
            foreach($filterTypeArr as $type){
                $val = $this->getFilterVal($val , $type);
            }
        }else{
            $val = $this->getFilterVal($val , $filterTypeArr);
        }
        return $val;
    }

    private  function getFilterVal($val='' , $type='')
    {
        switch($type){
            case 'int':
                $val = preg_replace("/[^0-9]/isU", "" , $val);
                $val = intval($val);
                break;
            case 'alphanum':
                $val = preg_replace("/[^a-zA-Z0-9_]/isU" , "" , $val);
                break;
            case 'striptags':
                $val = strip_tags($val);
                break;
            case 'trim':
                $val = trim($val);
                break;
            case 'lower':
                $val = strtolower($val);
                break;
            case 'upper':
                $val = strtoupper($val);
                break;
        }
        return $val;
    }
}
?>