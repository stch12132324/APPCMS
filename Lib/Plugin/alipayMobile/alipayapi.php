<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
	<title>֧������ʱ���˽��׽ӿڽӿ�</title>
</head>
<?php
/* *
 * ���ܣ���ʱ���˽��׽ӿڽ���ҳ
 * �汾��3.3
 * �޸����ڣ�2012-07-23
 * ˵����
 * ���´���ֻ��Ϊ�˷����̻����Զ��ṩ���������룬�̻����Ը����Լ���վ����Ҫ�����ռ����ĵ���д,����һ��Ҫʹ�øô��롣
 * �ô������ѧϰ���о�֧�����ӿ�ʹ�ã�ֻ���ṩһ���ο���

 *************************ע��*************************
 * ������ڽӿڼ��ɹ������������⣬���԰��������;�������
 * 1���̻��������ģ�https://b.alipay.com/support/helperApply.htm?action=consultationApply�����ύ���뼯��Э�������ǻ���רҵ�ļ�������ʦ������ϵ��Э�����
 * 2���̻��������ģ�http://help.alipay.com/support/232511-16307/0-16307.htm?sh=Y&info_type=9��
 * 3��֧������̳��http://club.alipay.com/read-htm-tid-8681712.html��
 * �������ʹ����չ���������չ���ܲ�������ֵ��
 */

require_once("alipay.config.php");
require_once("lib/alipay_submit.class.php");



/**************************������Ȩ�ӿ�alipay.wap.trade.create.direct��ȡ��Ȩ��token**************************/
	
//���ظ�ʽ
$format = "xml";
//�������Ҫ�޸�

//���ظ�ʽ
$v = "2.0";
//�������Ҫ�޸�

//�����
$req_id = date('Ymdhis');
//����뱣֤ÿ��������Ψһ

//**req_data��ϸ��Ϣ**

//�������첽֪ͨҳ��·��
$notify_url = "http://�̻����ص�ַ/WS_WAP_PAYWAP-PHP-UTF-8/notify_url.php";
//��http://��ʽ������·�����������?id=123�����Զ������

//ҳ����תͬ��֪ͨҳ��·��
$call_back_url = "http://127.0.0.1:8800/WS_WAP_PAYWAP-PHP-UTF-8/call_back_url.php";
//��http://��ʽ������·�����������?id=123�����Զ������

//�����жϷ��ص�ַ
$merchant_url = "http://127.0.0.1:8800/WS_WAP_PAYWAP-PHP-UTF-8/xxxx.php";
//�û�������;�˳������̻��ĵ�ַ����http://��ʽ������·�����������?id=123�����Զ������

//����֧�����ʻ�
$seller_email = $_POST['WIDseller_email'];
//����

//�̻�������
$out_trade_no = $_POST['WIDout_trade_no'];
//�̻���վ����ϵͳ��Ψһ�����ţ�����

//��������
$subject = $_POST['WIDsubject'];
//����

//������
$total_fee = $_POST['WIDtotal_fee'];
//����

//����ҵ�������ϸ
$req_data = '<direct_trade_create_req><notify_url>' . $notify_url . '</notify_url><call_back_url>' . $call_back_url . '</call_back_url><seller_account_name>' . $seller_email . '</seller_account_name><out_trade_no>' . $out_trade_no . '</out_trade_no><subject>' . $subject . '</subject><total_fee>' . $total_fee . '</total_fee><merchant_url>' . $merchant_url . '</merchant_url></direct_trade_create_req>';
//����

/************************************************************/

//����Ҫ����Ĳ������飬����Ķ�
$para_token = array(
		"service" => "alipay.wap.trade.create.direct",
		"partner" => trim($alipay_config['partner']),
		"sec_id" => trim($alipay_config['sign_type']),
		"format"	=> $format,
		"v"	=> $v,
		"req_id"	=> $req_id,
		"req_data"	=> $req_data,
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
);

//��������
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestHttp($para_token);

//URLDECODE���ص���Ϣ
$html_text = urldecode($html_text);

//����Զ��ģ���ύ�󷵻ص���Ϣ
$para_html_text = $alipaySubmit->parseResponse($html_text);

//��ȡrequest_token
$request_token = $para_html_text['request_token'];


/**************************������Ȩ��token���ý��׽ӿ�alipay.wap.auth.authAndExecute**************************/

//ҵ����ϸ
$req_data = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';
//����

//����Ҫ����Ĳ������飬����Ķ�
$parameter = array(
		"service" => "alipay.wap.auth.authAndExecute",
		"partner" => trim($alipay_config['partner']),
		"sec_id" => trim($alipay_config['sign_type']),
		"format"	=> $format,
		"v"	=> $v,
		"req_id"	=> $req_id,
		"req_data"	=> $req_data,
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
);

//��������
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter, 'get', 'ȷ��');
echo $html_text;
?>
</body>
</html>