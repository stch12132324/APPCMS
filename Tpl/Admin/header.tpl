<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>��̨����ϵͳ</title>
<link  href="/Static/admin/css/bootstrap.css" rel="stylesheet">
<link href="/Static/admin/css/main.css" rel="stylesheet">
<script type="text/javascript" src="/Static/js/jquery-1.4.2.min.js"></script>
<script src="/Static/js/artDialog/artDialog.js?skin=lt"></script>
<script src="/Static/admin/js/common.js"></script>
</head>
<body>
<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
        	<a class="brand topTitle span2" href="javascript:;">��������</a>
            <ul class="nav">
            	<li><a href="/" target="_blank">��վԤ��</a></li>
                <li class="divider-vertical"></li>
                <li {php echo $module=='config'||$module=='nav'?' class="active"':'';}><a href="Admin-Config-classList.html">��վ����</a></li>
                <li class="divider-vertical"></li>
                <li {php echo $module=='goods'||$module=='attribute'?' class="active"':'';}><a href="Admin-Goods-goodsList.html">��Ʒ����</a></li>
                <li class="divider-vertical">
                <li {php echo $module=='order'?' class="active"':'';}><a href="Admin-Order-orderList.html">��������</a></li>
                <li class="divider-vertical"></li>
                <li {php echo $module=='integral'?' class="active"':'';}><a href="Admin-Integral-orderList.html">���ֶһ�</a></li>
                <li class="divider-vertical"></li>
                <!--<li {php echo $module=='user2'?' class="active"':'';}><a href="javascript:;">�������</a></li>
                <li class="divider-vertical"></li>-->
                <li {php echo $module=='user'?' class="active"':'';}><a href="Admin-User-userList.html">��Ա����</a></li>
                <li class="divider-vertical"></li> 
                <li {php echo $module=='news'?' class="active"':'';}><a href="Admin-News-newsList.html">ҳ�����</a></li>
                <li class="divider-vertical"></li>
                <li {php echo $module=='ads'?' class="active"':'';}><a href="Admin-Ads-adsList.html">������</a></li>
                <li class="divider-vertical"></li>
                <li {php echo $module=='stat'?' class="active"':'';}><a href="Admin-Stat-index.html">վ��ͳ��</a></li>
                <li class="divider-vertical"></li>
                <li><a href="Admin-Index-logout.html">ע��</a></li>
            </ul>
        </div>
    </div>
    <div class="myHline"></div>
</div>