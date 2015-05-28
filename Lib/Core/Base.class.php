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
    public $db;
    public $redis;
    /*
    * Mysql
    */
    public function _init_mysql(){
        if(!is_object($this->db)){
            $this->db = LC("db_mysqli");
        }
    }

    /*
    * Redis
    */
    public function _init_redis(){
        if(!is_object($this->redis)){
            $this->redis = LC("myRedis");
        }
    }

    /*
    * Cache
    */
    public function Cache( $type = 'file' ){
        $cache = LC("Cache");
        $cache->type = $type;
        return $cache;
    }
}
?>