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
			$msg = "用户名或密码错误，登录失败！";
			$this->display("login");
			//失败的LOG
			//$this->showmsg('登录失败，用户名或密码错误!',"admin.php?file=login");
		}else{
			session_start();
			$_SESSION['adminid'] = $rlt['adminid'];
			$_SESSION['adminuser']	= $rlt['username'];
			adminShowMsg('登录成功!',"/Admin-Order-orderList.html");
		}	
	}
	public function logout(){
		session_start();
		session_destroy();
		adminShowMsg('注销成功',"/Admin-Index.html");
	}
}
?>