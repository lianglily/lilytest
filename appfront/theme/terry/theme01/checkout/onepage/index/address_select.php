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
<?php  //$country_select = $parentThis['country_select'];   ?>
<?php  //$state_html = $parentThis['state_html'];   ?>
<?php  $cart_address = $parentThis['cart_address'];   ?>
<style>
.new-address{
	display: inline-block;
    
    background-color: white;
    color: #03A9F4;
    white-space: nowrap;
    text-align: center;
    font-size: 14px;
    border: none;
    border-bottom:1px solid;
    cursor: pointer;
}
.new-address:hover{
	display: inline-block;
    background-color: white;
    color: #03A9F4;
    white-space: nowrap;
    text-align: center;
    font-size: 14px;
    border: none;
    border-bottom:1px solid;
    cursor: pointer;
}
.layui-form-radio {
    line-height: 28px;
    margin: 6px 10px 0 0;
    padding-right: 10px;
    cursor: pointer;
    font-size: 0;
    display: flex;
}
.layui-form-radio>i {
    margin-right: 8px;
    font-size: small;
    color: #5a6794;
}
</style>
<div id="billing_address">		
	<ul class="layui-form">
		<li>
			<p class="onestepcheckout-numbers onestepcheckout-numbers-1"><?= Yii::$service->page->translate->__('Shipping Address');?>
			
			(<a class="new-address"><?= Yii::$service->page->translate->__('New Address');?> </a>)
			</p>
			
			<input type="hidden" value="false" name="isday" id="isday"/>
		</li>
		<li>
			<div >
				<div class="layui-input-block layui-input-block_margin" >
				<?php  	if(is_array($address_list) && !empty($address_list)):    ?>
				<?php  	    foreach($address_list as $address_id => $info): ?>
				<?php  	        if($cart_address_id == $address_id ){ 
									$weekday=$info['address_info']['weekday'];
				?>
			      <input id="<?= $address_id ?>" data-country="<?= $info['address_info']['country_id']?>" data-state="<?= $info['address_info']['state_id']?>" data-city="<?= $info['address_info']['city_id']?>" data-weekday="<?= $info['address_info']['weekday'] ?>" type="radio" name="address_id" class="address_list" lay-filter="address_id_select" value="<?= $address_id ?>" checked title="<label class='address_list_select'><?= Yii::$service->page->translate->__('Consignee:');?><?= $info['address_info']['first_name'] ?>  <?= $info['address_info']['last_name'] ?><br><?= Yii::$service->page->translate->__('Address:');?><?= $info['address_info']['country']?><?= $info['address_info']['state'] ?><?= $info['address_info']['city'] ?><br><?= $info['address_info']['street1'] ?><?= $info['address_info']['street2'] ?><br><?= Yii::$service->page->translate->__('Tel:');?><?= $info['address_info']['telephone'] ?><br><?= Yii::$service->page->translate->__('Email:');?><?= $info['address_info']['email'] ?><br></label>">
			      <div></div>
			    <?php }else{ ?>
			      <input  data-country="<?= $info['address_info']['country_id']?>" data-state="<?= $info['address_info']['state_id']?>" data-city="<?= $info['address_info']['city_id']?>" data-weekday="<?= $info['address_info']['weekday'] ?>" type="radio" name="address_id" class="address_list" lay-filter="address_id_select" value="<?= $address_id ?>" title="<label  class='address_list_id'><?= Yii::$service->page->translate->__('Consignee:');?><?= $info['address_info']['first_name'] ?>  <?= $info['address_info']['last_name'] ?><br><?= Yii::$service->page->translate->__('Address:');?><?= $info['address_info']['country']?><?= $info['address_info']['state'] ?><?= $info['address_info']['city'] ?><br><?= $info['address_info']['street1'] ?><?= $info['address_info']['street2'] ?><br><?= Yii::$service->page->translate->__('Tel:');?><?= $info['address_info']['telephone'] ?><br><?= Yii::$service->page->translate->__('Email:');?><?= $info['address_info']['email'] ?><br></label>">
			      <div></div>
			    <?php } ?>
				<?php       endforeach;  ?>
				<?php  endif;  ?>
				  <input id="address_id_name" data-weekday="<?= $info['address_info']['weekday'] ?>" type="radio" name="address_id" class="address_list" lay-filter="address_id_select" value="" title="<label class='address_id_select'><?= Yii::$service->page->translate->__('New Address');?></label>">
			    </div>
				<input type="hidden" value="<?= $weekday ?>" name="weekday" id="weekday"/>
				<ul id="billing_address_list" class="billing_address_list_new layui-form display_none" >			
					<li class="clearfix">
						<div class="input-box input-firstname">
							<label class="required" for="billing:firstname"><?= Yii::$service->page->translate->__('First Name');?></label>
							<input value="<?= $cart_address['first_name'] ?>" id="billing:firstname" name="billing[first_name]" class="required-entry input-text" type="text" lay-verify="required">
						</div>
						<div class="input-box input-lastname">
							<label class="required" for="billing:lastname"><?= Yii::$service->page->translate->__('Last Name');?> </label>
							<input value="<?= $cart_address['last_name'] ?>" id="billing:lastname" name="billing[last_name]" class="required-entry input-text" type="text" lay-verify="required">
						</div>
						<div class="clear"></div>
					</li>
					<li class="clearfix">
						<div  class="  input-box width_100">
							<label class="required" for="billing:email"><?= Yii::$service->page->translate->__('Email Address');?> </label>
							<input  value="<?= $cart_address['email'] ?>" class="validate-email required-entry input-text width_83" title="Email Address" id="billing:email" name="billing[email]" type="text" lay-verify="required">
							<div class="customer_email_validation">
							
							</div>
						</div>
					</li>
					<li class="clearfix">
						<div class="input-box width_100">
							<label class="required" for="billing:telephone"><?= Yii::$service->page->translate->__('Telephone');?> </label>
							<input  value="<?= $cart_address['telephone'] ?>" id="billing:telephone" class="required-entry input-text width_83" title="Telephone" name="billing[telephone]" type="text" lay-verify="required">
						</div>
					</li>
					<li class="clearfix">
						<div class="input-box input-country">
							<label class="required" for="billing:country"><?= Yii::$service->page->translate->__('Country');?> </label>
							<select title="Country" class="billing_country validate-select" id="billing_country" name="billing[country]" lay-verify="required" lay-search lay-filter="province" lay-verify="required">
								
							</select>
						</div>
					</li>
					<li class="clearfix">
						<div class="input-box input-state">
							<label class="required" for="billing:state" class="required"><?= Yii::$service->page->translate->__('State');?> </label>
							<select title="State" class="billing_state validate-select address_state" id="billing_state" name="billing[state]" lay-verify="required" lay-search lay-filter="city" lay-verify="required">
								
							</select>
							
						</div>
					</li>
					<li class="clearfix">
						<div class="input-box input-city">
							<label class="required" for="billing:city"><?= Yii::$service->page->translate->__('City');?> </label>
							
							<select title="City" class="billing_city validate-select" id="billing_city" name="billing[city]" lay-verify="required" lay-search lay-filter="district" >
								
							</select>
						</div>
					</li>
					<li class="clearfix">
						<div class="input-box input-address">
							<label class="required" for="billing:street1"><?= Yii::$service->page->translate->__('Street');?><?= Yii::$service->page->translate->__('（請用中文地址）');?></label>
							<input maxlength="20" value="" class="required-entry input-text onestepcheckout-address-line" id="billing:street1" name="billing[street1]" title="Street Address 1" type="text">
							<br>
							<label class="required" for="billing:street2"><?= Yii::$service->page->translate->__('Building');?><?= Yii::$service->page->translate->__('（請用中文地址）');?></label>
							<input maxlength="40" value="" class="input-text onestepcheckout-address-line" id="billing:street2" name="billing[street2]" title="Street Address 2" type="text" lay-verify="required">
						</div>
					</li>
					<input type="hidden" value="000000" name="billing[zip]"/>
					<!--
					<li class="control">
						<input class="save_in_address_book checkbox" id="billing:save_in_address_book" title="Save in address book" value="1" name="billing[save_in_address_book]" checked="checked" type="checkbox"><label for="billing:save_in_address_book">Save in address book</label>
					</li>   
					-->	
					
				</ul>	
				
			</div>
			
		</li>
		<li class="clearfix">
			<div class="layui-form-item">
			    <div class="layui-block">
			      <label class="color_red"><?= Yii::$service->page->translate->__('Delivery Time:');?> <span id="shippingDateDesc"></span></label>
			      <div class="input-text onestepcheckout-address-line" class="color_red margin_6">
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
			      <div class="input-text onestepcheckout-shippingdate-line layui-input-inline" class="color_red margin_6">
			        <input type="text" class="layui-input" id="test-limit1" placeholder="yyyy-MM-dd" name="billing[shipping_date]" lay-verify="required">
			        <i class="layui-icon date-input-icon top_1" ></i>
			      </div>
			    </div>
			  </div>
			</div>
			
		</li>
	</ul>
</div>
<script>
<?php $this->beginBlock('address') ?>
 window.onload = function(){
	if( $("input[name='address_id']:checked").val()){
		
 		var aa= <?= $weekday ?>;
 		var weekdays=checkweekday(aa)['text'];
		$('#shippingDateDesc').text(weekdays);
 		$('#weekday').val(aa);
 		
	}
	
	layui.use('laydate', function(){
	  var laydate = layui.laydate;
	  var form = layui.form;
	  form.on('radio(address_id_select)', function(data){
		  
		  if(data.value){
		 		var aa= $(data.elem).data("weekday");
		 		var weekdays=checkweekday(aa)['text'];
				$('#shippingDateDesc').text(weekdays);
		 		$('#weekday').val(aa);
		 		ajaxreflush();
				$('#billing_address_list').css('display','none');
	      }else{
	      	var aabb= $('#address_id_name').attr('data-weekday');
			
			var weekdays=checkweekday(aabb)['text'];
			$('#shippingDateDesc').text(weekdays);
			$('#weekday').val(aabb);
	      	$('#billing_address_list').css('display','block');
			ajaxreflush();
	      }
		});
	  $(".new-address").click(function(){
		$("input[name='address_id']:checked").attr("checked",false);
		var a=$(":radio[name='address_id'][value='']").attr("checked",true);
		form.render('radio');
		$('#billing_address_list').css('display','block');
	})
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
          layer.setTop(layero); //重点2
        }
      });
    })
 	
	
	});
	
}
<?php $this->endBlock(); ?> 
</script>

<?php $this->registerJs($this->blocks['address'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>