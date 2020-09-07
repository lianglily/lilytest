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
ul#billing_address_list li label{
	display: inline-block;
    width: 22%;
    text-align: left;
}
ul#billing_address_list li input, ul#billing_address_list li select{
	display:inline;
	width:60%;
}
.required{color:red}
</style>
<div id="billing_address">		
	<p class="onestepcheckout-numbers onestepcheckout-numbers-1"><?= Yii::$service->page->translate->__('Shipping Address');?></p>
  
	<div class="list-block open-popup" data-popup=".popup-address">
		<ul >
		<?php  	if(is_array($address_list) && !empty($address_list)):    ?>
		<?php  	    foreach($address_list as $address_id => $info):  ?>
		<?php  	        if($cart_address_id == $address_id ): 
							$weekday=$info['address_info']['weekday'];
							$str = 'selected="true;"';
		?>
		  <li class="item-content item-link ">
			<div class="item-media"><i class="icon icon-f7"></i></div>
			<div class="item-inner">
			  <div class="item-title font_smaller" id="address_text" >
			  <?= Yii::$service->page->translate->__('Consignee:');?><?= $info['address_info']['first_name'] ?> <?= $info['address_info']['last_name'] ?> <br>
			  <?= Yii::$service->page->translate->__('Address:');?><?= $info['address_info']['country'] ?>  <?= $info['address_info']['state'] ?> <?= $info['address_info']['city'] ?> <br><?= $info['address_info']['street1'] ?> <?= $info['address_info']['street2'] ?><br>
			  <?= Yii::$service->page->translate->__('Tel:');?><?= $info['address_info']['telephone']?><br>
			  <?= Yii::$service->page->translate->__('Email:');?><?= $info['address_info']['email']?><br></div>
			  <input  value="<?= $address_id ?>" data-country="<?= $info['address_info']['country_id']?>" data-state="<?= $info['address_info']['state_id']?>" data-city="<?= $info['address_info']['city_id']?>" data-weekday="<?= $info['address_info']['weekday'] ?>" type="hidden"/>
			</div>
		  </li>
		<?php endif;?>
		<?php endforeach;  ?>
		<?php endif;  ?>
		</ul>
	  </div>
	  
	  
</div>
<div class="popup modal-in popup-address popup-address_position" >
	<div class="popup-address-content">
		  <div class="content-block">
			
			<p><a href="#" class="close-popup icon icon-down pull-right " id="close-popup" ></a></p>
			
		  </div>
		  <div class="list-block" style="margin-top:30px">
				<?php  	if(is_array($address_list) && !empty($address_list)):    ?>
				<?php  	    foreach($address_list as $address_id => $info):  
				?>
				<?php  	        if($cart_address_id == $address_id ): 
									$weekday=$info['address_info']['weekday'];
                                    $str = 'checked';
                                else:  
                                    $str = ''; 
                                endif;
				?>
				<ul>
				  <li class="item-content">
					<div class="item-media">
					<input id="<?= $address_id ?>" data-weekday="<?= $info['address_info']['weekday'] ?>" <?= $str  ?> class="address_id_select" name="address_id" type="radio" value="<?= $address_id ?>" data-firstname="<?= $info['address_info']['first_name'] ?>" data-lastname="<?= $info['address_info']['last_name'] ?>" 
				data-telephone="<?= $info['address_info']['telephone']?>" data-email="<?= $info['address_info']['email']?>" data-street1="<?= $info['address_info']['street1'] ?>" data-street2="<?= $info['address_info']['street2'] ?>" data-country="<?= $info['address_info']['country_id']?>" data-state="<?= $info['address_info']['state_id']?>" data-city="<?= $info['address_info']['city_id']?>" data-countryname="<?= $info['address_info']['country']?>" data-statename="<?= $info['address_info']['state']?>" data-cityname="<?= $info['address_info']['city']?>" data-weekday="<?= $info['address_info']['weekday'] ?>"/>
					</div>
					<div class="item-inner">
					  <div class="item-title">
					  <label for="<?= $address_id ?>" class="display-inline-table">
					<?= Yii::$service->page->translate->__('Consignee:');?><?= $info['address_info']['first_name'] ?> <?= $info['address_info']['last_name'] ?> <br>
					<?= Yii::$service->page->translate->__('Address:');?><?= $info['address_info']['country'] ?> <?= $info['address_info']['state'] ?> <?= $info['address_info']['city'] ?> <br><?= $info['address_info']['street1'] ?> <?= $info['address_info']['street2'] ?><br>
					<?= Yii::$service->page->translate->__('Tel:');?><?= $info['address_info']['telephone']?><br>
					<?= Yii::$service->page->translate->__('Email:');?><?= $info['address_info']['email']?><br>
						</label>
					   </div>
					</div>
					
					
				  </li>		
                </ul>
				
				<?php       endforeach;  ?>
				<?php  endif;  ?>
				<ul>
				  <li class="item-content">
					<div class="item-media">
					<input class="address_id_select" name="address_id" type="radio" value="" id="newaddress" />
					</div>
					<div class="item-inner">
					  <div class="item-title">
						<label for="newaddress" class="display-inline-table"><?= Yii::$service->page->translate->__('New Address');?> </label> 
					   </div>
					</div>
					
					
				  </li>		
                </ul>
				<input type="hidden" value="<?= $weekday ?>" name="weekday" id="weekday"/>
								  
			</div>
			<div class="list-block">
				<ul id="billing_address_list" class="billing_address_list_new billing_address_list_position" >
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
							<input  value="<?= $cart_address['telephone'] ?>" id="billing:telephone" class="required-entry input-text" title="Telephone" name="billing[telephone]" type="text">
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
							<select style="width:50px;display:inline" id="province" name="billing[country]">
								<?php $areas=Yii::$service->shipping->area;
										foreach($areas as $val){
								?>
								<option value=<?= $val['id'] ?> <?php if($cart_address['country']==1){?>checked<?php }?> ><?= $val['name'] ?></option>
								<?php }?>
								
							</select>	
							<input type="text" placeholder="" id='city-picker' style="width:45%;display:inline"/>
							
							<input type="hidden" id="city" name="billing[state]" value="<?= $cart_address['state'] ?>">
							<input type="hidden" id="district" name="billing[city]" value="<?= $cart_address['city'] ?>">
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
							<input  value="<?= $cart_address['street1'] ?>" class="required-entry input-text onestepcheckout-address-line width-29" id="billing:street1" name="billing[street1]" title="Street Address 1" type="text">
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
							<input  value="<?= $cart_address['street2'] ?>" class="input-text onestepcheckout-address-line width-29" id="billing:street2" name="billing[street2]" title="Street Address 2" type="text">
							</div>
						  </div>
						</div>
					  </li>
					
					<input type="hidden" value="000000" name="billing[zip]">
					
								
				</ul>
			</div>
		</div>
		<a class="large orange onestepcheckout-button close-popup" href="javascript:void(0)" id="close-popup-check">确认</a>
	  </div>
<script>
<?php $this->beginBlock('address') ?>
 $(document).ready(function(){
 	if( $('.address_id_select').not(function () { return !this.checked }).data("weekday")){
		
 		var aa= <?= $weekday ?>;
 		var weekdays=checkweekday(aa)['weekdays'];
 		$('#weekday').val(aa);
 		
	}
	
	function checkweekday(val){
		var high= val >> 8;
		var low= val & 0xff;
		var weekdays=[];
		var weeks=[];
		for(var i=7,j=1;i>0;--i,++j){
			
			if((low & 1)){
				weekdays.push(j);
			}
			low=low>>1;
			if((high & 1)){
				weeks.push(j);
			}
			high=high>>1;
		}
		return {"weekdays":weekdays,"weeks":weeks};
	}
	 
	 
    $('.address_id_select').change(function(){
    	var getValue = $('.address_id_select').not(function () { return !this.checked }).val();
		
    	if(getValue){
	 		var aa= getValue;
	 		var weekdays=checkweekday(aa)['weekdays'];
	 		$('#weekday').val(aa);
	 		ajaxreflush();
    	}else{
    		$('#weekday').val('');
    	    $('#billing_address_list').css('display','block');	
    	}
 	})
	$('#close-popup,#close-popup-check').click(function(){
		var getValue = $('.address_id_select').not(function () { return !this.checked }).val();
		if(getValue){
			var firstname=$('.address_id_select').not(function () { return !this.checked }).data("firstname");
			var lastname=$('.address_id_select').not(function () { return !this.checked }).data("lastname");
			var country=$('.address_id_select').not(function () { return !this.checked }).data("countryname");
			var city=$('.address_id_select').not(function () { return !this.checked }).data("cityname");
			var state=$('.address_id_select').not(function () { return !this.checked }).data("statename");
			var street1=$('.address_id_select').not(function () { return !this.checked }).data("street1");
			var street2=$('.address_id_select').not(function () { return !this.checked }).data("street2");
			var telephone=$('.address_id_select').not(function () { return !this.checked }).data("telephone");
			var email=$('.address_id_select').not(function () { return !this.checked }).data("email");
			var text="<?= Yii::$service->page->translate->__('Consignee:');?>"+firstname+" "+lastname+"<br><?= Yii::$service->page->translate->__('Address:');?>"+country+" "+state+" "+city+"<br>"+street1+" "+street2+"<br><?= Yii::$service->page->translate->__('Tel:');?>"+telephone+"<br><?= Yii::$service->page->translate->__('Email:');?>"+email+"<br>";
			$('#address_text').html(text);
		}else{
			var city=document.getElementById('city-picker').value;
			if(!city){
				$.alert('请选择送货地址');
				return false;
			}
			var firstname=document.getElementById('billing:firstname').value;
			var lastname=document.getElementById('billing:lastname').value;
			
			var street1=document.getElementById('billing:street1').value;
			var street2=document.getElementById('billing:street2').value;
			var telephone=document.getElementById('billing:telephone').value;
			var email=document.getElementById('billing:email').value;
			var text="<?= Yii::$service->page->translate->__('Consignee:');?>"+firstname+" "+lastname+"<br><?= Yii::$service->page->translate->__('Address:');?>"+city+" "+street1+" "+street2+"<br><?= Yii::$service->page->translate->__('Tel:');?>"+telephone+"<br><?= Yii::$service->page->translate->__('Email:');?>"+email+"<br>";
			$('#address_text').html(text);
		}
	})
	
})
<?php $this->endBlock(); ?> 
</script>
<?php $this->registerJs($this->blocks['address'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>
