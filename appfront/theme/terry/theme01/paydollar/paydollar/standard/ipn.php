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
.paypal_success{line-height:24px;}
</style>
<div class="main container one-column">
	<div class="col-main">
		<div class="clear"></div>
		<div class="paypal_success">
			
			<h2 class="sub-title"><?= $message ?><?= $error ?></h2>
			
			<p><?= Yii::$service->page->translate->__('Your order is :#'); ?> <?= $increment_id ?>.</p>
			<div class="buttons-set">
				<button type="button" class="button" title="Continue Shopping" onclick="window.location='<?= Yii::$service->url->homeUrl();  ?>'"><span><span><?= Yii::$service->page->translate->__('Continue Shopping'); ?></span></span></button>
			</div>
			<?php // var_dump($order); ?>
		</div>
	</div>
</div>