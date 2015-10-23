<?php
/*
 * Base
 *
 */
class Base{
    public $_action;	// app.class.php ��ʼ��ʱ��ͻ�ע��
    public $_module;	// ͬ��
    public $_group;		// ͬ��
    public $_log;		// ͬ��
    public $_filter;
    public $db;  // ���ݿ����Ĭ�϶���
    public $dbs; // ���ݿ����������
    public $redis;

    /*
    * Mysql Base ���� ------------------------------------------------------
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
    //@ setĳ�����ݿ���� , Ҳ���˵��������򵥵�����
    public function sdb($dname){
        if( !is_object($this->dbs[$dname]) ){
            $this->dbs[$dname] = LC("db_mysqli" , $dname);
            // ���ݾɰ� Ĭ�� $this->db
            if( $dname =='default' ){
                $this->db = &$this->dbs[$dname];
            }
        }
    }
    //@ ���ݿ����ʱ��ѡ��ĳ�����ݿ���󣬲�������$this->db ���� $this->dbd('aa')
    public function cdb($dname = 'default'){
        return $this->dbs[$dname];
    }


    /*
    * Redis Base ���� ------------------------------------------------------
    */
    public function _init_redis(){
        if(!is_object($this->redis)){
            $this->redis = LC("myRedis");
        }
    }

    /*
    * Cache Base ���� ------------------------------------------------------
    */
    public function Cache( $type = 'file' ){
        $cache = LC("Cache");
        $cache->type = $type;
        return $cache;
    }
    /*
    * ��ֵ���� ------------------------------------------------------
    */
    // POST��ֵ����
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
    * GET��ֵ����
    */
    public function getGet($keyName='' , $filterTypeArr = array()){
        $val = isset($_GET[$keyName]) ? $_GET[$keyName] : '';
        if(!empty($filterTypeArr)){
            $val = $this->actionFilter($val , $filterTypeArr);
        }
        return $val;
    }

	/*
	* �ܴ�ֵ����
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
    * post �� get ����ֱ���滻�����ж�����������
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