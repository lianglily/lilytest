<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<?php  $payments = $parentThis['payments'];   ?>
<?php  $current_payment_method = $parentThis['current_payment_method'];   ?>
<style>
.payment-method{
	background-color: #9e9e9ea1;
}
.form-list{
	margin: auto;
    width: 200px;
    display: flex;
    justify-content: center;
    align-content: center;
    height: 100%;
    align-items: center;
}
.form-list li{
	background-color: white;
    line-height: 2rem;
    text-align: center;
}
.form-list ul{
	width: 100%;
}
</style>
<div class="onestepcheckout-payment-method">
	<p class="onestepcheckout-numbers onestepcheckout-numbers-3"><?= Yii::$service->page->translate->__('Payment Method');?></p>
	<div class="payment_info">
		<div class="payment-methods list-block">
			<dl id="checkout-payment-method-load">
				<?php  if(is_array($payments) && !empty($payments)):  ?>
					<?php foreach($payments as $payment => $info): ?>	
					<?= $info['style'];  ?>	
					<?php 
						if($info['checked'] == true):
							$checked = 'checked="checked"';
						else:
							$checked = '';
						endif;
					?>	
					<dt>
						<div class="item-content">
						  <div class="item-media">
						  		<input data-method="<?php $name=Yii::$service->page->translate->__($info['label']); echo Yii::$service->page->translate->__('Are you sure use \'{name}\' to pay?',['name' =>$name]); ?>" <?=  $checked; ?>  id="p_method_<?= $payment ?>" value="<?= $payment ?>" name="payment_method" title="<?= $info['label']; ?>" class="radio validate-one-required-by-name display_inline" <?=  ($current_payment_method == $payment) ? 'checked="checked"' : '' ; ?> type="radio">
						  </div>
						  <div class="item-inner">
							<div class="item-title label"><label for="p_method_<?= $payment ?>"><?= Yii::$service->page->translate->__($info['label']) ?></label></div>
							<div class="item-input">
							  <?php if((isset($info['supplement']) && !empty($info['supplement']))||(isset($info['imageUrl']) && !empty($info['imageUrl']))): ?>
								<a href="#" class="open-popup" data-popup=".popup-<?= $payment ?>"></a>
								<?php endif; ?>
								<?php if((isset($info['imageUrl']) && !empty($info['imageUrl']))){ ?>
								<img alt="<?= $payment ?>" class="payment-form-img" src="<?= $info['imageUrl'] ?>">
								<?php }elseif((isset($info['supplement']) && !empty($info['supplement']))){ ?>
									 <?= Yii::$service->page->translate->__($info['supplement']) ?>
								<?php } ?>
							</div>
						  </div>
						</div>
					</dt>
					<dd id="container_payment_method_<?= $payment ?>" class="close-popup payment-method popup popup-<?= $payment ?>" >
						<div class="form-list">
						<ul  id="payment_form_<?= $payment ?>" >
							<li>
							<?php if((isset($info['imageUrl']) && !empty($info['imageUrl']))){ ?>
								<img alt="<?= $payment ?>" class="payment-form-img" src="<?= $info['imageUrl'] ?>">
							<?php }elseif((isset($info['supplement']) && !empty($info['supplement']))){ ?>
							     <?= Yii::$service->page->translate->__($info['supplement']) ?>
							<?php } ?>
							</li>
						</ul>
						</div>
					</dd>
					<?php endforeach; ?>
				<?php endif; ?>
			</dl>
		</div>
	</div>
</div>