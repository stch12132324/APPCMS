<?php
class IndexAction extends Action{
	public function index(){
		$this->display("login");
	}
	public function doLogin(){
		$db = LC("db_mysqli");
		$db->safe_type = 1;
		$sql = "select `adminid`,`username` from bm_admin where username=? and password=?";
		$rlt = $db->parameters("ss,".$_POST['username'].",".md5(PASSWORD_KEY.$_POST['password']))->get_one($sql);
		if(empty($rlt)){
			$msg = "�û�����������󣬵�¼ʧ�ܣ�";
			$this->display("login");
			//ʧ�ܵ�LOG
			//$this->showmsg('��¼ʧ�ܣ��û������������!',"admin.php?file=login");
		}else{
			session_start();
			$_SESSION['adminid'] = $rlt['adminid'];
			$_SESSION['adminuser']	= $rlt['username'];
			adminShowMsg('��¼�ɹ�!',"/Admin-Order-orderList.html");
		}	
	}
	public function logout(){
		session_start();
		session_destroy();
		adminShowMsg('ע���ɹ�',"/Admin-Index.html");
	}
}
?>