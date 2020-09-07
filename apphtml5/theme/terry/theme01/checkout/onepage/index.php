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
<style>
.active{
	color:red;
}
.group-select-margin{
	margin: 0;
}
</style>
<div class="main container one-column">
	<div class="col-main">
		<?= Yii::$service->page->widget->render('base/flashmessage'); ?>
		<form action="<?= Yii::$service->url->getUrl('checkout/onepage'); ?>" method="post" id="onestepcheckout-form">
			<?= CRequest::getCsrfInputHtml(); ?>
			<div class="group-select group-select-margin">
				<p class="onestepcheckout-description"><?= Yii::$service->page->translate->__('Welcome to the checkout,Fill in the fields below to complete your purchase');?> !</p>
				<?php if (\Yii::$app->user->isGuest): ?>
                    <p class="onestepcheckout-login-link">
                        <a external  href="<?= Yii::$service->url->getUrl('customer/account/login'); ?>" id="onestepcheckout-login-link"><?= Yii::$service->page->translate->__('Already registered? Click here to login');?>.</a>
                    </p>
                <?php endif; ?>
				<div class="onestepcheckout-threecolumns checkoutcontainer onestepcheckout-skin-generic onestepcheckout-enterprise">
					<div class="onestepcheckout-column-left">
						<?php # address 部门
							//echo $address_view_file;
							$addressView = [
								'view'	=> $address_view_file,
							];
							//var_dump($address_list);
							$addressParam = [
								'cart_address_id' 	=> $cart_address_id,
								'address_list'	  	=> $address_list,
								'customer_info'	  	=> $customer_info,
								//'country_select'  	=> $country_select,
								//'state_html'  	  	=> $state_html,
								'cart_address'		=> $cart_address,
								//'payments' => $payments,
								//'current_payment_mothod' => $current_payment_mothod,
							];
						?>
						<?= Yii::$service->page->widget->render($addressView,$addressParam); ?>
					
					</div>
					<div id="billing_address" class="create-popup list-block">	
						<div class="item-content">
						  <div class="item-media"><i class="icon icon-form-name"></i></div>
						  <div class="item-inner">
							<div class="item-title label"><?= Yii::$service->page->translate->__('Shipping Date');?></div>
							<div class="item-input">
									<input name="billing[shipping_date]" id="my-input" value="<?= date('Y-m-d',strtotime('+3 day')) ?>" type="text" data-toggle='date' /><span id="date_warm" class="active"></span>
							</div>
						  </div>
						</div>
						
					</div>
					<div class="onestepcheckout-column-middle">
						<div class="shipping_method_html">
                            <?= Yii::$service->page->widget->render('order/shipping', ['shippings' => $shippings]); ?>
						</div>
                        
                        <?php # payment部分
							$paymentParam = [
								'payments' => $payments,
								'current_payment_mothod' => $current_payment_mothod,
							];
						?>
						<?= Yii::$service->page->widget->render('order/payment', $paymentParam); ?>
					
							
						<div class="onestepcheckout-coupons">
							<div class="display_none" id="coupon-notice"></div>
							<div class="op_block_title"><?= Yii::$service->page->translate->__('Coupon codes (optional)');?></div>
							<label for="id_couponcode"><?= Yii::$service->page->translate->__('Enter your coupon code if you have one.');?></label>
							
							<input type="hidden" class="couponType"  value="<?= $cart_info['coupon_code'] ? 1 : 2 ; ?>"  />
							<input  class="input-text color-777" id="id_couponcode" name="coupon_code" value="<?= $cart_info['coupon_code']; ?>">
							<br>
							<button  type="button" class="submitbutton add_coupon_submit" id="onestepcheckout-coupon-add"><?= Yii::$service->page->translate->__($cart_info['coupon_code'] ? 'Cancel Coupon' : 'Add Coupon') ; ?></button>
							<div class="clear"></div>
							<div class="coupon_add_log"></div>
						</div>
						
                        <div class="onestepcheckout-coupons">
							<div class="op_block_title"><?= Yii::$service->page->translate->__('Order Remark (optional)');?></div>
							<label for="id_couponcode"><?= Yii::$service->page->translate->__('You can fill in the order remark information below');?></label>
							<textarea class="order_remark order-remark-text" name="order_remark" ></textarea>
						</div>
						
					</div>

					<div class="onestepcheckout-column-right">
						<div class="review_order_view">
                            <?php # review order部分
								$reviewOrderParam = [
									'cart_info' => $cart_info,
									'currency_info' => $currency_info,
								];
							?>
							<?= Yii::$service->page->widget->render('order/view', $reviewOrderParam); ?>
							
						</div>
						<?php if(!empty($cart_info['grand_total']+0)){?>
						<div class="onestepcheckout-place-order">
							<a class="large orange onestepcheckout-button" href="javascript:void(0)" id="onestepcheckout-place-order"><?= Yii::$service->page->translate->__('Place order now');?></a>
							<div class="onestepcheckout-place-order-loading"><img alt="loader" src="<?= Yii::$service->image->getImgUrl('images/opc-ajax-loader.gif'); ?>">&nbsp;&nbsp;<?= Yii::$service->page->translate->__('Please wait, processing your order...');?></div>
						</div>
						<?php } ?>
					</div>
					<div class="clear">&nbsp;</div>
				</div>
			</div>
		</form>
	</div>
</div>

	
	
<script>
<?php $this->beginBlock('placeOrder') ?>
	
	csrfName = $(".thiscsrf").attr("name");
	csrfVal = $(".thiscsrf").val();
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	// ajax
	function ajaxreflush(){
		shipping_method = $("input[name=shipping_method]:checked").val();
		//alert(shipping_method);
		country = $("#province").val();
		address_id = $("input[name='address_id']:checked").val();
		state   = $("#city").val();
		city   = $("#district").val();
		//alert(state);
		if(country || address_id){
			$(".onestepcheckout-summary").html('<div class="checkout-summary"><img src="<?= Yii::$service->image->getImgUrl('images/ajax-loader.gif'); ?>"  /></div>');
			$(".onestepcheckout-shipping-method-block").html('<div class="checkout-summary"><img src="<?= Yii::$service->image->getImgUrl('images/ajax-loader.gif'); ?>"  /></div>');
			ajaxurl = "<?= Yii::$service->url->getUrl('checkout/onepage/ajaxupdateorder');  ?>";
			$.ajax({
				async:false,
				timeout: 8000,
				dataType: 'json', 
				type:'get',
				data: {
						'country':country,
						'shipping_method':shipping_method,
						'address_id':address_id,
						'state':state,
						'city':city
						},
				url:ajaxurl,
				success:function(data, textStatus){ 
					status = data.status;
					if(status == 'success'){
						$(".review_order_view").html(data.reviewOrderHtml)
						$(".shipping_method_html").html(data.shippingHtml);
					
					}
						
				},
				error:function (XMLHttpRequest, textStatus, errorThrown){
						
				}
			});
		}
	}
	$(document).ready(function(){
		$("#province").change(function(){
			console.log('test');
			$("#city").val(1);
			$("#district").val(1);
			$("#city-picker").cityPicker("change");
		});
		$("#city-picker").cityPicker({
            toolbarTemplate: '<header class="bar bar-nav">\
            <button class="button button-link pull-right close-picker"><?= Yii::$service->page->translate->__("Comfirm") ?></button>\
            <h1 class="title"><?= Yii::$service->page->translate->__("Select the Address") ?></h1>\
            </header>',
            date: '#date',//省输入框,一般都是隐藏的，获取身份ID
            city: '#city', //城市输入框，一般都是隐藏的，获取城市ID
			district: '#district' //城市输入框，一般都是隐藏的，获取城市ID
        });	
        
	})
	$(document).ready(function(){
		//得到当前日期
	  function GetDateStr(AddDayCount) {
		var dd = new Date();
		dd.setDate(dd.getDate()+AddDayCount);//获取AddDayCount天后的日期
		var y = dd.getFullYear();
		var m = dd.getMonth()+1;//获取当前月份的日期
		var d = dd.getDate();
		//console.log(Date.parse(new Date(dd)));
		//return y+"-"+m+"-"+d;
		return {"date":Date.parse(new Date(dd)),"value":y+"-"+m+"-"+d};
	}
	  //得到当前日期
	  var date=new Date();
	  
	    if(date.getDay()==0){
        	date=GetDateStr(3);
        }else if(date.getDay()==6){
        	date=GetDateStr(4);
        }else if(date.getDay()==5){
			date=GetDateStr(4);
        }else{
			date=GetDateStr(2);
		}
		console.log(date);
		$("#my-input").calendar({
		    value: [date.value]
		    ,minDate:date.value
		    ,onChange:function(p, values, displayValues){
		    	var date=new Date(displayValues);
		    	
		    	datedone(displayValues, {'year':date.getFullYear(),'month':date.getMonth()+1,'date':date.getDate()});
		    }
		});
		currentUrl = "<?= Yii::$service->url->getUrl('checkout/onepage') ?>"
		//优惠券
		$(".add_coupon_submit").click(function(){
			coupon_code = $("#id_couponcode").val();
			coupon_type = $(".couponType").val();
			coupon_url = "";
			$succ_coupon_type = 0;
			if(coupon_type == 2){
				coupon_url = "<?=  Yii::$service->url->getUrl('checkout/cart/addcoupon'); ?>";
				$succ_coupon_type = 1;
			}else if(coupon_type == 1){
				coupon_url = "<?=  Yii::$service->url->getUrl('checkout/cart/cancelcoupon'); ?>";
				$succ_coupon_type = 2;
			}
			//alert(coupon_type);
			if(!coupon_code){
				//alert("coupon can not empty!");
			}
			$data = {"coupon_code":coupon_code};
			$data[csrfName] = csrfVal;
			$.ajax({
				async:true,
				timeout: 6000,
				dataType: 'json', 
				type:'post',
				data: $data,
				url:coupon_url,
				success:function(data, textStatus){ 
					if(data.status == 'success'){
						$(".couponType").val($succ_coupon_type);
						hml = $('.add_coupon_submit').html();
						if(hml == '<?= Yii::$service->page->translate->__('Add Coupon');?>'){
							$('.add_coupon_submit').html('<?= Yii::$service->page->translate->__('Cancel Coupon');?>');
						}else{
							$('.add_coupon_submit').html('<?= Yii::$service->page->translate->__('Add Coupon');?>');
						}
						$(".coupon_add_log").html("");
						ajaxreflush();
					}else if(data.content == 'nologin'){
						$(".coupon_add_log").html("<?= Yii::$service->page->translate->__('you must login your account before you use coupon');?>");
					}else{
						$(".coupon_add_log").html(data.content);
					}
				},
				error:function (XMLHttpRequest, textStatus, errorThrown){}
			});
		});
		 
	
		
		// 对于非登录用户，可以填写密码，进行注册账户，这里进行信息的检查。
		$("#id_create_account").click(function(){
			if($(this).is(':checked')){
				email = $("input[name='billing[email]']").val();
				if(!email){
					$(this).prop('checked', false);
					$(".label_create_account").html(" <?= Yii::$service->page->translate->__('email address is empty, you must Fill in email');?>");
				}else{
					thischeckbox = this;
					if(!validateEmail(email)){
						$(this).prop('checked', false);
						$(".label_create_account").html(" <?= Yii::$service->page->translate->__('email address format is incorrect');?>");
						
					}else{
						// ajax  get if  email is register
						$.ajax({
							async:true,
							timeout: 6000,
							dataType: 'json', 
							type:'get',
							data: {"email":email},
							url:"<?= Yii::$service->url->getUrl('customer/ajax/isregister'); ?>",
							success:function(data, textStatus){ 
								if(data.registered == 2){
									$(".label_create_account").html("");
									$("#onestepcheckout-li-password").show();
									$("#onestepcheckout-li-password input").addClass("required-entry");
					
								}else{
									$(thischeckbox).prop('checked', false);
									$(".label_create_account").html(" <?= Yii::$service->page->translate->__('This email is registered , you must fill in another email');?>");
								}
							},
							error:function (XMLHttpRequest, textStatus, errorThrown){}
						});
					}
				}
			}else{
				$(".label_create_account").html("");
				$("#onestepcheckout-li-password").hide();
				$("#onestepcheckout-li-password input").removeClass("required-entry");
			}
		});
		
		//###########################
		//下单(这个部分未完成。)
		$("#onestepcheckout-place-order").click(function(){
			
			$(".validation-advice").remove();
			i = 0;
			j = 0;
			address_list = $('.address_id_select').not(function () { return !this.checked }).val();
			
			// shipping
			shipment_method = $(".onestepcheckout-shipping-method-block input[name='shipping_method']:checked").val();
			//alert(shipment_method);
			if(!shipment_method){
				$(".shipment-methods").after('<div   class="validation-advice"><?= Yii::$service->page->translate->__('This is a required field.');?></div>');
				j = 1;
			}
			//alert(j);
			//payment  
			payment_method = $("#checkout-payment-method-load input[name='payment_method']:checked").val();
			
			payment_comfirm = $("#checkout-payment-method-load input[name='payment_method']:checked").attr('data-method');
			//alert(shipment_method);
			if(!payment_method){
				$(".checkout-payment-method-load").after('<div   class="validation-advice"><?= Yii::$service->page->translate->__('This is a required field.');?></div>');
				j = 1;
			}
			var value=$('#my-input').val();
		  	var date=new Date(value);
		  	console.log(date);
			 if(!datedone(value, {year:date.getFullYear(),month:date.getMonth()+1,date:date.getDate()})){
				
			 	return false;
			 }
			if(address_list){
				if(!j){
					$.confirm(payment_comfirm,  function(){
					  $(".onestepcheckout-place-order").addClass('visit');
					  $("#onestepcheckout-form").submit();
					  return false;
					}, function(){
					  
					  $.alert("<?= Yii::$service->page->translate->__('Cancel');?>");
					  return false;
					});
					
				}
			}else{
				
				//alert(j);
				$("#onestepcheckout-form .required-entry").each(function(){
					value = $(this).val();
					if(!value){
						//alert(this);
						//alert($(this).attr('name'));
						i++;
						$(this).after('<div   class="validation-advice"><?= Yii::$service->page->translate->__('This is a required field.');?></div>');
					}
				});
				//email  format validate
				user_email = $("#billing_address .validate-email").val();
				if(user_email && !validateEmail(user_email)){
					$("#billing_address .validate-email").after('<div   class="validation-advice"><?= Yii::$service->page->translate->__('email address format is incorrect');?></div>');
					i++;
				}
				// password 是否长度大于6，并且两个密码一致
				if($("#id_create_account").is(':checked')){
					new_user_pass = $(".customer_password").val();
					new_user_pass_cm = $(".customer_confirm_password").val();
					//alert(new_user_pass);
					//alert(new_user_pass.length);
					//alert(new_user_pass_cm);
					<?php 
						$passwdMinLength = Yii::$service->customer->getRegisterPassMinLength();
						$passwdMaxLength = Yii::$service->customer->getRegisterPassMaxLength();
					?>
					passwdMinLength = "<?= $passwdMinLength ?>";
					passwdMaxLength = "<?= $passwdMaxLength ?>";
					if(new_user_pass.length < passwdMinLength){
						$(".customer_password").after('<div   class="validation-advice"><?= Yii::$service->page->translate->__('Password length must be greater than or equal to {passwdMinLength}',['passwdMinLength' => $passwdMinLength]);?></div>');
						i++;
					}else if(new_user_pass.length > passwdMaxLength){
						$(".customer_password").after('<div   class="validation-advice"><?= Yii::$service->page->translate->__('Password length must be less than or equal to {passwdMaxLength}',['passwdMaxLength' => $passwdMaxLength]);?></div>');
						i++;
					}else if(new_user_pass != new_user_pass_cm){
						$(".customer_confirm_password").after('<div   class="validation-advice"><?= Yii::$service->page->translate->__('The passwords are inconsistent');?></div>');
						i++; 
					}  
				}
				//alert(222);
				if(!i && !j){
					//alert(333);
					$(".onestepcheckout-place-order").addClass('visit');
					$("#onestepcheckout-form").submit();
				}
			}
			
		});
		//登录用户切换地址列表
		$(".address_list").change(function(){
			val = $(this).val();
			if(!val){
				$(".billing_address_list_new").show();
				 
				$(".save_in_address_book").attr("checked","checked");
				ajaxreflush();
				
			}else{
				$(".billing_address_list_new").hide();
				$(".save_in_address_book").attr("checked",false);
				addressid = $(this).val();
				
				if(addressid){
					ajaxreflush();
				}
			}
		});
		// 国家选择后，state需要清空，重新选择或者填写
		$(".billing_country").change(function(){
			country = $(this).val();
			//state   = $(".address_state").val();
			//shipping_method = $("input[name=shipping_method]:checked").val();
			//alert(shipping_method);
			
			//$(".onestepcheckout-shipping-method-block").html('<div style="text-align:center;min-height:40px;"><img src="http://www.intosmile.com/skin/default/images/ajax-loader.gif"  /></div>');
			//$(".onestepcheckout-summary").html('<div style="text-align:center;min-height:40px;"><img src="http://www.intosmile.com/skin/default/images/ajax-loader.gif"  /></div>');
			ajaxurl = "<?= Yii::$service->url->getUrl('checkout/onepage/changecountry'); ?>";
			
			$.ajax({
				async:true,
				timeout: 8000,
				dataType: 'json', 
				type:'get',
				data: {
						'country':country,
						//'shipping_method':shipping_method,
						//'state':state
						},
				url:ajaxurl,
				success:function(data, textStatus){ 
					$(".state_html").html(data.state);
					
				},
				error:function (XMLHttpRequest, textStatus, errorThrown){
						
				}
			});
			ajaxreflush();	
		});
		// state select 改变后的事件
		$("#city-picker").change(function(){
			ajaxreflush();
		});
		$("#province").change(function(){
			console.log('province');
			ajaxreflush();
		});
		$("#city").change(function(){
			console.log('city');
			ajaxreflush();
		});
		$("#district").change(function(){
			console.log('district');
			ajaxreflush();
		});
		
		// state input 改变后的事件
		$(".input-address").off("blur").on("blur","input.address_state",function(){
			ajaxreflush();
		});
		//改变shipping methos
		$(".onestepcheckout-column-middle").off("click").on("click","input[name=shipping_method]",function(){
			//ajaxreflush();
			return false;
		});
	});	
	//ajaxreflush();
<?php $this->endBlock(); ?> 
<?php $this->registerJs($this->blocks['placeOrder'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>

</script>

	  
    

	