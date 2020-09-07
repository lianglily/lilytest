<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<div id="top_nav">
	<input type="hidden" class="currentBaseUrl" value="<?= $currentBaseUrl ?>" />
	<input type="hidden" class="logoutUrl" value="<?= $logoutUrl ?>" />
	<input type="hidden" class="logoutStr" value="<?= Yii::$service->page->translate->__('Logout'); ?>" />
	<input type="hidden" class="welcome_str" value="<?= Yii::$service->page->translate->__('Welcome!'); ?>" />
	<div class="top_nav_inner">	    
		
		<div class="top_nav_right">
			<div class="login-text t_r">
				<span id="js_isNotLogin">
					<a href="<?= Yii::$service->url->getUrl('customer/account/login') ?>" rel="nofollow"><?= Yii::$service->page->translate->__('Sign In / Join Free'); ?></a>
				</span>
			</div>
			<dl class="top_account t_r" style="width: auto;min-width: 50px;">
				<dt>
					<a href="javascript:void(0);" rel="nofollow" class="layui-icon layui-icon-username my_icon" class="mycoount"></a>
					 <span id="js_user_grade"></span>
				</dt>
				<dd >
					<ul>
						<li><a href="<?= Yii::$service->url->getUrl('customer/editaccount') ?>" rel="nofollow"><?= Yii::$service->page->translate->__('My Account'); ?></a></li>
						<li><a href="<?= Yii::$service->url->getUrl('customer/order') ?>" rel="nofollow"><?= Yii::$service->page->translate->__('My Orders'); ?></a></li>
						<li><a href="<?= Yii::$service->url->getUrl('customer/productfavorite') ?>" rel="nofollow"><?= Yii::$service->page->translate->__('My Favorites'); ?></a></li>
						<li><a href="<?= Yii::$service->url->getUrl('customer/productreview') ?>" rel="nofollow"><?= Yii::$service->page->translate->__('My Review'); ?></a></li>
					</ul>
				</dd>
			</dl>
			<div class="mywish t_r">
				<a href="<?= Yii::$service->url->getUrl('customer/productfavorite') ?>" class="layui-icon layui-icon-heart my_icon">
					
				</a>
				<span class="mywish-text" id="js_favour_num">0</span>
			</div>
			<div class="mycart t_r">
				<a href="<?= Yii::$service->url->getUrl('checkout/cart') ?>" class="layui-icon layui-icon-cart my_icon" id="js_topBagWarp">
					
				</a>
				<span class="mycart-text" id="js_cart_items">0</span>
			</div>
		</div>
	</div><!--end .top_nav_inner-->
</div><!--end #top_nav-->

<div id="top_main">
<div class="top_main_inner pr">
		<div class="top_header">
			<div class="topSeachForm">
				<h1 class="top_header_h1">
				</h1>
				<div class="top_header_div">
				<?= Yii::$service->page->widget->render('base/topsearch',$this); ?>
				</div>
			</div>
			<div class="logo">
			<a titel="fecshop logo" href="<?= $homeUrl ?>" class="margin-left_20">
				<img src="<?= Yii::$service->image->getImgUrl('appfront/custom/logo-burotech.png'); ?>"  />
			</a>
			</div>
		</div><!--end .top_header-->
    </div><!--end .top_main_inner-->
</div>
