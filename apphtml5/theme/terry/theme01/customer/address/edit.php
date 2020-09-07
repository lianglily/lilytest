<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<div class="account-ds">
	<div class="bar bar-nav account-top-m">
		<a external class="button button-link button-nav pull-left" href="<?= Yii::$service->url->getUrl('customer/address'); ?>">
			<span class="icon icon-left"></span>
		</a>
		<h1 class='title'><?= Yii::$service->page->translate->__('Edit Address'); ?></h1>
	</div>
</div>
<?= Yii::$service->page->widget->render('base/flashmessage'); ?>	
<div class="list-block customer-login  customer-register">
	<form class="addressedit" action="<?= Yii::$service->url->getUrl('customer/address/edit'); ?>" id="form-validate" method="post">
		<?= \fec\helpers\CRequest::getCsrfInputHtml();  ?>
		<input name="address[address_id]" value="<?= $address_id; ?>" type="hidden">
					
		<ul>
			<li>
				<div class="item-content">
					<div class="item-media">
						<i class="icon icon-form-name"></i>
					</div>
					<div class="item-inner">
						<div class="item-title label"><?= Yii::$service->page->translate->__('Email Address'); ?></div>
						<div class="item-input">
							<input class="input-text required-entry" maxlength="255" placeholder="<?= Yii::$service->page->translate->__('Email Address'); ?>" value="<?= $email ?>" name="address[email]" id="customer_email"   type="text">
						</div>
					</div>
				</div>
			</li>				
			
			<li>
				<div class="item-content">
					<div class="item-media">
						<i class="icon icon-form-name"></i>
					</div>
					<div class="item-inner">
						<div class="item-title label"><?= Yii::$service->page->translate->__('First Name'); ?></div>
						<div class="item-input">
							<input class="input-text required-entry" maxlength="255" placeholder="<?= Yii::$service->page->translate->__('First Name'); ?>" title="First Name" value="<?= $first_name ?>" name="address[first_name]" id="firstname" type="text">
						</div>
					</div>
				</div>
			</li>	
			
			<li>
				<div class="item-content">
					<div class="item-media">
						<i class="icon icon-form-name"></i>
					</div>
					<div class="item-inner">
						<div class="item-title label"><?= Yii::$service->page->translate->__('Last Name'); ?></div>
						<div class="item-input">
							<input class="input-text required-entry" maxlength="255" placeholder="<?= Yii::$service->page->translate->__('Last Name'); ?>"  title="Last Name" value="<?= $last_name ?>" name="address[last_name]" id="lastname" type="text">
						</div>
					</div>
				</div>
			</li>	
			
			<li>
				<div class="item-content">
					<div class="item-media">
						<i class="icon icon-form-name"></i>
					</div>
					<div class="item-inner">
						<div class="item-title label"><?= Yii::$service->page->translate->__('Telephone'); ?></div>
						<div class="item-input">
							<input class="input-text required-entry" maxlength="255" placeholder="<?= Yii::$service->page->translate->__('Telephone'); ?>"  title="telephone" value="<?= $telephone ?>" name="address[telephone]" id="lastname" type="text">
						</div>
					</div>
				</div>
			</li>	
			
			<li>
				<div class="item-content">
					<div class="item-media">
						<i class="icon icon-form-name"></i>
					</div>
					<div class="item-inner">
						<div class="item-title label"><?= Yii::$service->page->translate->__('Country'); ?></div>
						<div class="item-input">
							<select id="province" class="address_country validate-select" placeholder="<?= Yii::$service->page->translate->__('Country'); ?>"   title="Country" name="address[country]">
								<?php $areas=Yii::$service->shipping->area;
										foreach($areas as $val){
								?>
								<option value=<?= $val['id'] ?> <?php if($country==$val['id']){?>checked<?php }?> ><?= $val['name'] ?></option>
								<?php }?>
							</select>
							<input type="text" placeholder="" id='city-picker'/>
							<!-- input type="hidden" id="province" name="billing[country]" value="1" -->
							<input type="hidden" id="city" name="address[state]" value="<?= $state ?>">
							<input type="hidden" id="district" name="address[city]" value="<?= $city ?>">
							<input type="hidden" id="date" name="date">
						</div>
					</div>
				</div>
			</li>	
			
			
			
			
			<li>
				<div class="item-content">
					<div class="item-media">
						<i class="icon icon-form-name"></i>
					</div>
					<div class="item-inner">
						<div class="item-title label"><?= Yii::$service->page->translate->__('Street'); ?></div>
						<div class="item-input">
							<input class="input-text required-entry" maxlength="255" placeholder="<?= Yii::$service->page->translate->__('Street'); ?>" value="<?= $street1 ?>" name="address[street1]" id="street1" type="text" />
						</div>
					</div>
				</div>
			</li>	
			
			<li>
				<div class="item-content">
					<div class="item-media">
						<i class="icon icon-form-name"></i>
					</div>
					<div class="item-inner">
						<div class="item-title label"><?= Yii::$service->page->translate->__('Building'); ?></div>
						<div class="item-input">
							<input class="input-text required-entry" maxlength="255" placeholder="<?= Yii::$service->page->translate->__('Building'); ?>" value="<?= $street2 ?>" name="address[street2]" id="street2" type="text" />
						</div>
					</div>
				</div>
											<input class="input-text required-entry" maxlength="255" placeholder="<?= Yii::$service->page->translate->__('Zip Code'); ?>" value="000000" name="address[zip]" id="zip" type="hidden">
			</li>		
			
			
			
			
			<li class="control">
				<div class="change_password_label item-content">
					<input name="address[is_default]" value="1" title="Save in address book" id="address:is_default" class="address_is_default checkbox" <?= $is_default_str; ?> type="checkbox">
						<label for="address:is_default" class="display_inline"><?= Yii::$service->page->translate->__('Is Default');?></label>
						
				</div>
			</li>
		</ul>	
		<div class="clear"></div>
		<div class="buttons-set">
			<p>
				<a external href="javascript:void(0)" onclick="submit_address()"   id="js_registBtn" class="button button-fill">
					<?= Yii::$service->page->translate->__('Save Address'); ?>
				</a>
			</p>
		</div>
	</form>
</div>

<script>
<?php $this->beginBlock('editCustomerAddress') ?>
	$(document).ready(function(){
		$("#province").change(function(){
			$("#city-picker").cityPicker("change");
		});
		$("#city-picker").cityPicker({
            toolbarTemplate: '<header class="bar bar-nav">\
            <button class="button button-link pull-right close-picker">确定</button>\
            <h1 class="title">选择所在地址</h1>\
            </header>',
            date: '#date',//省输入框,一般都是隐藏的，获取身份ID
            city: '#city', //城市输入框，一般都是隐藏的，获取城市ID
			district: '#district' //城市输入框，一般都是隐藏的，获取城市ID
        });	
        
	})
	$(document).ready(function(){
		$(".address_country").change(function(){
			//alert(111);
			ajaxurl = "<?= Yii::$service->url->getUrl('customer/address/changecountry') ?>";
			country = $(this).val();
			$.ajax({
				async:false,
				timeout: 8000,
				dataType: 'json', 
				type:'get',
				data: {
						'country':country,
				},
				url:ajaxurl,
				success:function(data, textStatus){ 
					$(".state_html").html(data.state);
				},
				error:function (XMLHttpRequest, textStatus, errorThrown){
						
				}
			});
			
		});

	});	
	function submit_address(){
		i = 1;
		$(".addressedit input").each(function(){
			type = $(this).attr("type");
			if(type != "hidden"){
				value = $(this).val();
				if(!value){
					//alert($(this).hasClass('optional'));
					if(!$(this).hasClass('optional')){
						i = 0;
					}
				}
			}
		});
		
		$(".addressedit select").each(function(){
			value = $(this).val();
			if(!value){
				i = 0;
			}
		});
		if(i){
			$(".addressedit").submit();
		}else{
			alert("<?= Yii::$service->page->translate->__('You Must Fill All Field'); ?>");
		}
	}
	
	
<?php $this->endBlock(); ?> 
<?php $this->registerJs($this->blocks['editCustomerAddress'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>

</script>