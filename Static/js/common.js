window.onerror = function(){return true;}
$(document).ready(function(){
	var oCmenu = document.getElementById('child_menu');
	var aLiCmenu = oCmenu.getElementsByTagName('li');
	var oTitle = document.getElementById('title2');
	oCmenu.onmouseover = oTitle.onmouseover = function(){
		startMove(oCmenu,{ height:400});

	};
	oCmenu.onmouseout = oTitle.onmouseout = function(){
		startMove(oCmenu,{height:0});
	};
})
//  move
function getByClass(oParent,sClass){
	var aEle = oParent.getElementsByTagName('*');
	var aResult = [];
	for(var i=0; i<aEle.length; i++){
		if(aEle[i].className == sClass){
			aResult.push(aEle[i]);
		}
	}
	return aResult;
}
	
function getStyle(obj, name){
	if(obj.currentStyle){
		return obj.currentStyle[name];
	}else{
		return getComputedStyle(obj, false)[name];
	}
}

function startMove(obj,json,fnEnd){
	clearInterval(obj.timer);
	obj.timer = setInterval(function(){
		var bStop = true;
		for(var attr in json){
		var cur = 0;
		if(attr=='opacity'){
			var cur = Math.round(parseFloat(getStyle(obj,attr))*100);
		}else{
			var cur = parseInt(getStyle(obj,attr));
		}
		var speed = (json[attr] - cur)/6;
		speed = speed>0?Math.ceil(speed):Math.floor(speed);
		
		if(cur != json[attr]) bStop = false;
		if(attr == 'opacity'){
			obj.style[attr] = (cur+speed)/100;
			obj.style.filter = 'alpha(opacity:'+(cur+speed)+')';
		}else{
			obj.style[attr] = cur+speed+'px';
		}
		}
		
		if(bStop){
			clearInterval(obj.timer);
			if(fnEnd)fnEnd();
		}
	},30);
}
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