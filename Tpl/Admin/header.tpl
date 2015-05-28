<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>后台管理系统</title>
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
        	<a class="brand topTitle span2" href="javascript:;">管理中心</a>
            <ul class="nav">
            	<li><a href="/" target="_blank">网站预览</a></li>
                <li class="divider-vertical"></li>
                <li {php echo $module=='config'||$module=='nav'?' class="active"':'';}><a href="Admin-Config-classList.html">网站设置</a></li>
                <li class="divider-vertical"></li>
                <li {php echo $module=='goods'||$module=='attribute'?' class="active"':'';}><a href="Admin-Goods-goodsList.html">商品管理</a></li>
                <li class="divider-vertical">
                <li {php echo $module=='order'?' class="active"':'';}><a href="Admin-Order-orderList.html">订单管理</a></li>
                <li class="divider-vertical"></li>
                <li {php echo $module=='integral'?' class="active"':'';}><a href="Admin-Integral-orderList.html">积分兑换</a></li>
                <li class="divider-vertical"></li>
                <!--<li {php echo $module=='user2'?' class="active"':'';}><a href="javascript:;">财务管理</a></li>
                <li class="divider-vertical"></li>-->
                <li {php echo $module=='user'?' class="active"':'';}><a href="Admin-User-userList.html">会员管理</a></li>
                <li class="divider-vertical"></li> 
                <li {php echo $module=='news'?' class="active"':'';}><a href="Admin-News-newsList.html">页面管理</a></li>
                <li class="divider-vertical"></li>
                <li {php echo $module=='ads'?' class="active"':'';}><a href="Admin-Ads-adsList.html">广告管理</a></li>
                <li class="divider-vertical"></li>
                <li {php echo $module=='stat'?' class="active"':'';}><a href="Admin-Stat-index.html">站点统计</a></li>
                <li class="divider-vertical"></li>
                <li><a href="Admin-Index-logout.html">注销</a></li>
            </ul>
        </div>
    </div>
    <div class="myHline"></div>
</div>