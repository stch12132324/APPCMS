$(function(){
    $(".icon-trash").click(function(){
        did = ($(this).attr("class")).split(" ");
        did = did[2];
        thisObj = $(this);
        art.dialog({
            title: '警告',
            content: '您确定要删除？',
            lock:true,
            button:[{
                name: '删除',
                callback: function (){
                    deleteSend(did,thisObj);
                },
                focus: true
            },{
                name: '取消',
                callback: function (){
                    closeDialog();
                }
            }
            ]
        });
    });
    function deleteSend(did,thisObj){
        $.ajax({
            url: 'Admin-send-sendDelete-did-'+did+'.html',
            data:'rd='+Math.random(),
            dataType:"html",
            type:"GET",
            success: function(rlt){
                if(rlt==1){
                    thisObj.parents("tr").remove();
                    showDialogMsg('succeed','删除成功！');
                }else{
                    showDialogMsg('error','删除失败！');
                }
            }
        });
    }
})