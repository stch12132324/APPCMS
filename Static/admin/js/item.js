$(function(){
    $(".icon-trash").click(function(){
        did = ($(this).attr("class")).split(" ");
        did = did[2];
        thisObj = $(this);
        art.dialog({
            title: '����',
            content: '��ȷ��Ҫɾ����',
            lock:true,
            button:[{
                name: 'ɾ��',
                callback: function (){
                    deleteItem(did,thisObj);
                },
                focus: true
            },{
                name: 'ȡ��',
                callback: function (){
                    closeDialog();
                }
            }
            ]
        });
    });
    function deleteItem(did,thisObj){
        $.ajax({
            url: 'Admin-weChat-itemDelete-did-'+did+'.html',
            data:'rd='+Math.random(),
            dataType:"html",
            type:"GET",
            success: function(rlt){
                if(rlt==1){
                    thisObj.parents("tr").remove();
                    showDialogMsg('succeed','ɾ���ɹ���');
                }else{
                    showDialogMsg('error','ɾ��ʧ�ܣ�');
                }
            }
        });
    }
})