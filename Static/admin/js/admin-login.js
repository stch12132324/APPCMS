$(function(){
    $(".username").mouseup(function(){
        _val = $(this).val();
        if(_val == '�û���') $(this).val('');
    }).blur(function(){
        _val = $(this).val();
        if(_val == '') $(this).val('�û���');
    })
    /*$(".password").mouseup(function(){
        _val = $(this).val();
        if(_val == '+-+-+-') $(this).val('');
    }).blur(function(){
        _val = $(this).val();
        if(_val == '') $(this).val('+-+-+-');
    })*/
})