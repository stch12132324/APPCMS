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
            echo $dname;
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
}
?>