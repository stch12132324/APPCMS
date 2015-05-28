<?php
class AdminBaseAction extends Action{
	public $adminid;
	public $adminuser;
	public $db;
	function __construct(){
		parent::__construct();
		$this->_init();
	}
	private function _init(){
		session_start();
		$this->adminid = $_SESSION['adminid'];
		if($this->adminid==''){
			header('Location:Admin-Index.html');
			exit;
		}
		$this->adminuser = $_SESSION['adminuser'];
		// ��ʼ����̨db����
        $this->db = LC("db_mysqli");
	}	
}
?>