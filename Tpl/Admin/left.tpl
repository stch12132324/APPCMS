		<div class="span2 leftMenu">
            <div class="well">
                <ul class="nav nav-list">
                <!--{if $module=='goods'||$module=='attribute'}-->
                	<li class="nav-header">商品管理</li>
                    <li {php echo ($action=='goodsList'||$action=='goodsEdit'||$action=='goodsAdd'||$action=='editImage'||$action=='editAttribute'||$action=='editParameter')?' class="active"':'';}><a href="/Admin-Goods-goodsList.html"><i class="icon-white icon-list"></i> 商品列表</a></li>
                    <li {php echo $action=='classList'||$action=='classAdd'||$action=='classEdit'?' class="active"':'';}><a href="/Admin-Goods-classList.html"><i class="icon-white icon-th"></i> 商品分类</a></li>
                    <!--<li <?php echo $action=='attributeList'||$action=='attributeAdd'||$action=='attributeEdit'?' class="active"':'';?>><a href="/Admin-Attribute-attributeList.html"><i class="icon-white icon-leaf"></i> 属性管理</a></li>
                    <li <?php echo $action=='positionList'?' class="active"':'';?>><a href="javascript:;"><i class="icon-white icon-random"></i> 推荐位管理</a></li>-->
                <!--{/if}-->
                <!--{if $module=='integral'}-->
                    <li class="nav-header">积分兑换</li>
                    <li {php echo $action=='orderList' ? ' class="active"':'';;}><a href="/Admin-Integral-orderList.html"><i class="icon-white icon-th"></i> 兑换列表</a></li>
                    <li {php echo $action=='assessList' ? ' class="active"':'';;}><a href="/Admin-Integral-assessList.html"><i class="icon-white icon-th"></i> 兑换评价</a></li>
                    <li {php echo ($action=='integralList'||$action=='integralEdit'||$action=='integralAdd'||$action=='editImage'||$action=='editParameter')?' class="active"':'';}><a href="/Admin-Integral-integralList.html"><i class="icon-white icon-list"></i> 兑换商品</a></li>
                    <li {php echo $action=='classList'||$action=='classAdd'||$action=='classEdit'?' class="active"':'';}><a href="/Admin-Integral-classList.html"><i class="icon-white icon-th"></i> 兑换分类</a></li>
                <!--{/if}-->
                <!--{if $module=='order'}-->
                	<li class="nav-header">订单管理</li>
                    <li {php echo $action=='orderList'||$action=='orderInfo'?' class="active"':'';}>
                    	<a href="Admin-Order-orderList.html"><i class="icon-white icon-list"></i> 订单列表</a>
                    </li>
                    <li {php echo $action=='payList'?' class="active"':'';}>
                        <a href="Admin-Order-payList.html"><i class="icon-white icon-list"></i> 支付列表</a>
                    </li>
                    <li {php echo $action=='assessList'?' class="active"':'';}>
                        <a href="Admin-Order-assessList.html"><i class="icon-white icon-comment"></i> 用户评价</a>
                    </li>
                <!--{/if}-->
                
                <!--{if $module=='user'}-->
                	<li class="nav-header">会员管理</li>
                    <li {php echo $action=='userList'||$action=='userEditPwd'||$action=='userEdit'?' class="active"':'';}>
                    	<a href="Admin-User-userList.html"><i class="icon-white icon-list"></i> 会员列表</a>
                    </li>
                <!--{/if}-->
                
                <!--{if $module=='news'}-->
                	<li class="nav-header">页面管理</li>
                    <!--{loop $news_class_list $key $li}-->
                    <li {php echo $class_id==$li['class_id']?' class="active"':'';}>
                    	<a href="Admin-News-newsList-class_id-{$li['class_id']}.html"><i class="icon-white icon-leaf"></i> {$li['class_name']}</a>
                    </li>
                    <!--{/loop}-->
                    <li {php echo $action=='classList'||$action=='classAdd'?' class="active"':'';}>
                    	<a href="Admin-News-classList.html"><i class="icon-white icon-th"></i> 页面分类</a>
                    </li>
                <!--{/if}-->

                <!--{if $module=='stat'}-->
                    <li class="nav-header">站点统计</li>
                    <li {php echo $action=='index' ? 'class="active"':'';}>
                        <a href="Admin-Stat-index.html"><i class="icon-white icon-th"></i> 全局统计</a>
                    </li>
                <!--{/if}-->

                <!--{if $module=='config'||$module=='nav'}-->
                	<li class="nav-header">参数设置</li>
                    <li class="divider"></li>
                    <li {php echo $action=='navList'?' class="active"':'';}>
                    	<a href="Admin-Nav-navList.html"><i class="icon-white icon-list"></i> 导航管理</a>
                    </li>
                    <li {php echo $action=='paymentList'||$action=='paymentAdd'?' class="active"':'';}>
                    	<a href="Admin-Config-paymentList.html"><i class="icon-white icon-lock"></i> 支付方式</a>
                    </li>
                    <li {php echo $action=='deliveryList'?' class="active"':'';}>
                    	<a href="Admin-Config-deliveryList.html"><i class="icon-white icon-gift"></i> 配送方式</a>
                    </li>
                    <li class="divider"></li>
                    <!--{loop $config_class_list $key $li}-->
                    <li {php echo ($class_id==$li['class_id'])&&$action=='configList'?' class="active"':'';}>
                    	<a href="Admin-Config-configList-class_id-{$li['class_id']}.html"><i class="icon-white icon-leaf"></i> {$li['class_name']}</a>
                    </li>
                    <!--{/loop}-->
                    <li class="divider"></li>
                    <li {php echo $action=='classList'?' class="active"':'';}>
                    	<a href="Admin-Config-classList.html"><i class="icon-white icon-th"></i> 参数分类</a>
                    </li>
                    <li {php echo $action=='allList'||$action=='configEdit'||$action=='configAdd'?' class="active"':'';}>
                    	<a href="Admin-Config-allList.html"><i class="icon-white icon-pencil"></i> 单个编辑</a>
                    </li>
                <!--{/if}-->
                
                    <li class="divider"></li>
                    <li><a href="#">帮助</a></li>
                </ul>
            </div>
        </div>