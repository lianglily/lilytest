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
<?php  $payments = $parentThis['payments'];   ?>
<?php  $current_payment_method = $parentThis['current_payment_method'];   ?>
<?php  $cart_info = $parentThis['cart_info'];   ?>
<?php  $currency_info = $parentThis['currency_info'];   ?>
<div class="onestepcheckout-payment-method">
	<p class="onestepcheckout-numbers onestepcheckout-numbers-3"><?= Yii::$service->page->translate->__('Payment Method');?></p>
	<div class="payment_info" >
		<div class="payment-methods">
			<dl id="checkout-payment-method-load" class="layui-nav layui-nav_pay" >
				<?php  if(is_array($payments) && !empty($payments)):  ?>
					<?php foreach($payments as $payment => $info): ?>
					<?php if(in_array($payment,Yii::$service->creditpay->refund->creditpay_payment) && Yii::$app->user->identity->credit_status !=1 ){
						continue;
					} ?>
					
					<?php 
						if($info['checked'] == true):
							$checked = 'checked="checked"';
						else:
							$checked = '';
						endif;
					?>
					<div  class="display_block line-height_30" >
					<dt>
					   
						<input 	 <?= $info['style'];  ?> <?=  $checked; ?> data-method="<?php $name=Yii::$service->page->translate->__($info['label']); echo Yii::$service->page->translate->__('Are you sure use \'{name}\' to pay?',['name' =>$name]); ?>" class="span_inline" id="p_method_<?= $payment ?>" value="<?= $payment ?>" name="payment_method" class="radio validate-one-required-by-name"  type="radio">
						<label class="p_method_label" for="p_method_<?= $payment ?>"><?= Yii::$service->page->translate->__($info['label']) ?></label>
						
					</dt>
					<dd id="container_payment_method_<?= $payment ?>" class="payment-method" >
						<ul class="form-list" id="payment_form_<?= $payment ?>" >
							
							<li class="form-alt"><?= Yii::$service->page->translate->__($info['supplement']) ?></li>
							<li>
							<?php if(isset($info['imageUrl']) && !empty($info['imageUrl'])): ?>
								<img alt="<?= $info['supplement'] ?>" class="margin_img" src="<?= $info['imageUrl'] ?>">
							<?php endif; ?>
							</li>
						</ul>
					</dd>
					</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</dl>
		</div>
	</div>
</div>

<script id="supplement-demo" type="text/html">
  
	<ul class="form-list" >
		{{#  if(d.imageUrl){ }}
		<li>
			<img alt="{{d.imageUrl}}" class="margin_img" src="{{d.imageUrl}}">
		</li>
		{{#  } }} 
		{{#  if(d.supplement){ }}
		<li class="form-alt">{{d.supplement}}</li>
		{{#  } }} 
	</ul>
  
</script>