<form action="/Admin-Upload-thumbsave.html" method="post" enctype="multipart/form-data" target="iframeUpload">
	<input type="hidden" name="positon" value="{$_POST['positon']}"/>
    <input type="hidden" name="thumb_type" value="{$_POST['thumb_type']}"/>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableoutline">
        <tr class="tb_head">
            <td width="21%" height="30" bgcolor="#D6E9F3"><strong>上传图片:</strong></td>
            <td width="79%" bgcolor="#D6E9F3">
            <a href="javascript:hideupload()"><img src="/Static/images/close.gif" name="hide_upload" align="right" id="hide_upload"></a>
             </td>
        </tr>
        <tr class="firstalt">
            <td height="35" align="right" bgcolor="#F5FCFF">选择图片：</td>
            <td bgcolor="#F5FCFF">
            <input type="file" name="attach[]" size="41" style="width:320px;" class="btn2" id="attach[]">
            &nbsp;
            <input  type="submit" name="submit"  value="开始上传" class="btn" onClick="hideupload()"/>
            </td>
        </tr>
    </table>
</form>