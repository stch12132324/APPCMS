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