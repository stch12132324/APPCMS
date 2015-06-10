<?php
/*
 * Action
 *
 */
class Action extends Base{
	private $_aGVal = array();
	public function __construct(){

	}

    /*
    * ��Ⱦģ��tpl
    */
	public function display($_tplName = '' , $_tpfile = '' , $_tpgroup = ''){
		if(is_array($this->_aGVal)) extract($this->_aGVal);
		if(is_array($this->CONFIG_LIST)) extract($this->CONFIG_LIST);
		$action = $this->_action;
		$module = $this->_module;
        $group  = $_tpgroup == '' ? $this->_group : $_tpgroup;
		if($_tplName==''){
			include template($action , $module , $group);
		}else{
            if($_tpfile != ''){
		        include template($_tplName , $_tpfile , $group);
            }else{
                include template($_tplName , $module , $group);
            }
		}
	}

    /*
    * @ע��ģ����� key-value ���� array
    * # key-value ģʽ
    * assign('name' , 'lubi');
    *
    * # arrayģʽ
    * $user = array(
    *   'username' => $username,
    *   'age'      => $age
    * );
    * assign('user' , $user);
    */
	public function assign($key = '' , $val = ''){
        if( is_array($key) ){
            foreach($key as $keys => $vals){
                $this->_aGVal[$keys] = $vals;
            }
            unset($key);
        }else{
		    $this->_aGVal[$key] = $val;
		    unset($key,$val);
        }
	}

    /*
    * POST��ֵ����
    */
    public function getPost($keyName='' , $filterTypeArr = array()){
        $val = isset($_POST[$keyName]) ? $_POST[$keyName] : '';
        if(!empty($filterTypeArr)){
            $val = $this->actionFilter($val , $filterTypeArr);
        }
        return $val;
    }

    /*
    * GET��ֵ����
    */
    public function getGet($keyName='' , $filterTypeArr = array()){
        $val = isset($_GET[$keyName]) ? $_GET[$keyName] : '';
        if(!empty($filterTypeArr)){
            $val = $this->actionFilter($val , $filterTypeArr);
        }
        return $val;
    }
	
	/*
	* �ܴ�ֵ����
	*/
	public function getParams($keyName='' , $filterTypeArr = array()){
        $val = isset($_GET[$keyName]) ? $_GET[$keyName] : '';
		$val = isset($_POST[$keyName]) ? $_POST[$keyName] : '';
        if(!empty($filterTypeArr)){
            $val = $this->actionFilter($val , $filterTypeArr);
        }
        return $val;
    }
	
    /*
    * post �� get ����ֱ���滻�����ж�����������
    */
    private function actionFilter($val ='' , $filterTypeArr= '')
    {
        if(is_array($filterTypeArr)){
            foreach($filterTypeArr as $type){
                $val = $this->getFilterVal($val , $type);
            }
        }else{
            $val = $this->getFilterVal($val , $filterTypeArr);
        }
        return $val;
    }

    private  function getFilterVal($val='' , $type='')
    {
        switch($type){
            case 'int':
                $val = preg_replace("/[^0-9]/isU", "" , $val);
                $val = intval($val);
                break;
            case 'alphanum':
                $val = preg_replace("/[^a-zA-Z0-9_]/isU" , "" , $val);
                break;
            case 'striptags':
                $val = strip_tags($val);
                break;
            case 'trim':
                $val = trim($val);
                break;
            case 'lower':
                $val = strtolower($val);
                break;
            case 'upper':
                $val = strtoupper($val);
                break;
        }
        return $val;
    }
}
?>