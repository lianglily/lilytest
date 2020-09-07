<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
 
use fec\helpers\CRequest;
?>
<div class="main container two-columns-left">
	<div class="clear"></div>
<?= Yii::$service->page->widget->render('base/breadcrumbs',$this); ?>
<?= Yii::$service->page->widget->render('base/flashmessage'); ?>
	<div class="col-main account_center">
		<div class="std">
			<div>
				<form class="addressedit " action="<?= Yii::$service->url->getUrl('customer/address/edit'); ?>" id="form-validate" method="post">
					<?php echo CRequest::getCsrfInputHtml();  ?>
                    <input name="address[address_id]" value="<?= $address_id; ?>" type="hidden">
					<div class="">
						<ul class="layui-form layui-row">
							<li class="layui-col-xs6 layui-col-sm6 layui-col-md6">
								<label class="required" for="email"><?= Yii::$service->page->translate->__('Email Address');?></label>
								<div class="input-box">
									<input class="input-text required-entry" maxlength="255" title="Email" value="<?= $email ?>" name="address[email]" id="customer_email"   type="text">
									
								</div>
							</li>
							<li class="layui-col-xs6 layui-col-sm6 layui-col-md3">
								<div class="field name-firstname">
									<label class="required" for="firstname"><?= Yii::$service->page->translate->__('First Name');?></label>
									<div class="input-box">
										<input class="input-text required-entry width_150"  maxlength="255" title="First Name" value="<?= $first_name ?>" name="address[first_name]" id="firstname" type="text">
									</div>
								</div>
							</li>
							<li class="layui-col-xs6 layui-col-sm6 layui-col-md3">
								<div class="field name-lastname">
									<label class="required" for="lastname"><?= Yii::$service->page->translate->__('Last Name');?></label>
									<div class="input-box">
										<input class="input-text required-entry width_150" maxlength="255" title="Last Name" value="<?= $last_name ?>" name="address[last_name]" id="lastname" type="text">
									</div>
								</div>
							</li>
							
							
							<li class="layui-col-xs6 layui-col-sm6 layui-col-md6">
								<div class="field name-lastname">
										<label class="required" for="lastname"><?= Yii::$service->page->translate->__('Telephone');?></label>
										<div class="input-box">
											<input class="input-text required-entry" maxlength="255" title="Last Name" value="<?= $telephone ?>" name="address[telephone]" id="lastname" type="text">
										</div>
									</div>
							</li>
							
							
							<li class="layui-col-xs6 layui-col-sm6 layui-col-md6">
								<div class="input-box input-country width_270" >
									<label for="billing:country"><?= Yii::$service->page->translate->__('Country');?> </label>
									<select title="Country" data-country="<?= $country ?>" class="billing_country validate-select" id="billing_country" name="address[country]" lay-verify="required" lay-search lay-filter="province">
										
									</select>
								</div>
							</li>
							<li class="layui-col-xs6 layui-col-sm6 layui-col-md6">
								<div class="input-box input-state width_270" >
									<label for="billing:state" class="required"><?= Yii::$service->page->translate->__('State');?> </label>
									<select title="State" data-state="<?= $state ?>" class="billing_state validate-select" id="billing_state" name="address[state]" lay-verify="required" lay-search lay-filter="city">
										
									</select>
									
								</div>
							</li>
							<li class="layui-col-xs6 layui-col-sm6 layui-col-md6">
								<div class="input-box input-city width_270" >
									<label for="billing:city"><?= Yii::$service->page->translate->__('City');?> </label>
									
									<select title="City" data-city="<?= $city ?>" class="billing_city validate-select" id="billing_city" name="address[city]" lay-verify="required" lay-filter="district">
										
									</select>
								</div>
							</li>
							
							
							<li class="layui-col-xs6 layui-col-sm6 layui-col-md6">
								<div class="field name-lastname">
										<label class="required" for="lastname"><?= Yii::$service->page->translate->__('Street');?><?= Yii::$service->page->translate->__('（請用中文地址）');?></label>
										<div class="input-box">
											<input class="input-text required-entry" maxlength="20" title="Last Name" value="<?= $street1 ?>" name="address[street1]" id="lastname" type="text">
										</div>
									</div>
							</li>
							
							
							<li class="layui-col-xs6 layui-col-sm6 layui-col-md6">
								<div class="field name-lastname">
										<label  for="lastname"><?= Yii::$service->page->translate->__('Building');?><?= Yii::$service->page->translate->__('（請用中文地址）');?></label>
										<div class="input-box">
											<input class="input-text optional" maxlength="40" title="street2" value="<?= $street2 ?>" name="address[street2]" id="lastname" type="text">
										</div>
									</div>
							</li>
							
							
							
							<li class="layui-col-xs12 layui-col-sm12 layui-col-md12">
								<div class="field name-lastname">
									<div class="input-box">
										<input name="address[is_default]" value="1" title="<?= Yii::$service->page->translate->__('Save in address book') ?>" id="address:is_default" class="address_is_default checkbox" <?= $is_default_str; ?> type="checkbox">
										<label for="address:is_default" class="span_inline"><?= Yii::$service->page->translate->__('Is Default');?></label>
										
									</div>
								</div>
							</li>
							<input type="hidden" value="000000" name="address[zip]">
						</ul>
						
					</div>
					
					<a href="javascript:void(0)" onclick="submit_address()" class="submitbutton"><span><span><?= Yii::$service->page->translate->__('Save');?></span></span> </a>
					
				</form>
			</div>
		</div>

	</div>
	
	
		<?= Yii::$service->page->widget->render('customer/left_menu', $this); ?>
	
	<div class="clear"></div>
</div>
	
	
<script>
<?php $this->beginBlock('editCustomerAddress') ?>
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
		$("input[name='address[street1]'],input[name='address[street2]']").on("input",function(){
			var str1=$("input[name='address[street1]']").val();
			var str2=$("input[name='address[street2]']").val();
			
			if((str1.length + str2.length)>60){
				layer.msg("<?= Yii::$service->page->translate->__('The length of street should be less 60');?>", {icon: 1});
				$("input[name='address[street1]']").css('border-color','red');
				$("input[name='address[street2]']").css('border-color','red');
				if(str1.length > 20){
					$("input[name='address[street1]']").val(str1.slice(0,20));
				}else{
					var length=60-str1.length;
					$("input[name='address[street2]']").val(str2.slice(0,length));
				}
				return false;
			}
		});

	});	
	function submit_address(){
		i = 1;
		jQuery(".addressedit input").each(function(){
			type = jQuery(this).attr("type");
			if(type != "hidden"){
				value = jQuery(this).val();
				if(!value){
					//alert($(this).hasClass('optional'));
					if(!$(this).hasClass('optional')){
						i = 0;
					}
				}
			}
		});
		
		jQuery(".addressedit select").each(function(){
			value = jQuery(this).val();
			if(!value){
				i = 0;
			}
		});
		if(i){
			jQuery(".addressedit").submit();
		}else{
			alert("You Must Fill All Field");
		}
	}
	
<?php $this->endBlock(); ?> 
<?php $this->registerJs($this->blocks['editCustomerAddress'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>

</script>