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
            echo $dname;
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
}
?>