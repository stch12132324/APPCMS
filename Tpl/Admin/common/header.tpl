<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>后台管理系统</title>
<link  href="/Static/admin/css/bootstrap.css" rel="stylesheet">
<link href="/Static/admin/css/main.css" rel="stylesheet">
<script type="text/javascript" src="/Static/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/Static/js/jquery.cookie.js"></script>
<script src="/Static/js/artDialog/artDialog.js?skin=lt"></script>
<script src="/Static/admin/js/common.js"></script>
</head>
<body>
<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
        	<a class="brand topTitle span2" href="javascript:;">管理中心</a>
            <ul class="nav">
                <li>
                    <a href="/" target="_blank">首页浏览</a>
                </li>
                <li class="divider-vertical"></li>
                <!--{loop $menuList $key $menu}-->
                <li {php echo $module == $menu['func']['funcs_title'] ? ' class="active"':'';}>
                    <a href="javascript:;" target="_blank"><!--{$menu['func']['funcs_name']}--></a>
                    <ul class="dropdown-menu">
                        <!--{loop $menu['action'] $key $action}-->
                        <li rel="/Admin-{$menu['func']['funcs_title']}-{$menu['func']['funcs_title']}{ucfirst(str_replace('_list' , 'List' , $action['action_title']))}.html"><i class="icon-white {$action['icon']}"></i> <!--{$menu['func']['funcs_name']}--><!--{$action['action_name']}--></li>
                        <!--{/loop}-->
                        <!--{loop $menu['other'] $key $val}-->
                        <li rel="{$val[2]}"><i class="icon-white icon-cog"></i> {$val[0]}</li>
                        <!--{/loop}-->
                    </ul>
                </li>
                <li class="divider-vertical"></li>
                <!--{/loop}-->
                <!--
                <li {php echo $module == 'func' || $module == 'option' ? ' class="active"':'';}>
                    <a href="javascript:;" target="_blank">功能管理</a>
                    <ul class="dropdown-menu">
                        <li rel="/Admin-func-funcList.html"><i class="icon-white icon-cog"></i> 设定功能</li>
                        <li rel="/Admin-option-optionList.html"><i class="icon-white icon-cog"></i> 参数项设置</li>
                    </ul>
                </li>
                <li class="divider-vertical"></li>
                -->
                <li><a href="Admin-Index-logout.html">注销</a></li>
            </ul>
        </div>
    </div>
    <div class="myHline"></div>
</div>