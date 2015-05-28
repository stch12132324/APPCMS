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
                    deleteVideo(did,thisObj);
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
    function deleteVideo(did,thisObj){
        $.ajax({
            url: 'Admin-video-videoDelete-did-'+did+'.html',
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