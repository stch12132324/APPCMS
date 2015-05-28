<?php
IA("AdminBaseAction","Admin");
class NavAction extends AdminBaseAction{
	public function __construct(){
		parent::__construct();
		$this->config_class_list = $this->db->table("config_class")->fields("class_id,class_name")->order("class_order asc")->fetch_all();
		$this->assign('config_class_list',$this->config_class_list);
	}
	/*
	@ 添加导航
	*/
	public function navAdd(){
		$this->assign('parentNavList',$this->db->select("select id,nav_name from ".DB_PRE."nav where nav_class=3 and nav_parentid=0 order by nav_order asc"));
		$this->display("nav");
	}
	public function navSave(){
		$info = $_POST['info'];
		$info['nav_status'] = $info['nav_status']?1:0;
		$id = intval($_POST['id']);
		if($id==''){
			$this->db->table('nav')->insert($info);	
		}else{
			$this->db->table('nav')->where("id=".$id)->update($info);	
		}
		adminShowMsg("操作成功","/Admin-Nav-navList.html");
	}
	public function navEdit(){
		$id = intval($_GET['id']);
		$this->assign("id",$id);
		$this->assign("result",$this->db->get_one("select * from ".DB_PRE."nav where id=".$id));
		$this->display("nav");
	}
	/*
	@导航列表
	*/
	public function navList(){
		$this->assign("navList",$this->db->select("select id,nav_name,nav_url,nav_class,nav_order,nav_status,nav_parentid from ".DB_PRE."nav where nav_parentid=0 order by nav_order asc"));
		$this->display("nav_list");
	}
	/*
	@ 排序
	*/
	public function navOrder(){
		$oid = intval($_GET['oid']);
		$data = array('nav_order'=>intval($_GET['order']));
		if($this->db->table('nav')->where(" id=".$oid)->update($data)){
			echo 1;	
		}else{
			echo 0;	
		}
	}
	/*
	@ 显示隐藏
	*/
	public function doShow(){
		$sid = intval($_GET['sid']);
		$rlt = $this->db->get_one("select nav_status from ".DB_PRE."nav where id=".$sid);
		$status = $rlt['nav_status']==1?0:1;
		$data = array('nav_status'=>$status);
		if($this->db->table('nav')->where("id=".$sid)->update($data)){
			echo 1;	
		}else{
			echo 99;	
		}
	}
	/*
	@ 删除导航
	*/
	public function navDelete(){
		$did = intval($_GET['did']);
		if($did!=0){
			if($this->db->query("delete from ".DB_PRE."nav where id=".$did)){
				echo 1;	
			}else{
				echo 0;
			}
		}else{
			echo 0;	
		}
	}
}
?>