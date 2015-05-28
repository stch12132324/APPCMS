$(document).ready(function(){
    $(".leftMenu").css("height",$(document.body).height());
    if ( $.cookie('admin-full-status') == 1 ){
        $(".leftMenu").hide();
        $(".mBody").css('width','100%');
    }else{
        $(".leftMenu").show();
        $(".mBody").css('width','85.1%');
    }
})
$(function(){
    $("i").mouseover(function(e){showTip(e,$(this).attr('rel'));}).mouseout(function(){hideTip();})
    $(".full-window").click(function(){
        if( $.cookie('admin-full-status') == 1 ){
            $(".leftMenu").show();
            $(".mBody").css('width','85.1%');
            $.cookie('admin-full-status','0',{expires:10});
        }else{
            $(".leftMenu").hide();
            $(".mBody").css('width','100%');
            $.cookie('admin-full-status','1',{expires:10});
        }
    });
})
function gourl(url){
	window.location.href=''+url;
}
function goBack(){
	window.history.go(-1);
}
$(function(){
    $(".dropdown-menu li").click(function(){
        gourl($(this).attr('rel'));
    })
})
function showDialogMsg(type,contents,titles,times){
	var vico = '';
	titles = arguments[2]?titles:'消息提示';
	times = arguments[3]?times:1;
	if(type=='start'){
		art.dialog({id: 'mydialog',title:titles,lock:true});
	}else{
		art.dialog({id: 'mydialog',title:titles,lock:true, icon:type, content:contents,time:times});
	}
}
function closeDialog(){
	art.dialog({id:'mydialog'}).close();
}
function showTip(e,val){
    if(!val) return false;
	y = e.pageY;
	x = e.pageX;
	// 获取当前鼠标位置
	$('<div class="tip" id="myTip"></div>').appendTo("body");
	$("#myTip").show().css('left',(x-30)+'px').css('top',(y+15)+'px').html(val);
}
function hideTip(){
	$("#myTip").remove();	
}


function showupload(obj,positon,thumb_type){
	var o = $('#show_upload');
	var top = 450;
	$.ajax({
		url: '/Admin-Upload-thumb.html',
		data: 'positon='+positon+'&thumb_type='+thumb_type+'&rd='+Math.random(),
		dataType:"html",
		type:"POST",
		success: function(xml){
			o.html(xml);
			o.css("left",(($(document).width())/2-(parseInt(o.width())/2))+"px");
			if($(document).scrollTop()>450){
				top = ($(document).height()+$(document).scrollTop())/2-(parseInt(o.height())/2);
			}
			o.css("top",top+"px");
			o.show();
		} 
	});
}
function hideupload(){
	$('#show_upload').hide();
}
function loading(){
	$('#show_upload').hide();
}
function showpic(event,imgsrc){
	imgarr = imgsrc.split("http");
	/*if(imgarr.length==1){
		imgsrc = '/'+imgsrc;	
	}*/
	var left = event.clientX+document.body.scrollLeft+20;
	var top = event.clientY+document.body.scrollTop+20;
	$("#preview").css({left:left,top:top,display:""});
	$("#pic_a1").attr("src",imgsrc).css('height','100px');
}
function hiddenpic(){
	$("#preview").css({display:"none"});
}
function ruselinkurl(){
	if($('#islink').attr('checked')==true)
	{
		$('#linkurl').attr('disabled','');
		$('input[require]').attr('require','false');
		$('#title').attr('require','true');
	}
	else
	{
		$('#linkurl').attr('disabled','disabled');
		$('input[require]').attr('require','true');
	}
}

function imageCut(fname){
	if(!fname) fname = 'thumb';
	file = document.getElementById(fname).value;
	if(file == '') {
		alert('请先选择网站内已上传的图片');
		return false;
	}
    file = file.split('.');
	window.open("/Admin-image-imageCut-file-"+file[0]+"-type-"+file[1]+".html","图片剪切");
}

//------屏蔽右键--------
/*if (window.Event) document.captureEvents(Event.MOUSEUP); 
function nocontextmenu() {
	event.cancelBubble = true
	event.returnValue = false;
	return false;
}
function norightclick(e) {
	if (window.Event) {
		if (e.which == 2 || e.which == 3) return false;
	}
	else
  		if (event.button == 2 || event.button == 3){
		event.cancelBubble = true
		event.returnValue = false;
		return false;
	}
 
}
document.oncontextmenu = nocontextmenu;
document.onmousedown = norightclick;*/