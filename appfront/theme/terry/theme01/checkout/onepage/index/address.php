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

<div id="billing_address">		
	<ul>
		<li>
			<p class="onestepcheckout-numbers onestepcheckout-numbers-1"><?= Yii::$service->page->translate->__('Shipping Address');?></p>
		</li>
		<li>
			<div>
				<ul id="billing_address_list" class="billing_address_list_new layui-form" >	
				<input type="hidden" value="<?= $weekday?$weekday:48927 ?>" name="weekday" id="weekday" />
				<input type="hidden" value="false" name="isday" id="isday"/>
					<li class="clearfix">
						<div class="input-box input-firstname">
							<label class="required" for="billing:firstname"><?= Yii::$service->page->translate->__('First Name');?></label>
							<input value="<?= $cart_address['first_name'] ?>" id="billing:firstname" name="billing[first_name]" class="required-entry input-text" type="text">
						</div>
						<div class="input-box input-lastname">
							<label class="required" for="billing:lastname"><?= Yii::$service->page->translate->__('Last Name');?> </label>
							<input value="<?= $cart_address['last_name'] ?>" id="billing:lastname" name="billing[last_name]" class="required-entry input-text" type="text">
						</div>
						<div class="clear"></div>
					</li>
					<li class="clearfix">
						<div  class="  input-box width_100">
							<label class="required" for="billing:email"><?= Yii::$service->page->translate->__('Email Address');?> </label>
							<input value="<?= $cart_address['email'] ?>" class="validate-email required-entry input-text width_83" title="Email Address" id="billing:email" name="billing[email]" type="text">
							<div class="customer_email_validation">
							
							</div>
						</div>
					</li>
					<li class="clearfix">
						<div  class="input-box  width_100">
							<label class="required" for="billing:telephone"><?= Yii::$service->page->translate->__('Telephone');?> </label>
							<input  value="<?= $cart_address['telephone'] ?>" id="billing:telephone" class="required-entry input-text width_83" title="Telephone" name="billing[telephone]" type="text">
						</div>
					</li>
					<li class="clearfix">
						<div class="input-box input-country">
							<label class="required" for="billing:country"><?= Yii::$service->page->translate->__('Country');?></label>
							<select title="Country" class="billing_country validate-select" id="billing_country" name="billing[country]" lay-verify="required" lay-search lay-filter="province">
								
							</select>
						</div>
					</li>
					<li class="clearfix">
						<div class="input-box input-state">
							<label class="required" for="billing:state" class="required"><?= Yii::$service->page->translate->__('State');?> </label>
							<select title="State" class="billing_state validate-select" id="billing_state" name="billing[state]" lay-verify="required" lay-search lay-filter="city">
								
							</select>
							
						</div>
					</li>
					<li class="clearfix">
						<div class="input-box input-city">
							<label class="required" for="billing:city"><?= Yii::$service->page->translate->__('City');?> </label>
							
							<select title="City" class="billing_city validate-select" id="billing_city" name="billing[city]" lay-verify="required" lay-filter="district">
								
							</select>
						</div>
					</li>
					<li class="clearfix">
						<div class="input-box input-address">
							<label class="required" for="billing:street1"><?= Yii::$service->page->translate->__('Street');?><?= Yii::$service->page->translate->__('（請用中文地址）');?></label>
							<input maxlength="10" value="" class="required-entry input-text onestepcheckout-address-line" id="billing:street1" name="billing[street1]" title="Street Address 1" type="text">
							<br>
							<input maxlength="30" value="" class="input-text onestepcheckout-address-line" id="billing:street2" name="billing[street2]" title="Street Address 2" type="text">
						</div>
					</li>
					<input type="hidden" value="000000" name="billing[zip]"/>
					<li class="clearfix">
						<div class="layui-form-item">
						    <div class="layui-block">
						      <label  class="color_red"><?= Yii::$service->page->translate->__('Delivery Time:');?> <span id="shippingDateDesc"></span></label>
						      <div class="input-text onestepcheckout-address-line" class="width_83 margin_6" >
						        <button  type="button" class="layui-btn" id="viewdelivery" ><?= Yii::$service->page->translate->__('Delivery Period');?></button>
						      </div>
						    </div>
						  </div>
						
					</li>
					<li class="clearfix">
			
						<div class="layui-form">
						  <div class="layui-form-item">
						    <div class="layui-block">
						      <label class="required" ><?= Yii::$service->page->translate->__('Shipping Date');?> </label>
						      <div class="input-text onestepcheckout-shippingdate-line layui-input-inline" class="width_83 margin_6">
						        <input type="text" class="layui-input" id="test-limit1" placeholder="yyyy-MM-dd" name="billing[shipping_date]" lay-verify="required">
						        <i class="layui-icon date-input-icon top_1" ></i>
						      </div>
						    </div>
						  </div>
						</div>
						
					</li>
					<?php if(!Yii::$app->user->isGuest):  ?>
					<!--
					<li class="control">
						<input class="save_in_address_book checkbox" id="billing:save_in_address_book" title="Save in address book" value="1" name="billing[save_in_address_book]" checked="checked" type="checkbox"><label for="billing:save_in_address_book">Save in address book</label>
					</li>  
					-->
					<?php else: ?>
					<li class="clearfix">
						<div class="input-box">
							<input value="1" name="create_account" id="id_create_account" type="checkbox">
							<label class="span_inline" for="id_create_account"><?= Yii::$service->page->translate->__('Create an account for later use');?></label>
						</div>
						<div class="label_create_account">
						
						</div>
					</li>
					<li class="display_none" id="onestepcheckout-li-password">
						<div class="input-box input-password">
							<label for="billing:customer_password"><?= Yii::$service->page->translate->__('Password');?></label><br>
							<input name="billing[customer_password]" id="billing:customer_password" title="Password" value="" class="validate-password input-text customer_password" type="password">
						</div>
						<div class="input-box input-password">
							<label for="billing:confirm_password"><?= Yii::$service->page->translate->__('Confirm Password');?></label><br>
							<input name="billing[confirm_password]" title="Confirm Password" id="billing:confirm_password" value="" class="validate-password input-text customer_confirm_password" type="password">
						</div>
					</li>
					<?php endif;  ?>
				</ul>							
			</div>
		</li>
	</ul>
</div>
<script>
<?php $this->beginBlock('address') ?>
 window.onload = function(){
 	$('#weekday').bind('propertychange',function(){alert('值已改变');})
	layui.use('laydate', function(){
	  var laydate = layui.laydate;
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
	  //限定可选日期
	  var ins22 = laydate.render({
	    elem: '#test-limit1'
	    ,eventElem: '.date-input-icon'
        ,trigger: 'click'
	    ,min: date.date
	    ,value: date.value
		,btns: ['clear', 'confirm']
	    ,lang:'<?= Yii::$service->page->translate->__("Lang");?>'
	    ,ready: function(){
	     
	    }
	    ,done: function(value, date){
	    	datedone(value, date);
	      
	    }
	  });
	  $('#viewdelivery').click(function(){
	      var that = this; 
	      //多窗口模式，层叠置顶
	      layer.open({
	      	title:"<?= Yii::$service->page->translate->__('Delivery Period');?>"
	        ,type: 2 //此处以iframe举例
	        ,area: ['80vw', '80vh']
	        ,shade: 0
	        ,maxmin: true
	        ,content: '/viewdelivery'
	        ,zIndex: layer.zIndex //重点1
	        ,success: function(layero){
	          
	        }
	      });
	    })
	 
	
	});
	
}
<?php $this->endBlock(); ?> 
</script>

<?php $this->registerJs($this->blocks['address'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>