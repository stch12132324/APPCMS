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
            $background_color  =  imagecolorallocate($thumbimg,  0, 255, 0);  //  指派一个绿色
            imagecolortransparent($thumbimg, $background_color);  //  设置为透明色，若注释掉该行则输出绿色的图
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
     * 首页长传图片自带文字版权水印脚本
     */
    public function waterMark(){
        //创建画布高度为图片高度+30px
        $new_height = 30;
        $bgIm = imagecreate($this->scr_width, $new_height);
        imagecolorallocate($bgIm, 33, 78, 137);
        //底部加入文字
        $text_color = imagecolorallocate($bgIm, 255, 255, 255); //文字颜色
        $text = '龙腾网 http://www.ltaaa.com 倾听各国草根真实声音，纵论全球平民眼中世界'; //加入文字
        imagettftext($bgIm, 10, 0, 5, $new_height - 8, $text_color , BJ_ROOT.'/static/font/mcyahei.ttf' ,iconv("GBk","UTF-8", $text)); // 字体, 斜度, x, y
        //将文字的图片拷贝到旧图片底部
        imagecopymerge($this->im, $bgIm, 0, $this->scr_height - 30, 0, 0, $this->scr_width, 30, 100);
        //保存文件
        imagejpeg($this->im, $this->scr_file, 100);
        imagedestroy($bgIm);
        imagedestroy($this->im);
    }
    /*
     * 文字转化图片带版权 postmake目录下，定期进行清理，一个月清理一次，只保留当月
     */
    public function txtToImg($string = '' , $author = ''){
        //header("Content-type: image/jpeg");
        $txt_width  = 698;
        //$txt_height = 300;
        $img_dir  = '/uploadfile/PostMake/'.date('m').'/'.date('d');
        if(!is_dir($img_dir)) createdir($img_dir);
        $img_file = $img_dir.'/'.time().rand(10000,99999).'.jpg';
        mb_internal_encoding("UTF-8"); // 设置编码
        $fontFace = BJ_ROOT.'/Static/font/mcyahei.ttf';
        $string = strip_tags($string);
        $string = trim($string , "[/copy]");
        $string = $this->addAuthorCopy($string , $author);
        $string = html_entity_decode($string);
        //$string = str_replace("&nbsp;", "", $string);
        $string = $this->autowrap(10, 0, $fontFace, $string, 698); // 自动换行处理
        $txt_height = $this->getTxtImgHeight($string);
        $im = imagecreate($txt_width , $txt_height); // 画布
        imagecolorallocate($im, 255, 255, 255);       // 背景颜色
        $text_color = imagecolorallocate($im, 69, 69, 69); //文字颜色
        imagettftext($im, 10, 0, 0, 16, $text_color , $fontFace ,$string);// 字体, 斜度, x, y
        //imagepng($im);
        imagejpeg($im, BJ_ROOT.$img_file , 85);
        imagedestroy($im);
        return $img_file;
    }
    // 根据图片换图\n换行
    public function autowrap($fontsize, $angle, $fontface, $string, $width) {
        $string = iconv("GBK" , "UTF-8//IGNORE//TRANSLIT" , $string);
        // 这几个变量分别是 字体大小, 角度, 字体名称, 字符串, 预设宽度
        $content = "";
        // 将字符串拆分成一个个单字 保存到数组 letter 中
        for ($i=0;$i<mb_strlen($string);$i++) {
            $letter[] = mb_substr($string, $i, 1);
        }
        $countString = '';
        foreach ($letter as $l) {
            $countString .= " ".$l;
            /*$testbox = imagettfbbox($fontsize, $angle, $fontface, $teststr);
            // 判断拼接后的字符串是否超过预设的宽度
            if (($testbox[2] > $width) && ($content !== "")) {
                $content .= "\n";
            }*/
            if($l=="\n") $countString = ''; //如果字符是换行，则重新计数
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
        //return $line * 20 + 35; //版权30高度
        return $line * 20;
    }
    // 随机插入版权
    public function addAuthorCopy($string='' , $author=''){
        $parts = explode("\n",$string);
        $line = count($parts);
        $addPoint = rand(1,$line);
        $parts_1  = array_slice($parts, 0 ,$addPoint);
        $parts_2  = array_slice($parts, $addPoint, $line);
        return implode("\n",$parts_1)."\n\n龙腾网 http://www.ltaaa.com 倾听各国草根真实声音，纵论全球平民眼中世界 译文作者：".$author."\n".implode("\n",$parts_2);
    }
}
?>