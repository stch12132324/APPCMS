<?php
IA("AdminBaseAction","Admin");
class UploadAction extends AdminBaseAction{

	public function thumb(){
		$this->display('upload');
	}
	
	public function thumbsave(){
		$up = LC("Upfile");
		if($_POST['thumb_type']=='big'){
			$up->setSizeBig(BIG_IMG_SIZE * 1024,'big'); // 这两个参数配置文件设置
		}
		$rlt = $up->set_dir('thumb/','{y}/{m}/{d}');
		$fs = $up->execute();
		if($fs[0]['flag']=='-1'){
			echo "<script>window.parent.document.all.".$_POST['positon']."_alert.innerHTML='文件类型不符合规范！';</script>";
		}elseif($fs[0]['flag']=='-2'){
			echo "<script>window.parent.document.all.".$_POST['positon']."_alert.innerHTML='超过限定大小！';</script>";
		}else{
			/*echo "<script>window.parent.document.all.thumb.value='".$fs[0]['filepath']."';window.parent.document.all.attid.value='".$insert_id."';</script>";*/
			echo "<script>window.parent.document.all.".$_POST['positon'].".value='".$fs[0]['filepath']."';</script>";
		}
	}
	
	// 编辑器上传，允许大图
	public function imageSave(){
		//---- 上传文件
		$up = LC("Upfile");
		$up->setSizeBig(BIG_IMG_SIZE * 1024,'big');
		$rlt = $up->set_dir('thumb/','{y}/{m}/{d}');
		$fs = $up->execute2();
		$funcNum = $_GET['CKEditorFuncNum'] ;
		//$CKEditor = $_GET['CKEditor'] ;
		//$langCode = $_GET['langCode'] ;
		$url = $fs['filepath'];
		//---- 回调
		echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";	
	}

}
?>