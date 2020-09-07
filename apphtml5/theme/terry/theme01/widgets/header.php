<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<style>
.pull-right a{padding-right:0.4rem}
.badge{
	position: absolute;
    top: .1rem;
    left: 50%;
    z-index: 100;
    height: .8rem;
    min-width: .8rem;
    padding: 0 .2rem;
    font-size: .6rem;
    line-height: .8rem;
    color: #fff;
    vertical-align: top;
    background: red;
    border-radius: .5rem;
    margin-left: .1rem;
}
</style>
<header class="bar bar-nav" style="text-align:center">
	<!-- a class="icon icon-menu pull-left open-panel" data-panel="#panel-left-menu"></a -->
	<a class="icon icon-menu pull-left open-menu" ></a>
	<a class="icon pull-left icon-menu" style="color: #f7f7f8;" ></a>
	<a href="/" style="margin-left: auto; margin-right: auto;">
	  <img src="<?= Yii::$service->image->getImgUrl('apphtml5/custom/burotech-logo.png'); ?>" style="height:1.6rem;margin-top:0.3rem">
	</a>
	<div class="pull-right">
		<a class="icon icon-phone" href="https://api.whatsapp.com/send?phone=85298644188&amp;text=您好，我們能為您提供什麼服務？" target="_blank"></a>
		<a class="tab-item external icon icon-me open-panel"  data-panel="#panel-left-account"><span id="js_user_grade" ></span></a>
		<a class="icon icon-cart" href="<?= Yii::$service->url->getUrl('checkout/cart'); ?>" external><span id="js_user_cart" ></span></a>
	</div>
	<h1 class="display_none">
		<span class="head_text margin-right_20" ><?= Yii::$app->store->get('base_info', 'default_meta')['default_meta_'.Yii::$service->store->currentLangCode]?></span><span class="head_text"><i class="layui-icon layui-icon-service" style="font-size: 40px;color: #777;"></i>   <?= Yii::$app->store->get('base_info', 'default_contact')['default_contact_'.Yii::$service->store->currentLangCode]?></span>
	</h1>
</header>
<script>
	window.onload=function(){
		loginInfoUrl = "/customer/ajax";
		product_id = $(".product_view_id").val();
		$.ajax({
			async: !0,
			timeout: 6e3,
			dataType: "json",
			type: "get",
			data: {
				currentUrl: window.location.href,
				product_id: product_id
			},
			url: loginInfoUrl,
			success: function(e, t) {
				if(e.loginStatus){
					$('#js_user_grade').html(e.grade);
					$('#js_user_grade').addClass('badge');
					$('#js_user_cart').html(e.cart_qty);
					$('#js_user_cart').addClass('badge');
				}
			},
			error: function(e, t, r) {}
		})
	   
	}
</script>


