<?php
class Image {
    var $thumb_file;
    var $thumb_width;
    var $thumb_height;
    var $scr_file;
    var $scr_width;
    var $scr_height;
    var $type;
    var $im;
    function __construct($file = ''){
        if(is_file($file)){
            $this->scr_file=$file;
            $this->type=substr(strrchr($this->scr_file,"."),1);
            if($this->type=="jpg"){
                $this->im = imagecreatefromjpeg($this->scr_file);
            }
            if($this->type=="gif"){
                $this->im = imagecreatefromgif($this->scr_file);
            }
            if($this->type=="png"){
                $this->im = imagecreatefrompng($this->scr_file);
            }
            $this->scr_width = imagesx($this->im);
            $this->scr_height = imagesy($this->im);
        }
    }
    function thumb_image($wid,$hei,$dir="") {
        $this->thumb_width=$wid;
        $this->thumb_height=$hei;
        $this->thumb_file="thumb_".date("YmdHis",TIME).random(3,'1234560789').'.'.$this->type;
        if(($this->scr_width-$this->thumb_width)>($this->scr_height-$this->thumb_height)){
            $this->thumb_height=($this->thumb_width/$this->scr_width)*$this->scr_height;
        }else{
            $this->thumb_width=($this->thumb_height/$this->scr_height)*$this->scr_width;
        }
        //echo $this->thumb_width,$this->thumb_height;
        if($this->type != 'gif' && function_exists('imagecreatetruecolor')){
            $thumbimg = imagecreatetruecolor($this->thumb_width, $this->thumb_height);
        }else{
            $thumbimg = imagecreate($this->thumb_width,$this->thumb_height);
        }
        if(function_exists('imagecopyresampled')){
            imagecopyresampled($thumbimg, $this->im, 0, 0, 0, 0, $this->thumb_width, $this->thumb_height, $this->scr_width, $this->scr_height);
        }else{
            imagecopyresized($thumbimg,$this->im, 0, 0, 0, 0, $$this->thumb_width, $this->thumb_height,  $this->scr_width, $this->scr_height);
        }
        if($this->type=='gif' || $this->type=='png')
        {
            $background_color  =  imagecolorallocate($thumbimg,  0, 255, 0);  //  ָ��һ����ɫ
            imagecolortransparent($thumbimg, $background_color);  //  ����Ϊ͸��ɫ����ע�͵������������ɫ��ͼ
        }
        $dir = UPLOAD_ROOT.$dir;
        switch ($this->type) {
            case 'jpg' :
                ImageJPEG($thumbimg,$dir.$this->thumb_file); break;
            case 'gif' :
                ImageGIF($thumbimg,$dir.$this->thumb_file); break;
            case 'png' :
                ImagePNG($thumbimg,$dir.$this->thumb_file); break;
        }
        imagedestroy($this->im);
        imagedestroy($thumbimg);
        return $this->thumb_file;
    }
    /*
     * ��ҳ����ͼƬ�Դ����ְ�Ȩˮӡ�ű�
     */
    public function waterMark(){
        //���������߶�ΪͼƬ�߶�+30px
        $new_height = 30;
        $bgIm = imagecreate($this->scr_width, $new_height);
        imagecolorallocate($bgIm, 33, 78, 137);
        //�ײ���������
        $text_color = imagecolorallocate($bgIm, 255, 255, 255); //������ɫ
        $text = '������ http://www.ltaaa.com ���������ݸ���ʵ����������ȫ��ƽ����������'; //��������
        imagettftext($bgIm, 10, 0, 5, $new_height - 8, $text_color , BJ_ROOT.'/static/font/mcyahei.ttf' ,iconv("GBk","UTF-8", $text)); // ����, б��, x, y
        //�����ֵ�ͼƬ��������ͼƬ�ײ�
        imagecopymerge($this->im, $bgIm, 0, $this->scr_height - 30, 0, 0, $this->scr_width, 30, 100);
        //�����ļ�
        imagejpeg($this->im, $this->scr_file, 100);
        imagedestroy($bgIm);
        imagedestroy($this->im);
    }
    /*
     * ����ת��ͼƬ����Ȩ postmakeĿ¼�£����ڽ�������һ��������һ�Σ�ֻ��������
     */
    public function txtToImg($string = '' , $author = ''){
        //header("Content-type: image/jpeg");
        $txt_width  = 698;
        //$txt_height = 300;
        $img_dir  = '/uploadfile/PostMake/'.date('m').'/'.date('d');
        if(!is_dir($img_dir)) createdir($img_dir);
        $img_file = $img_dir.'/'.time().rand(10000,99999).'.jpg';
        mb_internal_encoding("UTF-8"); // ���ñ���
        $fontFace = BJ_ROOT.'/Static/font/mcyahei.ttf';
        $string = strip_tags($string);
        $string = trim($string , "[/copy]");
        $string = $this->addAuthorCopy($string , $author);
        $string = html_entity_decode($string);
        //$string = str_replace("&nbsp;", "", $string);
        $string = $this->autowrap(10, 0, $fontFace, $string, 698); // �Զ����д���
        $txt_height = $this->getTxtImgHeight($string);
        $im = imagecreate($txt_width , $txt_height); // ����
        imagecolorallocate($im, 255, 255, 255);       // ������ɫ
        $text_color = imagecolorallocate($im, 69, 69, 69); //������ɫ
        imagettftext($im, 10, 0, 0, 16, $text_color , $fontFace ,$string);// ����, б��, x, y
        //imagepng($im);
        imagejpeg($im, BJ_ROOT.$img_file , 85);
        imagedestroy($im);
        return $img_file;
    }
    // ����ͼƬ��ͼ\n����
    public function autowrap($fontsize, $angle, $fontface, $string, $width) {
        $string = iconv("GBK" , "UTF-8//IGNORE//TRANSLIT" , $string);
        // �⼸�������ֱ��� �����С, �Ƕ�, ��������, �ַ���, Ԥ����
        $content = "";
        // ���ַ�����ֳ�һ�������� ���浽���� letter ��
        for ($i=0;$i<mb_strlen($string);$i++) {
            $letter[] = mb_substr($string, $i, 1);
        }
        $countString = '';
        foreach ($letter as $l) {
            $countString .= " ".$l;
            /*$testbox = imagettfbbox($fontsize, $angle, $fontface, $teststr);
            // �ж�ƴ�Ӻ���ַ����Ƿ񳬹�Ԥ��Ŀ��
            if (($testbox[2] > $width) && ($content !== "")) {
                $content .= "\n";
            }*/
            if($l=="\n") $countString = ''; //����ַ��ǻ��У������¼���
            if(strlen($countString) > 208){
                $countString = '';
                $content .= "\n";
            }
            $content .= $l;
        }
        return $content;
    }
    public function getTxtImgHeight($string){
        $line = explode("\n",$string);
        $line = count($line);
        //return $line * 20 + 35; //��Ȩ30�߶�
        return $line * 20;
    }
    // ��������Ȩ
    public function addAuthorCopy($string='' , $author=''){
        $parts = explode("\n",$string);
        $line = count($parts);
        $addPoint = rand(1,$line);
        $parts_1  = array_slice($parts, 0 ,$addPoint);
        $parts_2  = array_slice($parts, $addPoint, $line);
        return implode("\n",$parts_1)."\n\n������ http://www.ltaaa.com ���������ݸ���ʵ����������ȫ��ƽ���������� �������ߣ�".$author."\n".implode("\n",$parts_2);
    }
}
?>