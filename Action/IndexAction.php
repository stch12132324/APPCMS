<?php
IA("IndexBaseAction");
class IndexAction extends IndexBaseAction{

	public function index(){
        echo '404 Not Found!';
    }

    public function dbUnit(){
        $db  = LC("Db_mysqli");
        $conditions = array(
            'pro_class1' => '6',
            'table'      => 'product',
            'fields'     => 'pro_name,pro_class1',
            'limit'      => 10
        );
        $rlt = $db->conditions($conditions)->fetch_all();
        $this->assign('rlt' , $rlt);
        $this->display();
    }
}
?>