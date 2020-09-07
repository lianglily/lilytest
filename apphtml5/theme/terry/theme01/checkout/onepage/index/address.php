<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<?php  $address_list = $parentThis['address_list'];   ?>
<?php  $cart_address_id = $parentThis['cart_address_id'];   ?>
<?php  $country_select = $parentThis['country_select'];   ?>
<?php  $state_html = $parentThis['state_html'];   ?>
<?php  $cart_address = $parentThis['cart_address'];   ?>
<style>
.required{color:red}
</style>
<div id="billing_address">		
	<ul>
		<li>
			<p class="onestepcheckout-numbers onestepcheckout-numbers-1"><?= Yii::$service->page->translate->__('Shipping Address');?></p>
		</li>
		<li>
			<div class="list-block">
				<ul id="billing_address_list" class="billing_address_list_new" >
					<li>
						<div class="item-content">
						  <div class="item-media"><i class="icon icon-form-name"></i></div>
						  <div class="item-inner">
							<div class="item-title label"><?= Yii::$service->page->translate->__('First Name');?></div>
							<div class="item-input">
							  	<input value="<?= $cart_address['first_name'] ?>" id="billing:firstname" name="billing[first_name]" class="required-entry input-text" type="text">
							</div>
						  </div>
						</div>
					  </li>
					  <li>
						<div class="item-content">
						  <div class="item-media"><i class="icon icon-form-name"></i></div>
						  <div class="item-inner">
							<div class="item-title label"><?= Yii::$service->page->translate->__('Last Name');?></div>
							<div class="item-input">
							  	<input value="<?= $cart_address['last_name'] ?>" id="billing:lastname" name="billing[last_name]" class="required-entry input-text" type="text">
							</div>
						  </div>
						</div>
					  </li>
					<li>
						<div class="item-content">
						  <div class="item-media"><i class="icon icon-form-name"></i></div>
						  <div class="item-inner">
							<div class="item-title label"><?= Yii::$service->page->translate->__('Email Address');?></div>
							<div class="item-input">
							<input  value="<?= $cart_address['email'] ?>" class="validate-email required-entry input-text" title="Email Address" id="billing:email" name="billing[email]" type="text">
							<div class="customer_email_validation">
							
							</div>
							</div>
						  </div>
						</div>
					  </li>
					<li>
						<div class="item-content">
						  <div class="item-media"><i class="icon icon-form-name"></i></div>
						  <div class="item-inner">
							<div class="item-title label"><?= Yii::$service->page->translate->__('Telephone');?></div>
							<div class="item-input">
							<input value="<?= $cart_address['telephone'] ?>" id="billing:telephone" class="required-entry input-text" title="Telephone" name="billing[telephone]" type="text">

							</div>
						  </div>
						</div>
					  </li>
					  
					<li>
						<div class="item-content">
						  <div class="item-media"><i class="icon icon-form-name"></i></div>
						  <div class="item-inner">
							<div class="item-title label"><?= Yii::$service->page->translate->__('Shipping Address');?></div>
							<div class="item-input">
							<select style="width:50px;display:inline" id="province" name="billing[country]" >
								<?php $areas=Yii::$service->shipping->area;
										foreach($areas as $val){
								?>
								<option value=<?= $val['id'] ?> <?php if($cart_address['country']==1){?>checked<?php }?> ><?= $val['name'] ?></option>
								<?php }?>
								
							</select>
							<input type="text" placeholder="" id='city-picker' style="display:inline;width:60%"/>
							
						    <input type="hidden" id="city" name="billing[state]" value="<?= $cart_address['state']?$cart_address['state']:1; ?>">
						    <input type="hidden" id="district" name="billing[city]" value="<?= $cart_address['city']?$cart_address['state']:1; ?>">
						    <input type="hidden" id="date" name="date">
							</div>
						  </div>
						</div>
					  </li>
					  <li>
						<div class="item-content">
						  <div class="item-media"><i class="icon icon-form-name"></i></div>
						  <div class="item-inner">
							<div class="item-title label"><?= Yii::$service->page->translate->__('Street');?></div>
							<div class="item-input">
							<input value="<?= $cart_address['street1'] ?>" class="required-entry input-text onestepcheckout-address-line" id="billing:street1" name="billing[street1]" title="Street Address 1" type="text">

							</div>
						  </div>
						</div>
					  </li>
					  <li>
						<div class="item-content">
						  <div class="item-media"><i class="icon icon-form-name"></i></div>
						  <div class="item-inner">
							<div class="item-title label"><?= Yii::$service->page->translate->__('Building');?></div>
							<div class="item-input">
							<input value="<?= $cart_address['street2'] ?>" class="input-text onestepcheckout-address-line" id="billing:street2" name="billing[street2]" title="Street Address 2" type="text">

							</div>
						  </div>
						</div>
					  </li>
					
					
					<input type="hidden" value="000000" name="billing[zip]">
					
					<?php if(!Yii::$app->user->isGuest):  ?>
					
					<?php else: ?>
					<li class="clearfix">
						<div class="input-box">
							<input value="1" name="create_account" id="id_create_account" type="checkbox">
							<label class="display_inline" for="id_create_account"><?= Yii::$service->page->translate->__('Create an account for later use');?></label>
						</div>
						<div class="label_create_account">
						
						</div>
					</li>
					<li class="display_none" id="onestepcheckout-li-password">
						<div class="input-box input-password">
							<label for="billing:customer_password"><?= Yii::$service->page->translate->__('Password');?></label>
							<input name="billing[customer_password]" id="billing:customer_password" title="Password" value="" class="validate-password input-text customer_password" type="password">
						</div>
						<div class="input-box input-password">
							<label for="billing:confirm_password"><?= Yii::$service->page->translate->__('Confirm Password');?></label>
							<input name="billing[confirm_password]" title="Confirm Password" id="billing:confirm_password" value="" class="validate-password input-text customer_confirm_password" type="password">
						</div>
					</li>
					<?php endif;  ?>
					<input type="hidden" value="<?= $weekday ?>" name="weekday" id="weekday"/>
				</ul>							
			</div>
		</li>
		
	</ul>
</div>
