<?php
require "include/common.inc.php";
$db = load("db_mysqli");
//$db->safe_type = 1; //�Ƿ�ʼstmtģʽ��stmt ģʽ���һЩ

//------��ͨ��ȡ����
//$result = $db->get_all("select * from bm_nav");

//------��ͨ��ȡһ��
//$result = $db->get_one("select * from bm_nav");

//------��ͨ����
//$db->query("insert into bm_attribute (`att_name`,`att_parentid`) values ('��ɫ','0')");
//echo $db->insert_id();

//------��ͨ����
//echo $db->insert("insert into bm_attribute (`att_name`,`att_parentid`) values ('��ɫ','0')");
 
 
 
//------ �߼�insert ��ͨģʽ
/*
$data = array('att_name'=>'��ɫ','att_parentid'=>0);
$result = $db->table("attribute")->insert($data);
*/

//------ �߼�insert stmtģʽ
/*
$db->safe_type = 1;
$data = array('att_name'=>'��ɫ','att_parentid'=>0);
$result = $db->table("attribute")->paramType('si')->insert($data);
*/

//------ �߼�update ��ͨģʽ
/*
$data = array('att_name'=>'����','att_parentid'=>2);
$result = $db->table("attribute")->where("att_id=60")->update($data);
*/

//------ �߼�update stmtģʽ
/*
$db->safe_type = 1;
$data = array('att_name'=>"��ɫ",'att_parentid'=>0);
$result = $db->table("attribute")->paramType("si")->where("att_id=?")->parameters("i,60")->update($data);
*/


//------ �߼�query ��ͨģʽ
/*
$result = $db->fields('att_name,att_parentid')->where("att_parentid=0")->limit("0,10")->fetch();
$result = $db->table("attribute")->where("att_parentid=0")->limit("0,10")->fetch();
*/

//------ �߼���ѯfetch stmtģʽ 
/*
$db->safe_type = 1;
$result = $db->table("attribute")->where("att_parentid=?")->parameters("i,0")->limit("1")->fetch();
*/

//------ �߼���ѯfetch ��ͨģʽ 

//$result = $db->table("attribute")->where("att_parentid=0")->limit("1")->fetch();



//------ �߼���ѯfetch_all ��ͨģʽ 
/*
$result = $db->table("attribute")->where("att_parentid=0")->limit("5")->order("att_id desc")->fetch_all();
*/

//------ �߼���ѯfetch_all stmt ģʽ 
/*
$db->safe_type = 1;
$result = $db->table("attribute")->where("att_parentid=?")->parameters("i,0")->limit("5")->order("att_id desc")->fetch_all();
*/

//------ �߼� delete ��ͨģʽ 
/*
$result = $db->table("attribute")->where("att_id=4")->delete();
*/

//------ �߼� delete stmtģʽ 
/*
$db->safe_type = 1;
$result = $db->table("attribute")->where("att_id=?")->parameters("i,10")->delete();
*/


//------- ��ȫ���� stmt queryģʽ
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