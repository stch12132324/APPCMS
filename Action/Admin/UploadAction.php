<?php
IA("AdminBaseAction","Admin");
class UploadAction extends AdminBaseAction{

	public function thumb(){
		$this->display('upload');
	}
	
	public function thumbsave(){
		$up = LC("Upfile");
		if($_POST['thumb_type']=='big'){
			$up->setSizeBig(BIG_IMG_SIZE * 1024,'big'); // ���������������ļ�����
		}
		$rlt = $up->set_dir('thumb/','{y}/{m}/{d}');
		$fs = $up->execute();
		if($fs[0]['flag']=='-1'){
			echo "<script>window.parent.document.all.".$_POST['positon']."_alert.innerHTML='�ļ����Ͳ����Ϲ淶��';</script>";
		}elseif($fs[0]['flag']=='-2'){
			echo "<script>window.parent.document.all.".$_POST['positon']."_alert.innerHTML='�����޶���С��';</script>";
		}else{
			/*echo "<script>window.parent.document.all.thumb.value='".$fs[0]['filepath']."';window.parent.document.all.attid.value='".$insert_id."';</script>";*/
			echo "<script>window.parent.document.all.".$_POST['positon'].".value='".$fs[0]['filepath']."';</script>";
		}
	}
	
	// �༭���ϴ��������ͼ
	public function imageSave(){
		//---- �ϴ��ļ�
		$up = LC("Upfile");
		$up->setSizeBig(BIG_IMG_SIZE * 1024,'big');
		$rlt = $up->set_dir('thumb/','{y}/{m}/{d}');
		$fs = $up->execute2();
		$funcNum = $_GET['CKEditorFuncNum'] ;
		//$CKEditor = $_GET['CKEditor'] ;
		//$langCode = $_GET['langCode'] ;
		$url = $fs['filepath'];
		//---- �ص�
		echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";	
	}

}
?>