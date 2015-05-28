<?php
require "../../include/common.inc.php";

$c_random = get12random();
$result = $db->get_one("select id from bm_pay_rand_number where pay_rand_number='".$c_random."'");
if(!empty($result)){
	$c_random = get12random();	
}
$db->query("insert into bm_pay_rand_number (`pay_rand_number`,`uid`) values ('".$c_random."','".get_session('bj_uid')."')");
//------------------------ Test --------------------------------//
$myuid = get_session('bj_uid');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
	<title>支付宝即时到账交易接口接口</title>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
    <LINK href="../skin/css/memcss.css" type=text/css rel=stylesheet>
<style>
*{margin:0;padding:0;font-size:12px;}
body{padding:10px;font-family:'Microsoft YaHei',Tahoma,Helvetica,'宋体',Arial;}
ul,ol{list-style:none;}
.title{color: #ADADAD;font-size: 14px;font-weight: bold;padding: 8px 16px 5px 10px;}
.hidden{display:none;}
.new-btn-login-sp{padding:1px;display:inline-block;}
.new-btn-login{background-color: transparent;background-image: url("images/new-btn-fixed.png");border: medium none;border:1px solid #D74C00;}
.new-btn-login{background-position: 0 -198px;width: 82px;color: #FFFFFF;font-weight: bold;height: 28px;line-height: 28px;padding: 0 10px 3px;}
.new-btn-login:hover{background-position: 0 -167px;width: 82px;color: #FFFFFF;font-weight: bold;height: 28px;line-height: 28px;padding: 0 10px 3px;}
.bank-list{overflow:hidden;margin-top:5px;}
.bank-list li{float:left;width:153px;margin-bottom:5px;}
#main{width:95%px;margin:0 auto;font-size:14px;}
#logo{background-color: transparent;background-image: url("images/new-btn-fixed.png");border: medium none;background-position:0 0;width:166px;height:35px;float:left;}
.red-star{color:#f00;width:10px;display:inline-block;}
.null-star{color:#fff;}
.content{width:100%;margin-top:5px;float:left}
.content dt{width:130px;display:inline-block;text-align:right;float:left;}
.content dd{margin-left:100px;margin-bottom:5px;}
#foot{margin-top:10px;}
.foot-ul li {text-align:center;}
.note-help {color: #999999;font-size: 12px;line-height: 22px;padding-left: 3px;}
.cashier-nav {font-size: 14px;margin: 15px 0 10px;text-align: left;height:30px;border-bottom:solid 2px #CFD2D7;}
.cashier-nav ol li {float: left;padding-left:5px;}
.cashier-nav li.current {color: #AB4400;font-weight: bold;font-size:12px;}
.cashier-nav li.last {clear:right;}
.alipay_link{text-align:right;}
.alipay_link a:link{text-decoration:none;color:#8D8D8D;}
.alipay_link a:visited{text-decoration:none;color:#8D8D8D;}
.input{ border:1px solid #CCC;padding:4px;}
#body dt,#body dd{ line-height:22px;height:30px;border-bottom:1px dotted #CCC}
.paybank{width:100%;float:left;}
.paybank td{width:140px;height:40px;text-align:center}
</style>
<script>
var submit_flag = 0;
function doSubmit(){
	if(submit_flag==0){
		alipayment.submit();
		submit_flag = 1;
	}else{
		alert("您已经提交过订单了！");
		window.parent.location.href="/userCenter/admin.php?file=account&action=cash";
	}
}
//------屏蔽右键--------
if (window.Event) document.captureEvents(Event.MOUSEUP); 
function nocontextmenu() {
	event.cancelBubble = true
	event.returnValue = false;
	return false;
}
function norightclick(e) {
	if (window.Event) {
		if (e.which == 2 || e.which == 3) return false;
	}
	else
  		if (event.button == 2 || event.button == 3){
		event.cancelBubble = true
		event.returnValue = false;
		return false;
	}
 
}
document.oncontextmenu = nocontextmenu;
document.onmousedown = norightclick;
</script>
</head>
<body text=#000000 bgColor=#ffffff leftMargin=0 topMargin=4>
温馨提示:
<font color="#FF0000">当你支付完成后(在线支付)请即时查看您的金额信息，已确认您的金额到户。联系电话:&nbsp;0592-5505028或18950032563&nbsp;&nbsp;联系QQ:&nbsp;712699019</font><br>
	<div id="main">
        <div class="cashier-nav">
            <ol>
				<li class="current">1、确认信息 -> </li>
				<li> 2、点击确认 -> </li>
				<li class="last">3、确认完成</li>
            </ol>
        </div>
        <form name="alipayment" action="alipayapi.php" method="post" target="_blank">
            <div id="body" style="clear:left">
                <dl class="content">
                    <dt>卖家支付宝帐户：</dt>
                    <dd>
                        <span class="null-star">*</span>
                        <input type="hidden" size="30" name="WIDseller_email" value="394630111@qq.com" readonly="readonly"/>
                        <span>
</span>
                    </dd>
                    <dt>商户订单号：</dt>
                    <dd>
                        <span class="null-star">*</span>
                        <input size="30" name="WIDout_trade_no" class="input" value="<?php echo $c_random;?>" readonly="readonly"/>
                        <span></span>
                    </dd>
                    <dt>订单名称：</dt>
                    <dd>
                        <span class="null-star">*</span>
                        <input size="30" name="WIDsubject" class="input" value="3135 ID<?php echo $myuid?> 在线充值" readonly="readonly"/>
                        <span>
</span>
                    </dd>
                    <dt>付款金额：</dt>
                    <dd>
                        <span class="null-star">*</span>
                        <input size="30" name="WIDtotal_fee" class="input" value="<?php echo $pay_money?>" readonly="readonly"/>
                        <span>元
</span>
                    </dd>
                    <dt>订单描述
：</dt>
                    <dd>
                        <span class="null-star">*</span>
                        <input size="30" name="WIDbody" class="input" value="3135在线充值" readonly="readonly"/>
                        <span></span>
                    </dd>
                    <dt>网站地址：</dt>
                    <dd>
                        <span class="null-star">*</span>
                        <input size="30" name="WIDshow_url" class="input" value="http://www.3135.com" readonly="readonly"/>
                        <span></span>
                    </dd>
                    <dt>客户端的IP地址：</dt>
                    <dd>
                        <span class="null-star">*</span>
                        <input size="30" name="WIDexter_invoke_ip" class="input" value="<?php echo IP;?>" readonly="readonly"/>
                    </dd>
                    <dt style="height:220px; float:left">默认网银:</dt>
                    <dd style="height:220px;margin-left:0px; float:left">
                        <div class="paybank">
                        <table width="560">
                            <tr>
                            <td><input type="radio" name="WIDdefaultbank" value="directPay" checked> <img src="images/alipay_1.gif" border="0"/></td>
                            <td colspan="10">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="WIDdefaultbank" value="ICBCB2C"/> <img src="images/ICBC_OUT.gif" border="0"/></td>
                                <td><input type="radio" name="WIDdefaultbank" value="CMB"/> <img src="images/CMB_OUT.gif" border="0"/></td>
                                <td><input type="radio" name="WIDdefaultbank" value="CCB"/> <img src="images/CCB_OUT.gif" border="0"/></td>
                                <td><input type="radio" name="WIDdefaultbank" value="BOCB2C"> <img src="images/BOC_OUT.gif" border="0"/></td>
                            </tr>
                            <tr>
                            	<td><input type="radio" name="WIDdefaultbank" value="ABC"/> <img src="images/ABC_OUT.gif" border="0"/></td>  
                            	<td><input type="radio" name="WIDdefaultbank" value="COMM"/> <img src="images/COMM_OUT.gif" border="0"/></td>
                                <td><input type="radio" name="WIDdefaultbank" value="SPDB"/> <img src="images/SPDB_OUT.gif" border="0"/></td>
                                <td><input type="radio" name="WIDdefaultbank" value="GDB"> <img src="images/GDB_OUT.gif" border="0"/></td>
                            </tr>
                            <tr>
                            	<td><input type="radio" name="WIDdefaultbank" value="CITIC"/> <img src="images/CITIC_OUT.gif" border="0"/></td>
                                <td><input type="radio" name="WIDdefaultbank" value="CEBBANK"/> <img src="images/CEB_OUT.gif" border="0"/></td>
                            	<td><input type="radio" name="WIDdefaultbank" value="CIB"/> <img src="images/CIB_OUT.gif" border="0"/></td>
                                <td><input type="radio" name="WIDdefaultbank" value="SDB"> <img src="images/SDB_OUT.gif" border="0"/></td>
                            </tr>
                            <tr>
                            	<td><input type="radio" name="WIDdefaultbank" value="CMBC"/> <img src="images/CMBC_OUT.gif" border="0"/></td>
                                <td><input type="radio" name="WIDdefaultbank" value="SPABANK"/> <img src="images/SPABANK_OUT.gif" border="0"/></td>
                                <td><input type="radio" name="WIDdefaultbank" value="PSBC-DEBIT"/> <img src="images/PSBC_OUT.gif" border="0"/></td>
                            </tr>
                        </table>
                        </div>
                    </dd>
                </dl>
                <div style="width:100%;">
                	<div style="width:100%;padding-top:10px;text-align:center;float:left;border-top:1px dotted #454545;">
                    <span class="new-btn-login-sp">
                        <button class="new-btn-login" id="submitt" type="button" onclick="doSubmit()" style="text-align:center;cursor:pointer">确 认</button>
                    </span>
                    <span class="new-btn-login-sp" style="margin-left:10px;">
                    <button class="new-btn-login" style="cursor:pointer" type="button" onclick="window.parent.location.href='/userCenter/admin.php?file=account&action=cash'">返回</button>
                    </span>
                    </div>
                    <div style="clear:both"></div>
                </div>
            </div>
		</form>
	</div>
</body>
</html>