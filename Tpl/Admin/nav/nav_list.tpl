<!--{php require template("header",'','Admin')}-->
<script src="/Static/admin/js/nav-list.js"></script>
<div class="container-fluid">
    <div class="row-fluid">
    	<!--{php require template("left",'','Admin')}-->
        <div class="span10 mBody">
        	<!--{php require template("headerMenu",'','Admin')}-->
            <div class="mContainer">
            	<form action="" method="post">
            		<b>导航列表:</b>&nbsp;&nbsp;
                    <a class="btn" href="Admin-Nav-navAdd.html"><i class="icon-plus"></i> 添加</a>&nbsp;&nbsp;
                	<select class="span2" name="stype">
                        <option value="">所有导航</option>
                        <option value="1" {php echo $stype==1?'selected':'';}>顶部导航</option>
                        <option value="2" {php echo $stype==2?'selected':'';}>网站导航</option>
                        <option value="3" {php echo $stype==3?'selected':'';}>底部导航</option>
                    </select>
                </form>
				<form action="admin.php?file=article_class&action=order" method="post" name="myform">
					<table class="table table-bordered">
	                    <thead>
	                        <tr>
	                            <th width="10%" class="txtcenter">ID</th>
	                            <th width="20%">名称</th>
                                <th width="20%">链接地址</th>
                                <th width="10%">位置</th>
	                            <th width="10%">分类</th>
                                <th width="10%">显示 / 隐藏</th>
                                <th width="10%">排序</th>
                                <th width="10%" class="txtcenter">操作</th>
	                        </tr>
	                    </thead>
	                    <!--{loop $navList $key $li}-->
                        <tr>
                            <td class="txtcenter"><!--{$li['id']}--></td>
                            <td><!--{$li['nav_name']}--></td>
                            <td><!--{$li['nav_url']}--></td>
                            <td><!--{php echo $li['nav_class']==1?'顶部导航':($li['nav_class']==2?'网站导航':'底部导航');}--></td>
                            <td><!--{$li['nav_parentid']}--></td>
                            <td><span class="showNav {$li['id']} label <?php echo $li['nav_status']==1?'label-success':'';?>"><!--{php echo $li['nav_status']==1?'显示':'隐藏';}--></span>&nbsp;</td>
                            <td><input type="text" name="order-{$li['id']}" value="{$li['nav_order']}" class="span1 orders"></td>
                            <td class="txtcenter">
								<a href="/Admin-Nav-navEdit-id-{$li['id']}.html"><i class="icon-list-alt" rel="编辑"></i></a>
								<a><i class="icon-trash {$li['id']}" rel="删除"></i></a>
                            </td>
                        </tr>
                        <!--{/loop}-->
	                </table>
				</form>
            </div>
        </div>
    </div>
</div>
</body>
</html>