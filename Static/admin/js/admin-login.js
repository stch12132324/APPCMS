$(function(){
    $(".username").mouseup(function(){
        _val = $(this).val();
        if(_val == '用户名') $(this).val('');
    }).blur(function(){
        _val = $(this).val();
        if(_val == '') $(this).val('用户名');
    })
    /*$(".password").mouseup(function(){
        _val = $(this).val();
        if(_val == '+-+-+-') $(this).val('');
    }).blur(function(){
        _val = $(this).val();
        if(_val == '') $(this).val('+-+-+-');
    })*/
})