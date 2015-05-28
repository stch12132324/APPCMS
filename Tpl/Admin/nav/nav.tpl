<!--{php require template("header",'','Admin')}-->
<script src="/Static/admin/js/validator.js"></script>
<script>
$(function(){
	$(".navClass").change(function(){
		if($(this).val()==3){
			$(".nav_parent").show();	
		}else{
			$(".nav_parent").hide();
		}
	});
})
</script>
<div class="container-fluid">
    <div class="row-fluid">
    	<!--{php require template("left",'','Admin')}-->
        <div class="span10 mBody">
        	<!--{php require template("headerMenu",'','Admin')}-->
            <div class="mContainer">
            	<form action="Admin-Nav-navSave.html" method="post" id="myform" name="myform">
                <input type="hidden" name="id" value="{$id}" />
 				<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="12%"><!--{php echo $action=='add'?'添加':'修改';}-->导航</th>
                            <th width="88%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>导航位置：</td>
                            <td>
                                <select name="info[nav_class]" class="span2 navClass">
                                    <option value="">请选择位置</option>
                                    <option value="1" <?php echo $result['nav_class']==1?'selected':'';?>>顶部导航</option>
                                    <option value="2" <?php echo $result['nav_class']==2?'selected':'';?>>网站导航</option>
                                    <option value="3" <?php echo $result['nav_class']==3?'selected':'';?>>底部导航</option>
                                </select>
                            </td>
                        </tr>
                        <tr style="display:none" class="nav_parent">
                            <td>上级导航：</td>
                            <td>
                                <select name="info[nav_parentid]" class="span2">
                                    <option value="">请选择</option>
                                    <!--{loop $parentNavList $key $li}-->
                                    <option value="{$li['id']}">{$li['nav_name']}</option>
                                    <!--{/loop}-->
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>导航名称：</td>
                            <td><input class="span3" name="info[nav_name]" value="{$result['nav_name']}" type="text" require="true" datatype="require" msg="请填写"></td>
                        </tr>
                        <tr>
                            <td>链接地址：</td>
                            <td><input class="span4" name="info[nav_url]" value="{$result['nav_url']}" type="text"></td>
                        </tr>
                        <tr>
                            <td>排序：</td>
                            <td><input type="input" name="info[nav_order]"  value="{php echo $result['nav_order']==''?99:$result['nav_order']}" class="span1"></td>	
                        </tr>
                        <tr>
                            <td>显示：</td>
                            <td><input type="checkbox" name="info[nav_status]" <?php echo $result['nav_status']==1?'checked':'';?>>&nbsp;</td>	
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" class="btn btn-primary" value=" 提 交 "/>
                                <input type="button" class="btn" onclick="goBack()" value=" 返 回 "/></td>
                        </tr>
                    </tbody>
                </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$('#myform').checkForm();
</script>
</body>
</html>