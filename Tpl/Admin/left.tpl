		<div class="span2 leftMenu">
            <div class="well">
                <ul class="nav nav-list">
                <!--{if $module=='goods'||$module=='attribute'}-->
                	<li class="nav-header">��Ʒ����</li>
                    <li {php echo ($action=='goodsList'||$action=='goodsEdit'||$action=='goodsAdd'||$action=='editImage'||$action=='editAttribute'||$action=='editParameter')?' class="active"':'';}><a href="/Admin-Goods-goodsList.html"><i class="icon-white icon-list"></i> ��Ʒ�б�</a></li>
                    <li {php echo $action=='classList'||$action=='classAdd'||$action=='classEdit'?' class="active"':'';}><a href="/Admin-Goods-classList.html"><i class="icon-white icon-th"></i> ��Ʒ����</a></li>
                    <!--<li <?php echo $action=='attributeList'||$action=='attributeAdd'||$action=='attributeEdit'?' class="active"':'';?>><a href="/Admin-Attribute-attributeList.html"><i class="icon-white icon-leaf"></i> ���Թ���</a></li>
                    <li <?php echo $action=='positionList'?' class="active"':'';?>><a href="javascript:;"><i class="icon-white icon-random"></i> �Ƽ�λ����</a></li>-->
                <!--{/if}-->
                <!--{if $module=='integral'}-->
                    <li class="nav-header">���ֶһ�</li>
                    <li {php echo $action=='orderList' ? ' class="active"':'';;}><a href="/Admin-Integral-orderList.html"><i class="icon-white icon-th"></i> �һ��б�</a></li>
                    <li {php echo $action=='assessList' ? ' class="active"':'';;}><a href="/Admin-Integral-assessList.html"><i class="icon-white icon-th"></i> �һ�����</a></li>
                    <li {php echo ($action=='integralList'||$action=='integralEdit'||$action=='integralAdd'||$action=='editImage'||$action=='editParameter')?' class="active"':'';}><a href="/Admin-Integral-integralList.html"><i class="icon-white icon-list"></i> �һ���Ʒ</a></li>
                    <li {php echo $action=='classList'||$action=='classAdd'||$action=='classEdit'?' class="active"':'';}><a href="/Admin-Integral-classList.html"><i class="icon-white icon-th"></i> �һ�����</a></li>
                <!--{/if}-->
                <!--{if $module=='order'}-->
                	<li class="nav-header">��������</li>
                    <li {php echo $action=='orderList'||$action=='orderInfo'?' class="active"':'';}>
                    	<a href="Admin-Order-orderList.html"><i class="icon-white icon-list"></i> �����б�</a>
                    </li>
                    <li {php echo $action=='payList'?' class="active"':'';}>
                        <a href="Admin-Order-payList.html"><i class="icon-white icon-list"></i> ֧���б�</a>
                    </li>
                    <li {php echo $action=='assessList'?' class="active"':'';}>
                        <a href="Admin-Order-assessList.html"><i class="icon-white icon-comment"></i> �û�����</a>
                    </li>
                <!--{/if}-->
                
                <!--{if $module=='user'}-->
                	<li class="nav-header">��Ա����</li>
                    <li {php echo $action=='userList'||$action=='userEditPwd'||$action=='userEdit'?' class="active"':'';}>
                    	<a href="Admin-User-userList.html"><i class="icon-white icon-list"></i> ��Ա�б�</a>
                    </li>
                <!--{/if}-->
                
                <!--{if $module=='news'}-->
                	<li class="nav-header">ҳ�����</li>
                    <!--{loop $news_class_list $key $li}-->
                    <li {php echo $class_id==$li['class_id']?' class="active"':'';}>
                    	<a href="Admin-News-newsList-class_id-{$li['class_id']}.html"><i class="icon-white icon-leaf"></i> {$li['class_name']}</a>
                    </li>
                    <!--{/loop}-->
                    <li {php echo $action=='classList'||$action=='classAdd'?' class="active"':'';}>
                    	<a href="Admin-News-classList.html"><i class="icon-white icon-th"></i> ҳ�����</a>
                    </li>
                <!--{/if}-->

                <!--{if $module=='stat'}-->
                    <li class="nav-header">վ��ͳ��</li>
                    <li {php echo $action=='index' ? 'class="active"':'';}>
                        <a href="Admin-Stat-index.html"><i class="icon-white icon-th"></i> ȫ��ͳ��</a>
                    </li>
                <!--{/if}-->

                <!--{if $module=='config'||$module=='nav'}-->
                	<li class="nav-header">��������</li>
                    <li class="divider"></li>
                    <li {php echo $action=='navList'?' class="active"':'';}>
                    	<a href="Admin-Nav-navList.html"><i class="icon-white icon-list"></i> ��������</a>
                    </li>
                    <li {php echo $action=='paymentList'||$action=='paymentAdd'?' class="active"':'';}>
                    	<a href="Admin-Config-paymentList.html"><i class="icon-white icon-lock"></i> ֧����ʽ</a>
                    </li>
                    <li {php echo $action=='deliveryList'?' class="active"':'';}>
                    	<a href="Admin-Config-deliveryList.html"><i class="icon-white icon-gift"></i> ���ͷ�ʽ</a>
                    </li>
                    <li class="divider"></li>
                    <!--{loop $config_class_list $key $li}-->
                    <li {php echo ($class_id==$li['class_id'])&&$action=='configList'?' class="active"':'';}>
                    	<a href="Admin-Config-configList-class_id-{$li['class_id']}.html"><i class="icon-white icon-leaf"></i> {$li['class_name']}</a>
                    </li>
                    <!--{/loop}-->
                    <li class="divider"></li>
                    <li {php echo $action=='classList'?' class="active"':'';}>
                    	<a href="Admin-Config-classList.html"><i class="icon-white icon-th"></i> ��������</a>
                    </li>
                    <li {php echo $action=='allList'||$action=='configEdit'||$action=='configAdd'?' class="active"':'';}>
                    	<a href="Admin-Config-allList.html"><i class="icon-white icon-pencil"></i> �����༭</a>
                    </li>
                <!--{/if}-->
                
                    <li class="divider"></li>
                    <li><a href="#">����</a></li>
                </ul>
            </div>
        </div>