<?php
require "../../include/common.inc.php";
/* *
 * ���ܣ�֧�����������첽֪ͨҳ��
 * �汾��3.3
 * ���ڣ�2012-07-23
 * ˵����
 * ���´���ֻ��Ϊ�˷����̻����Զ��ṩ���������룬�̻����Ը����Լ���վ����Ҫ�����ռ����ĵ���д,����һ��Ҫʹ�øô��롣
 * �ô������ѧϰ���о�֧�����ӿ�ʹ�ã�ֻ���ṩһ���ο���


 *************************ҳ�湦��˵��*************************
 * ������ҳ���ļ�ʱ�������ĸ�ҳ���ļ������κ�HTML���뼰�ո�
 * ��ҳ�治���ڱ������Բ��ԣ��뵽�������������ԡ���ȷ���ⲿ���Է��ʸ�ҳ�档
 * ��ҳ����Թ�����ʹ��д�ı�����logResult���ú����ѱ�Ĭ�Ϲرգ���alipay_notify_class.php�еĺ���verifyNotify
 * ���û���յ���ҳ�淵�ص� success ��Ϣ��֧��������24Сʱ�ڰ�һ����ʱ������ط�֪ͨ
 */

require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");

//����ó�֪ͨ��֤���
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {//��֤�ɹ�
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//������������̻���ҵ���߼������

	
	//�������������ҵ���߼�����д�������´�������ο�������
	
    //��ȡ֧������֪ͨ���ز������ɲο������ĵ��з������첽֪ͨ�����б�
	
	//�̻�������

	$out_trade_no = $_POST['out_trade_no'];

	//֧�������׺�

	$trade_no = $_POST['trade_no'];

	//����״̬
	$trade_status = $_POST['trade_status'];


    if($_POST['trade_status'] == 'TRADE_FINISHED') {
		//�жϸñʶ����Ƿ����̻���վ���Ѿ���������
			//���û�������������ݶ����ţ�out_trade_no�����̻���վ�Ķ���ϵͳ�в鵽�ñʶ�������ϸ����ִ���̻���ҵ�����
			//���������������ִ���̻���ҵ�����
				
		//ע�⣺
		//���ֽ���״ֻ̬����������³���
		//1����ͨ����ͨ��ʱ���ˣ���Ҹ���ɹ���
		//2����ͨ�˸߼���ʱ���ˣ��Ӹñʽ��׳ɹ�ʱ�����𣬹���ǩԼʱ�Ŀ��˿�ʱ�ޣ��磺���������ڿ��˿һ�����ڿ��˿�ȣ���
		/*  BOJOO ҵ���߼�  */
		$result = $db->get_one("select * from bm_pay_rand_number where pay_rand_number='".$out_trade_no."'");
		if($result['status']==0){
				$db->query("insert into bm_pay_cash (uid,cash_name,cash_money,cash_time) values ('".$result['uid']."','3135���߳�ֵ-".$out_trade_no."','".$result['WIDtotal_fee']."',".time().")");
				//--����״̬
				$gift_status = $db->get_one("select uid from bm_user_enter_gift where uid=".$result['uid']);
				if(empty($gift_status)){
					if($result['WIDtotal_fee']>=588){
						$db->query("insert into bm_pay_cash (uid,cash_name,cash_money,cash_time) values ('".$result['uid']."','3135�״γ�ֵ����-".$out_trade_no."','80',".time().")");
						$db->insert("bm_user_enter_gift",array('uid'=>$result['uid']));
					}
					$enter_money = $result['WIDtotal_fee']>=588?($result['WIDtotal_fee']+80):$result['WIDtotal_fee'];
				}else{
					$enter_money = $result['WIDtotal_fee'];
				}
				$db->query("update bm_user set user_money=user_money+".$enter_money.",enter_money=enter_money+".$result['WIDtotal_fee']." where uid=".$result['uid']);
				//--���״̬
				$info['status'] = 1;
				$info['edd_time'] = time();
				$db->update("bm_pay_rand_number",$info,"pay_rand_number='".$result['pay_rand_number']."'");
		}
        //�����ã�д�ı�������¼������������Ƿ�����
        //logResult("����д����Ҫ���ԵĴ������ֵ�����������еĽ����¼");
    }
    else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
		//�жϸñʶ����Ƿ����̻���վ���Ѿ���������
			//���û�������������ݶ����ţ�out_trade_no�����̻���վ�Ķ���ϵͳ�в鵽�ñʶ�������ϸ����ִ���̻���ҵ�����
			//���������������ִ���̻���ҵ�����
				
		//ע�⣺
		//���ֽ���״ֻ̬��һ������³��֡�����ͨ�˸߼���ʱ���ˣ���Ҹ���ɹ���
		/*  BOJOO ҵ���߼�  */
		$result = $db->get_one("select * from bm_pay_rand_number where pay_rand_number='".$out_trade_no."'");
		if($result['status']==0){
				$db->query("insert into bm_pay_cash (uid,cash_name,cash_money,cash_time) values ('".$result['uid']."','3135���߳�ֵ-".$out_trade_no."','".$result['WIDtotal_fee']."',".time().")");
				//--����״̬
				$gift_status = $db->get_one("select uid from bm_user_enter_gift where uid=".$result['uid']);
				if(empty($gift_status)){
					if($result['WIDtotal_fee']>=588){
						$db->query("insert into bm_pay_cash (uid,cash_name,cash_money,cash_time) values ('".$result['uid']."','3135�״γ�ֵ����-".$out_trade_no."','80',".time().")");
					}
					$enter_money = $result['WIDtotal_fee']>=588?($result['WIDtotal_fee']+80):$result['WIDtotal_fee'];
				}else{
					$enter_money = $result['WIDtotal_fee'];
				}
				$db->query("update bm_user set user_money=user_money+".$enter_money.",enter_money=enter_money+".$result['WIDtotal_fee']." where uid=".$result['uid']);
				//--���״̬
				$info['status'] = 1;
				$info['edd_time'] = time();
				$db->update("bm_pay_rand_number",$info,"pay_rand_number='".$result['pay_rand_number']."'");
		}
        //�����ã�д�ı�������¼������������Ƿ�����
        //logResult("����д����Ҫ���ԵĴ������ֵ�����������еĽ����¼");
    }

	//�������������ҵ���߼�����д�������ϴ�������ο�������
        
	echo "success";		//�벻Ҫ�޸Ļ�ɾ��
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //��֤ʧ��
    echo "fail";

    //�����ã�д�ı�������¼������������Ƿ�����
    //logResult("����д����Ҫ���ԵĴ������ֵ�����������еĽ����¼");
}
?>