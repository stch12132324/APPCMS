<?php
/*
 * ΢�Žӿ��࣬������JS-SDK ��΢�������������΢��app���ܽӿڣ�
 * ------------
 * ʵ�ֹ��ܣ�
 * �˵����� ��ȡ ɾ��
 * ��Ϣ���ա��Զ��ظ�����ͷ����롢��̨��Ϣ�ظ�����Ϣ���ͣ���Ѷ����
 * �û�����
 * ����ͳ��
 *
 */
class WeChat extends Model{
	
	var $apiUrl		 	  = 'https://api.weixin.qq.com/cgi-bin/';
	var $apiUrl2		  = 'https://api.weixin.qq.com/';
	var $weChatToken 	  = '';
	var $weChatTokenTime  = 0;
	var $weChatConfigList = array();
	
	/*
	* ��ʼ��,�����ļ�
	*/
	public function __construct(){
		parent::__construct();
		$this->init();
		
	}
	
	public function init(){
		$this->_init_mysql();
		$configList = $this->db->table("option")->fields('option_name,option_var')->where("option_model='weChat'")->fetch_all();
		$this->weChatConfigList = val_to_key($configList , 'option_name' , 'option_var');
	}
	
	//-------------------------------- �˵� ------------------------------------------------------
	/*
	* ��Ӳ˵�
	* ע�����
	* 1��json����Ҫ�����menu{}��
	* 2������utf8����post
	*/
	public function createMenu($menuData = ''){
		$url 	= $this->apiUrl.'menu/create?access_token='.$this->weChatToken;
		$apiRlt = $this->http_post_data($url , $menuData);
		$apiRlt = json_decode($apiRlt);
		if($apiRlt->errcode == 0){
			return true;
		}else{
			throw new MyException($apiRlt->errcode , 'weChat');	
		}
	}
	
	/*
	* ��ȡ�˵�
	*/
	public function getMenu(){
		$url 	= $this->apiUrl.'menu/get?access_token='.$this->weChatToken;
		$apiRlt = file_get_contents($url);
		$apiRlt = str_replace("\/", "/" , $apiRlt);
		return array_iconv(json_decode($apiRlt, true) , 'utf-8' , 'gbk');
	}
	
	/*
	* ɾ���˵�
	*/
	public function removeMenu(){
		$url = $this->apiUrl.'menu/delete?access_token='.$this->weChatToken;
		$apiRlt = file_get_contents($url);
		$apiRlt = json_decode($apiRlt);
		if($apiRlt->errcode == 0){
			return true;
		}else{
			return false;	
		}
	}
	
	/*
	* �˵��¼����ݲ�ѯ
	*/
	public function getEventItem($event_key = ''){
		if( $event_key == '' ) return false;
		$this->_init_mysql;
		return $this->db->table("weixin_item")->where("item_event_key='".$event_key."'")->fetch();
	}

	//-------------------------------- ��Ϣ ------------------------------------------------------
	/*
	* ��ȡ��Ϣ
	*/
	public function getMessage(){
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (!empty($postStr)){
			$postObj      = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			switch($postObj->MsgType){
				case 'text':
					$data = array(
						'from_user_name'  => ''.$postObj->FromUserName,
						'to_user_name'	  => ''.$postObj->ToUserName,
						'create_time'	  => $postObj->CreateTime,
						'msg_type'		  => ''.$postObj->MsgType,
						'content'		  => iconv('utf-8' , 'gbk' , trim($postObj->Content)),
						'msgid'			  => ''.$postObj->MsgId
					);
				break;
				case 'event':
					$data = array(
						'from_user_name'  => ''.$postObj->FromUserName,
						'to_user_name'	  => ''.$postObj->ToUserName,
						'create_time'	  => $postObj->CreateTime,
						'msg_type'		  => ''.$postObj->MsgType,
						'event_type'	  => ''.$postObj->Event,
						'event_key'		  => ''.$postObj->EventKey
					);
				break;
			}
			$this->db->table("weixin_message")->insert($data);
			return $data;
        }else{
			return '';	
		}
	}
	
	/*
	* �ظ���Ϣ
	*/
	public function replyMessage($data , $message = '' , $type = 'text'){
		$postXml = '';
		switch($type){
			case 'text':
				$postXml = '<MsgType><![CDATA[text]]></MsgType>
				<Content><![CDATA['.iconv('gbk' , 'utf-8//TRANSLIT//IGNORE' , $message).']]></Content>';
			break;
			
			case 'image':
			break;
			
			case 'news':
				if( empty($message) ) return false;
				$newsList = explode("||" , $message);
				$postXml = '<MsgType><![CDATA[news]]></MsgType>
				<ArticleCount>'.count($newsList).'</ArticleCount>
				<Articles>';
				foreach( $newsList as $news){
					$vals = explode("|" , $news);
					$postXml .= '<item>
					<Title><![CDATA['.iconv('gbk' , 'utf-8//TRANSLIT//IGNORE' , $vals[0]).']]></Title> 
					<Description><![CDATA['.iconv('gbk' , 'utf-8//TRANSLIT//IGNORE' , $vals[3]).']]></Description>
					<PicUrl><![CDATA['.'http://'.$_SERVER['SERVER_NAME'].'/'.$vals[1].']]></PicUrl>
					<Url><![CDATA['.$vals[2].']]></Url>
					</item>';	
				}
				$postXml .= '</Articles>';
			break;
		}
		
		$xml = '<xml>
				<ToUserName><![CDATA['.$data['from_user_name'].']]></ToUserName>
				<FromUserName><![CDATA['.$data['to_user_name'].']]></FromUserName>
				<CreateTime>'.$data['create_time'].'</CreateTime>
				'.$postXml.'
				</xml>';
		echo $xml;
	}
	
	/*
	* ������Ϣ
	*/
	public function sendMessage($openid='' , $string = ''){
		$url 	= $this->apiUrl.'message/custom/send?access_token='.$this->weChatToken;
		$jsonStr = '{
"touser":"'.$openid.'",
"msgtype":"text",
"text":{"content":"'.$string.'"}
}';	
		$this->http_post_data($url , $jsonStr);
	}
	
	/*
	* ת������ͷ�
	*/
	public function transferCustomerService($data){
		$xmlTpl = "<xml>
	<ToUserName><![CDATA[%s]]></ToUserName>
	<FromUserName><![CDATA[%s]]></FromUserName>
	<CreateTime>%s</CreateTime>
	<MsgType><![CDATA[transfer_customer_service]]></MsgType>
	</xml>";
		$sendMsg = sprintf($xmlTpl, $data['from_user_name'], $data['to_user_name'], time());
		echo $sendMsg;	
	}
	
	/*
	* �Զ��ظ�
 	*/
	public function autoReply($data){
		// ��ƥ���Զ��ظ����ٽ���ͷ����ٺ�̨�ظ�
		if($this->weChatConfigList['WECHAT_AUTO_REPLY'] == 1){
			$keywords = $this->findReplyKeyword($data['content']);
		}
		if( !empty($keywords) ){
			$this->replyMessage($data , $keywords['key_val'] , $keywords['key_type']);
			$this->setMessageConnectType($data['msgid'], 1 , $reply);
		}else{
			if($this->weChatConfigList['WECHAT_DKF'] == 1){
				// ��ͷ�����
				$this->setMessageConnectType($data['msgid'], 2);
				$this->transferCustomerService($data);
			}else{
				//$this->replyMessage($data , $this->weChatConfigList['WECHAT_WELCOME'] , 'text'); //��ʱ�ر��Զ��ظ���ʹ���˹��ظ�
				//$this->setMessageConnectType($data['msgid'], 3);
			}
		}
	}
	
	/*
	* ���ݷ�����ҹؼ��ʣ���Ӧ�ظ�
	* Ŀǰ������ȫ��ȡ���������ݽ���ƥ�� :: �������⣬��������һ����ʱ���쳣������������100��
	*/
	public function findReplyKeyword($string){
		$keywordList = $this->db->table("weixin_reply_keywords")->limit($this->weChatConfigList['WECHAT_KEY_NUMBER'])->fetch_all();
		if(!empty($keywordList)){
			foreach($keywordList as $key){
				if(strstr($string , $key['key_name'])){
					return $key;	
				}
			}
			return '';
		}else{
			return '';	
		}
	}
	
	/*
	* ���÷�����Ϣ���ӷ�ʽ
	*/
	public function setMessageConnectType($msgid ='' , $type){
		$array = array('connect_type' => $type);
		$this->db->table('weixin_message')->where("msgid=".$msgid)->update($array);
	}
	
	//-------------------------------- Ⱥ����Ϣ ------------------------------------------------------
	/*
	* �ϴ�ͼ���ز�
	*/
	public function uploadNpMedia($data = ''){
		$url = $this->apiUrl.'media/uploadnews?access_token='.$this->weChatToken;
		$postJson = '{"articles": [';
		foreach($data as $news){
			// �ϴ�ͼƬ�ز�
			$media_id = '';
			$pic_show = 0;
			if($news['thumb'] != ''){
				$media_id = $this->uploadMedia(BJ_ROOT.$news['thumb'] , 'image');
				$pic_show = $media_id != '' ? 1:0;
			}
			// ����json��ʽ
			$news['description'] = trim($news['description']);
			$news['content']     = str_replace("/uploadfile" , "http://".$_SERVER['SERVER_NAME']."/uploadfile" , $news['content']);
			$news['content']	 = strip_tags($news['content'] , '<br><a><img>');
			$news['content']     = trim($news['content']);
			$news['content']     = preg_replace("/style=\"(.*)\"/isU" , "" , $news['content']);
			$news['content']     = preg_replace("/class=\"(.*)\"/isU" , "" , $news['content']);
			$news['content'] 	 = str_replace('"' , '\"' ,$news['content']);
			$news['content'] 	 = str_replace("\r\n" , "<br>" ,$news['content']);
			$news['content'] 	 = str_replace("\n" , "<br>" ,$news['content']);
			$news['content'] 	 = str_replace("����" , "" ,$news['content']);
			$postJson .= '
			{
				"thumb_media_id":"'.$media_id.'",
				"author":"",
				"title":"'.$news['title'].'",
				"content_source_url":"'.$_SERVER['SERVER_NAME'].'/news-view-id-'.$news['id'].'.html",
				"content":"'.$news['content'].'",
				"digest":"'.$news['description'].'",
				"show_cover_pic":"'.$pic_show.'"
			},';
		}
		$postJson = trim($postJson , ',');
		$postJson .= ']}';
		$rltJson = $this->http_post_data($url , $postJson);
		$rltJson = json_decode($rltJson);
		if($rltJson->media_id != ''){
			return 	$rltJson->media_id;
		}else{
			throw new MyException($rltJson->errcode , 'weChat');
		}
	}
	
	/*
	* Ⱥ���������û�
	*/
	public function sendToAll($news_media = ''){
		$apiUrl = $this->apiUrl.'message/mass/sendall?access_token='.$this->weChatToken;
		$postJson = '{
		   "filter":{
			  "is_to_all":true
		   },
		   "mpnews":{
			  "media_id":"'.$news_media.'"
		   },
			"msgtype":"mpnews"
		}';	
		$rltJson = $this->http_post_data($apiUrl , $postJson);
		$rltJson = json_decode($rltJson);
		if($rltJson->errcode == 0){
			return true;	
		}else{
			throw new MyException($rltJson->errcode , 'weChat');
		}
	}
	
	/*
	* ����Ԥ��
	*/
	public function sendToView($news_media = '', $openid = ''){
		$viewApiUrl = $this->apiUrl.'message/mass/preview?access_token='.$this->weChatToken;
		$postJson   = '{
			   "touser":"'.$openid.'", 
			   "mpnews":{"media_id":"'.$news_media.'"},
			   "msgtype":"mpnews" 
		}';
		$rltJson = $this->http_post_data($viewApiUrl , $postJson);
		$rltJson = json_decode($rltJson);
		if($rltJson->errcode == 0){
			return true;	
		}else{
			throw new MyException($rltJson->errcode , 'weChat');
		}
	}
	
	//----------------------------- �û��б� --------------------------------------------------
	public function getAllUser(){
		$viewApiUrl = $this->apiUrl.'user/get?access_token='.$this->weChatToken.'&next_openid=';
		$user		= file_get_contents($viewApiUrl);
		$userList   = json_decode($user);
		return $userList->data->openid;
	}
	
	public function getUserInfo($openid = ''){
		$viewApiUrl = $this->apiUrl.'user/info?access_token='.$this->weChatToken.'&openid='.$openid.'&lang=zh_CN';
		$user		= file_get_contents($viewApiUrl);
		$user   	= json_decode($user);	
		$user 		= object_to_array($user);
		return array_iconv($user , 'utf-8' , 'gbk');	
	}
	//----------------------------- ��ͷ� ----------------------------------------------------
	
	public function addKf($dataJson = ''){
		$viewApiUrl = $this->apiUrl2.'customservice/kfaccount/add?access_token='.$this->weChatToken;
		$apiRlt = $this->http_post_data($viewApiUrl , $dataJson);
		if($apiRlt->errcode == 0){
			return true;
		}else{
			throw new MyException($apiRlt->errcode , 'weChat');	
		}
	}
	public function getKfList(){
		$viewApiUrl = $this->apiUrl.'customservice/getkflist?access_token='.$this->weChatToken;
		$kfList     = file_get_contents($viewApiUrl);
		$kfList   	= json_decode($kfList , true);
		return array_iconv($kfList , 'utf-8' , 'gbk');
	}
	
	public function getKfOnlineList(){
		$viewApiUrl = $this->apiUrl.'customservice/getonlinekflist?access_token='.$this->weChatToken;
		$kfOnlineList     = file_get_contents($viewApiUrl);
		$kfOnlineList   	= json_decode($kfOnlineList , true);
		return array_iconv($kfOnlineList , 'utf-8' , 'gbk');
	}
	
	public function deleteKf($kf_account = ''){
		$viewApiUrl = $this->apiUrl2.'customservice/kfaccount/del?access_token='.$this->weChatToken.'&kf_account='.$kf_account;
		$apiRlt		= file_get_contents($viewApiUrl);
		if($apiRlt->errcode == 0){
			return true;
		}else{
			throw new MyException($apiRlt->errcode , 'weChat');	
		}
	}
	
	//----------------------------- ͨ�÷��� --------------------------------------------------
	
	/*
	* �ϴ��ز�
	*/
	public function uploadMedia($mediaUrl = '' , $mediaType = 'image'){
		$postStr = array('media' => '@'.$mediaUrl);
		$url = $this->apiUrl.'media/upload?access_token='.$this->weChatToken.'&type='.$mediaType;
		$rlt = $this->http_post_media_data($url , $postStr);
		$rltJson = json_decode($rlt);
		if($rltJson->media_id != ''){
			return $rltJson->media_id;
		}else{
			throw new MyException($rltJson->errcode , 'weChat');
		}
	}
	
	/*
	* ��ȡToken
	*/
	public function getToken(){
		// �ļ�json��ʽ����token
		$tokenCacheDir = BJ_ROOT.'Config/token.inc.txt';
		$tokenJson = '';
		if( is_file( $tokenCacheDir ) ) $tokenJson = file_get_contents( $tokenCacheDir );
		$token = json_decode($tokenJson);
		if( !empty($token) ){
			$this->weChatToken 	   = $token->weChatToken;
			$this->weChatTokenTime = $token->weChatTokenTime;
		}
		
		if($this->weChatToken == '' || $this->weChatTokenTime + 7200 < time()){
			$url 	= $this->apiUrl.'token?grant_type=client_credential&appid='.$this->weChatConfigList['WECHAT_APPID'].'&secret='.$this->weChatConfigList['WECHAT_APPSECRET'];
			$apiRlt = file_get_contents($url);
			$apiRlt = json_decode($apiRlt);
			if($apiRlt->access_token !=''){
				$this->weChatToken 	 	= $apiRlt->access_token;
				$this->weChatTokenTime  = time();
				$data = array(
					'weChatToken'     => $this->weChatToken,
					'weChatTokenTime' => $this->weChatTokenTime
				);
				file_put_contents( $tokenCacheDir , json_encode($data) );
			}else{
				throw new MyException($apiRlt->errcode , 'weChat'); 
			}
		}else{
			return $this->weChatToken;	
		}
	}
	
	/*
	* HTTP POST �ύͼƬ��Ϣ
	*/
	public function http_post_media_data($url, $data_string){
		$data_string = array_iconv($data_string , "gbk" , "utf-8//TRANSLIT//IGNORE");
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		return curl_exec($ch);
	}
	
	/*
	* HTTP POST �ύJSON��Ϣ
	*/
	public function http_post_data($url, $data_string) {
		$data_string = array_iconv($data_string , "gbk" , "utf-8//TRANSLIT//IGNORE");
        $ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string))
		);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		return curl_exec($ch);
    } 
	
	/*
	* ��֤Token
	*/
	public function checkSignature(){
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        $signature 	= $_GET["signature"];
        $timestamp 	= $_GET["timestamp"];
        $nonce 		= $_GET["nonce"];
        		
		$token 	= TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}
?>