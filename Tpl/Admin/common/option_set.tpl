<!--{php require template("header","common","Admin")}-->
<div class="container-fluid">
    <div id="show_upload" style="display:none;z-index:99"></div>
    <iframe name="iframeUpload" src="" width="350" height="35" frameborder=0  scrolling="no" style="display:none;z-index:99"></iframe>
    <div id="preview" style="position:absolute;display:none;width:100px;height:100px;z-index:99" class="showpic"><img name="pic_a1" id="pic_a1" width="100" height="100"></div>
    <div class="row-fluid">
        <!--{php require template("left","common","Admin")}-->
        <div class="span10 mBody">
            <!--{php require template("headerMenu",'common','Admin')}-->
            <div class="mContainer">
                <form action="/Admin-{$module}-{$module}SetSave.html" method="post" id="myform" name="myform">
                <h4><?php echo $model_info['funcs_name'];?>后台参数</h4>
                <table class="table table-bordered mt10" width="100%" id="td1" border="0" cellspacing="0" cellpadding="0">
                    <?php echo $option_content_area_1?>
                </table>
                <h4><?php echo $model_info['funcs_name'];?>前台参数 <a href="http://www.3135.com/webmagr.html?classid=39" target="_blank" title="使用帮助"><i class="icon icon-question-sign" style="margin:2px 5px 0 0;float:left;"></i></a></h4>
                <table class="table table-bordered mt10" width="100%" id="td1" border="0" cellspacing="0" cellpadding="0">
                    <?php echo $option_content_area_2?>
                    <tr align="center" height="25" style="color:green" class="tr3" id="lastparam">
                        <td align="right"></td>
                        <td align="left"><input type="submit" value=" 保存设置 " class="btn btn-success"/>
                    </tr>
                </table>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>