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
                            <th width="12%"><!--{php echo $action=='add'?'���':'�޸�';}-->����</th>
                            <th width="88%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>����λ�ã�</td>
                            <td>
                                <select name="info[nav_class]" class="span2 navClass">
                                    <option value="">��ѡ��λ��</option>
                                    <option value="1" <?php echo $result['nav_class']==1?'selected':'';?>>��������</option>
                                    <option value="2" <?php echo $result['nav_class']==2?'selected':'';?>>��վ����</option>
                                    <option value="3" <?php echo $result['nav_class']==3?'selected':'';?>>�ײ�����</option>
                                </select>
                            </td>
                        </tr>
                        <tr style="display:none" class="nav_parent">
                            <td>�ϼ�������</td>
                            <td>
                                <select name="info[nav_parentid]" class="span2">
                                    <option value="">��ѡ��</option>
                                    <!--{loop $parentNavList $key $li}-->
                                    <option value="{$li['id']}">{$li['nav_name']}</option>
                                    <!--{/loop}-->
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>�������ƣ�</td>
                            <td><input class="span3" name="info[nav_name]" value="{$result['nav_name']}" type="text" require="true" datatype="require" msg="����д"></td>
                        </tr>
                        <tr>
                            <td>���ӵ�ַ��</td>
                            <td><input class="span4" name="info[nav_url]" value="{$result['nav_url']}" type="text"></td>
                        </tr>
                        <tr>
                            <td>����</td>
                            <td><input type="input" name="info[nav_order]"  value="{php echo $result['nav_order']==''?99:$result['nav_order']}" class="span1"></td>	
                        </tr>
                        <tr>
                            <td>��ʾ��</td>
                            <td><input type="checkbox" name="info[nav_status]" <?php echo $result['nav_status']==1?'checked':'';?>>&nbsp;</td>	
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" class="btn btn-primary" value=" �� �� "/>
                                <input type="button" class="btn" onclick="goBack()" value=" �� �� "/></td>
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