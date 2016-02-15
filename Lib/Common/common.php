<?php
/*
@ 核心函数 M方法 调用 /Model
*/
function M($_filename){
	$_filename = ucfirst($_filename);
	$_file = BJ_ROOT.'Model/'.$_filename.".class.php";
	if(is_file($_file)){
		include_once $_file;
		return new $_filename;
	}
}
/*
@ 核心函数LC方法 调用 /Lib/Class/
*/
function LC($_filename , $params = ''){
	$_filename = ucfirst($_filename);
	$_file = BJ_ROOT.'Lib/Class/'.$_filename.".class.php";
	if(is_file($_file)){
		include_once $_file;
		// mysql 和 redis 使用单例模式
		if($_filename == 'Db_mysqli'){
			//return Db_mysqli::getInstance();
            return new Db_mysqli($params);
		}else{
			return new $_filename;
		}
	}
}
/*
@ 核心函数 IA  Include Action 文件必须同一个包 ..
*/
function IA($_filename,$_group = ''){
	$_group = $_group==''?'':$_group."/";
	$_filename = ucfirst($_filename);
	$_file = BJ_ROOT."Action/".$_group.$_filename.".php";
	if(is_file($_file)){
		include $_file;
	}
}
/*
@ 核心函数 模板驱动
*/
function template_parse($str, $istag = 0){
	$str = preg_replace("/([\n\r]+)\t+/s","\\1",$str);
	$str = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}",$str);
	$str = preg_replace("/\{template\s+(.+)\}/","<?php include template(\\1); ?>",$str);
	$str = preg_replace("/\{include\s+(.+)\}/","<?php include \\1; ?>",$str);
	$str = preg_replace("/\{php\s+(.+)\}/","<?php \\1?>",$str);
	$str = preg_replace("/\{if\s+(.+?)\}/","<?php if(\\1) { ?>",$str);
	$str = preg_replace("/\{else\}/","<?php } else { ?>",$str);
	$str = preg_replace("/\{elseif\s+(.+?)\}/","<?php } elseif (\\1) { ?>",$str);
	$str = preg_replace("/\{\/if\}/","<?php } ?>",$str);
	$str = preg_replace("/\{loop\s+(\S+)\s+(\S+)\}/","<?php if(is_array(\\1)) foreach(\\1 AS \\2) { ?>",$str);
	$str = preg_replace("/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}/","<?php if(is_array(\\1)) foreach(\\1 AS \\2 => \\3) { ?>",$str);
	$str = preg_replace("/\{\/loop\}/","<?php } ?>",$str);
	$str = preg_replace("/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/","<?php echo \\1;?>",$str);
	$str = preg_replace("/\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff:]*\(([^{}]*)\))\}/","<?php echo \\1;?>",$str);
	$str = preg_replace("/\{(\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/","<?php echo \\1;?>",$str);
	$str = preg_replace_callback("/\{(\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\}/s", function($match){ return addquote('<?php echo '.$match[0].';?>');} , $str);
	$str = preg_replace("/\{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)\}/s", "<?php echo \\1;?>",$str);
	if(!$istag) $str = "<?php defined('IN_BM') or exit('Access Denied'); ?>".$str;
	return $str;
}
function template($filename, $dir='', $group=''){
	$tplfile_c = md5($dir.$group.$filename);
	if($dir!="") $dir=$dir.'/';
	if($group==''){
		$filename = TPL_ROOT.TPL_NAME.$dir.$filename.".tpl";
	}else{
		$filename = TPL_ROOT.$group.'/'.$dir.$filename.".tpl";
	}
	$tplfile = CPD_ROOT.$tplfile_c.".php";
	if(!file_exists($filename)) {
		echo "模板文件不存在".$filename;
		exit();
	}
	if(@filemtime($filename)>@filemtime($tplfile)){
		template_compile($filename,$tplfile);
	}
	return $tplfile;
}
function template_compile($file,$file_c){
	$tplfile=$file;
	$content = file_get_contents($tplfile);
	if($content==false){
		 echo "模板文件不存在";
		 exit();
	}
	$compiled_file=$file_c;
	$content = template_parse($content);
	$strlen = @file_put_contents($compiled_file, $content);
	@chmod($compiled_file, 0777);
	return $strlen;
}
function addquote($var){
    $var = preg_replace("/\{(.*)\}/" , "$1" ,$var);
	return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
}
/*
 *@ css & js 压缩功能
 */
function cssMerge( $cssArray ){
    $newCssFile = array_pop($cssArray);
    //是否开启合并
    if(CSS_MERGE){
        $cacheFile = 'Cache/Merge/'.$newCssFile.'.css';
        foreach($cssArray as $cssfile){
            $cssfileDir = BJ_ROOT.'Static/css/'.$cssfile;
            $mergeContent .= file_get_contents($cssfileDir);
        }
        //是否开启压缩
        if(CSS_MERGE_ZIP){
            $mergeContent = preg_replace('|/\*.*\*/|isU' , '' , $mergeContent);
            $mergeContent = str_replace("\r\n", '' , $mergeContent);
            $mergeContent = str_replace("\t", '' , $mergeContent);
            $mergeContent = preg_replace('|}\s*\.|isU', '}.' , $mergeContent);
        }
        file_put_contents(BJ_ROOT.$cacheFile , $mergeContent);
        echo "<link href=\"/".$cacheFile."\" rel=\"stylesheet\" type=\"text/css\"/>\r\n";
    }else{
        foreach($cssArray as $cssfile){
            echo "<link href=\"/Static/css/".$cssfile."\" rel=\"stylesheet\" type=\"text/css\"/>\r\n";
        }
    }
}
function jsMerge( $jsArray ){
    $newJsFile = array_pop($jsArray);
    //是否开始合并
    if(CSS_MERGE){
        $cacheFile = 'Cache/Merge/'.$newJsFile.'.js';
        foreach($jsArray as $jsfile){
            $jsfileDir = BJ_ROOT.'Static/js/'.$jsfile;
            $mergeContent .= file_get_contents($jsfileDir);
        }
        //是否开启压缩
        if(CSS_MERGE_ZIP){
            //@过滤注册
            $mergeContent = str_replace('*/*' , "js_merge_bak" , $mergeContent);
            $mergeContent = preg_replace('|/\*.*\*/|isU' , '' , $mergeContent);
            $mergeContent = str_replace('js_merge_bak' , "*/*" , $mergeContent);
            $mergeContent = preg_replace('|[^:]//.*\r\n|isU' , "\r\n" , $mergeContent);

            $mergeContent = preg_replace('|":\s*|isU' , '":' , $mergeContent );
            $mergeContent = preg_replace('|;\s*([\w$}])|' , ";$1" , $mergeContent);
            $mergeContent = preg_replace('|\{\s*([\w$])|' , '{$1' , $mergeContent);
            $mergeContent = preg_replace('|\}\s*([\w$}])|' , '}$1' , $mergeContent);
            $mergeContent = preg_replace('|,\s*([\w$}])|' , ',$1' , $mergeContent);
            $mergeContent = preg_replace('|([\w;\)"])\s*\}|' , '$1}' , $mergeContent);
            $mergeContent = preg_replace('|}}\s*}}|' , '}}}}' , $mergeContent );
            $mergeContent = preg_replace('|}}\s*}\)|' , '}}})' , $mergeContent );

            //$mergeContent = preg_replace('|/\*.*\*/|isU' , '' , $mergeContent);
            //$mergeContent = str_replace("\r\n", '' , $mergeContent);
            //$mergeContent = str_replace("\t", '' , $mergeContent);
            //$mergeContent = preg_replace('|\s*|isU', '' , $mergeContent);
        }
        file_put_contents(BJ_ROOT.$cacheFile , $mergeContent);
        echo "<script src=\"/".$cacheFile."\"></script>\r\n";
    }else{
        foreach($jsArray as $jsfile){
            echo "<script src=\"/Static/js/".$jsfile."\"></script>\r\n";
        }
    }
}
?>