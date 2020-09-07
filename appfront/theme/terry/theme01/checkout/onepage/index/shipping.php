<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<?php
use fecshop\app\appfront\helper\Format;
?>
<?php  $shippings = $parentThis['shippings'];   ?>
<div class="onestepcheckout-shipping-method">
	<p class="onestepcheckout-numbers onestepcheckout-numbers-2"><?= Yii::$service->page->translate->__('Shipping Method') ?></p>
	<div class="onestepcheckout-shipping-method-block">    
		<dl class="shipment-methods">
			<?php if(!empty($shippings) &&  is_array($shippings)): ?>
			<?php 	foreach($shippings as $shipping): 
			?>
			
			<div class="shippingmethods">
				<div class="flatrate"><?= Yii::$service->page->translate->__($shipping['label']) ?></div>
				<div>
					<input readonly data-role="none" <?= $shipping['checked'] ? 'checked="checked"' : '' ?> type="radio" id="s_method_flatrate_flatrate<?= $shipping['shipping_i'] ?>" value="<?= $shipping['method'] ?>" class="validate-one-required-by-name" name="shipping_method">
					<label for="s_method_flatrate_flatrate<?= $shipping['shipping_i'] ?>">
						<strong>                 
							<span class="price"><?= $shipping['code'] ?><?= Format::price($shipping['cost']); ?></span>
						</strong>
					</label>
				</div>
			</div>
			<?php 	 endforeach; ?>
			<?php endif; ?>
		</dl>
	</div>
</div>
<script>
window.onload = function(){
	$("input[name=shipping_method]").onclick(function(){
		
	});
	$(".onestepcheckout-column-middle").off("click").on("click","input[name=shipping_method]",function(){
		console.log('sss');
		ajaxreflush();
	});
}
</script>