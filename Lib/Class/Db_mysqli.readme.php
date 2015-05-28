<?php
require "include/common.inc.php";
$db = load("db_mysqli");
//$db->safe_type = 1; //是否开始stmt模式，stmt 模式会差一些

//------普通获取多列
//$result = $db->get_all("select * from bm_nav");

//------普通获取一列
//$result = $db->get_one("select * from bm_nav");

//------普通插入
//$db->query("insert into bm_attribute (`att_name`,`att_parentid`) values ('颜色','0')");
//echo $db->insert_id();

//------普通插入
//echo $db->insert("insert into bm_attribute (`att_name`,`att_parentid`) values ('颜色','0')");
 
 
 
//------ 高级insert 普通模式
/*
$data = array('att_name'=>'颜色','att_parentid'=>0);
$result = $db->table("attribute")->insert($data);
*/

//------ 高级insert stmt模式
/*
$db->safe_type = 1;
$data = array('att_name'=>'颜色','att_parentid'=>0);
$result = $db->table("attribute")->paramType('si')->insert($data);
*/

//------ 高级update 普通模式
/*
$data = array('att_name'=>'尺码','att_parentid'=>2);
$result = $db->table("attribute")->where("att_id=60")->update($data);
*/

//------ 高级update stmt模式
/*
$db->safe_type = 1;
$data = array('att_name'=>"颜色",'att_parentid'=>0);
$result = $db->table("attribute")->paramType("si")->where("att_id=?")->parameters("i,60")->update($data);
*/


//------ 高级query 普通模式
/*
$result = $db->fields('att_name,att_parentid')->where("att_parentid=0")->limit("0,10")->fetch();
$result = $db->table("attribute")->where("att_parentid=0")->limit("0,10")->fetch();
*/

//------ 高级查询fetch stmt模式 
/*
$db->safe_type = 1;
$result = $db->table("attribute")->where("att_parentid=?")->parameters("i,0")->limit("1")->fetch();
*/

//------ 高级查询fetch 普通模式 

//$result = $db->table("attribute")->where("att_parentid=0")->limit("1")->fetch();



//------ 高级查询fetch_all 普通模式 
/*
$result = $db->table("attribute")->where("att_parentid=0")->limit("5")->order("att_id desc")->fetch_all();
*/

//------ 高级查询fetch_all stmt 模式 
/*
$db->safe_type = 1;
$result = $db->table("attribute")->where("att_parentid=?")->parameters("i,0")->limit("5")->order("att_id desc")->fetch_all();
*/

//------ 高级 delete 普通模式 
/*
$result = $db->table("attribute")->where("att_id=4")->delete();
*/

//------ 高级 delete stmt模式 
/*
$db->safe_type = 1;
$result = $db->table("attribute")->where("att_id=?")->parameters("i,10")->delete();
*/


//------- 完全开放 stmt query模式
/*
$db->safe_type = 1;
$sql = "select * from bm_attribute where att_parentid=?";
$result = $db->parameters("i,0")->get_one($sql);
*/

/*
var_export($result);
echo '<br>query_number:'.$db->query_number;
echo '<br>query_times:'.$db->query_times;
*/
?>