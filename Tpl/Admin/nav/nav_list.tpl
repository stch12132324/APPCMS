<!--{php require template("header",'','Admin')}-->
<script src="/Static/admin/js/nav-list.js"></script>
<div class="container-fluid">
    <div class="row-fluid">
    	<!--{php require template("left",'','Admin')}-->
        <div class="span10 mBody">
        	<!--{php require template("headerMenu",'','Admin')}-->
            <div class="mContainer">
            	<form action="" method="post">
            		<b>�����б�:</b>&nbsp;&nbsp;
                    <a class="btn" href="Admin-Nav-navAdd.html"><i class="icon-plus"></i> ���</a>&nbsp;&nbsp;
                	<select class="span2" name="stype">
                        <option value="">���е���</option>
                        <option value="1" {php echo $stype==1?'selected':'';}>��������</option>
                        <option value="2" {php echo $stype==2?'selected':'';}>��վ����</option>
                        <option value="3" {php echo $stype==3?'selected':'';}>�ײ�����</option>
                    </select>
                </form>
				<form action="admin.php?file=article_class&action=order" method="post" name="myform">
					<table class="table table-bordered">
	                    <thead>
	                        <tr>
	                            <th width="10%" class="txtcenter">ID</th>
	                            <th width="20%">����</th>
                                <th width="20%">���ӵ�ַ</th>
                                <th width="10%">λ��</th>
	                            <th width="10%">����</th>
                                <th width="10%">��ʾ / ����</th>
                                <th width="10%">����</th>
                                <th width="10%" class="txtcenter">����</th>
	                        </tr>
	                    </thead>
	                    <!--{loop $navList $key $li}-->
                        <tr>
                            <td class="txtcenter"><!--{$li['id']}--></td>
                            <td><!--{$li['nav_name']}--></td>
                            <td><!--{$li['nav_url']}--></td>
                            <td><!--{php echo $li['nav_class']==1?'��������':($li['nav_class']==2?'��վ����':'�ײ�����');}--></td>
                            <td><!--{$li['nav_parentid']}--></td>
                            <td><span class="showNav {$li['id']} label <?php echo $li['nav_status']==1?'label-success':'';?>"><!--{php echo $li['nav_status']==1?'��ʾ':'����';}--></span>&nbsp;</td>
                            <td><input type="text" name="order-{$li['id']}" value="{$li['nav_order']}" class="span1 orders"></td>
                            <td class="txtcenter">
								<a href="/Admin-Nav-navEdit-id-{$li['id']}.html"><i class="icon-list-alt" rel="�༭"></i></a>
								<a><i class="icon-trash {$li['id']}" rel="ɾ��"></i></a>
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