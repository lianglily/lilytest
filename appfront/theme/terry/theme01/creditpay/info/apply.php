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
    <?= Yii::$service->page->widget->render('base/breadcrumbs',$this); ?>
	<div class="col-main account_center">
		<div class="std">
			<div style="margin:4px 0 0">
				<div class="page-title">
					<h2><?= Yii::$service->page->translate->__('Creditpay Apply'); ?></h2>
				</div>
				<div class="welcome-msg">
					<p class="hello"><strong><?= Yii::$service->page->translate->__('Hello'); ?>,  !</strong></p>
					<p><?= Yii::$service->page->translate->__('From your Creditpay Apply you have the ability of advance payment. You would get a certain credit after we  review the qualification of your company.'); ?></p>
				</div>
				<div class="box-account box-info">
					<div>
						
						
						<form class="layui-form layui-row" id="creditForm" enctype="mutipart/form-data">
							
							<?php echo CRequest::getCsrfInputHtml();  ?>
							<?php 
							    $data=json_decode($data['info'],true);
								$disable=(Yii::$app->user->identity->credit_status != -1)?'disabled=true':'';
								foreach( $info as $one ){ ?>
							<?php 
								
								if(isset($one['name'])){
									$label=$val=$one['name'];
								
									if($fields['name']['translate']){
										//先判断标题内容
										$label= Yii::$service->page->translate->__($val);
									}
								
									$default=($one['display_data']?$one['display_data']:($one['default']?$one['default']:''));
									
							?>
							<input type="hidden"  name="<?= $val ?>[display_type]" value="<?= $one['display_type'] ?>">
							<?php if($one['display_type']=="inputString"){ ?>
							  <div class="layui-form-item layui-col-xs6 layui-col-sm6 layui-col-md6" style=" clear: none;">
							    <label class="layui-form-label required" for="<?= $val ?>"><?= $label ?></label>
							    <div class="layui-input-inline">
							      <input <?= $disable?> type="text" id="<?= $val ?>" name="<?= $val ?>[value]" lay-verify="required|title" autocomplete="off" placeholder="" maxlength="255" class="layui-input required-entry" value="<?= $data[$val]['value'] ?>">
							    </div>
							    <?php if($one['remark']){?>
							    	<div class="layui-form-mid layui-word-aux " ><?= $one['remark']?></div>
							    <?php } ?>
							  </div>
							<?php }else if($one['display_type']=="radio"){ ?>  
							  <div class="layui-form-item layui-col-xs6 layui-col-sm6 layui-col-md6" style=" clear: none;">
							    <label class="layui-form-label required" for="<?= $val ?>"><?= $label ?></label>
							    <div class="layui-input-inline">
							      <?php foreach ($default as $key => $x ){ 
							               if($data[$val]['value']==$x['key']){
							      ?>
							         <input <?= $disable?> type="radio" id="<?= $val ?>" name="<?= $val ?>[value]" value="<?=$x['key'] ?>" title="<?=$x['key'] ?>" checked="">
							       <?php   }else{ ?>
							    	 <input <?= $disable?> type="radio" id="<?= $val ?>" name="<?= $val ?>[value]" value="<?=$x['key'] ?>" title="<?=$x['key'] ?>">
							       <?php }
							       } ?>
							    </div>
							    <?php if($one['remark']){?>
							    	<div class="layui-form-mid layui-word-aux"><?= $one['remark']?></div>
							    <?php } ?>
							  </div>
						    <?php }else if($one['display_type']=="inputEmail"){ ?>
							  <div class="layui-form-item layui-col-xs6 layui-col-sm6 layui-col-md6" style=" clear: none;">
							
							   
							      <label class="layui-form-label required" for="<?= $val ?>"><?= $label ?></label>
							      <div class="layui-input-inline">
							        <input <?= $disable?> type="text" id="<?= $val ?>" name="<?= $val ?>[value]" lay-verify="required|email" autocomplete="off" maxlength="255" class="layui-input required-entry" value="<?= $data[$val]['value'] ?>">
							      </div>
							    
							    <?php if($one['remark']){?>
							    	<div class="layui-form-mid layui-word-aux "><?= $one['remark']?></div>
							    <?php } ?>
							  </div>
						     <?php }else if($one['display_type']=="inputDate"){ ?>
							  <div class="layui-form-item layui-col-xs6 layui-col-sm6 layui-col-md6" style=" clear: none;">
							    
							
							      <label class="layui-form-label required" for="<?= $val ?>"><?= $label ?></label>
							      <div class="layui-input-inline">
							        <input <?= $disable?> type="text" id="<?= $val ?>" name="<?= $val ?>[value]" lay-verify="required|date" placeholder="yyyy-MM-dd" autocomplete="off"  maxlength="255" class="layui-input required-entry" value="<?= $data[$val]['value'] ?>">
							      </div>
							    
							   <?php if($one['remark']){?>
							    	<div class="layui-form-mid layui-word-aux"><?= $one['remark']?></div>
							    <?php } ?>
							  </div>
						     <?php }else if($one['display_type']=="checkbox"){ ?>
							  <div class="layui-form-item layui-col-xs12 layui-col-sm12 layui-col-md12" style=" clear: none;">
							    <label class="layui-form-label required" for="<?= $val ?>"><?= $label ?></label>
							    <div class="layui-input-block">
							      <?php foreach ($default as $key => $x ){ 
							      	       $y=$x['key'];
							               if(is_array($data[$val]['value']) &&in_array($x['key'],$data[$val]['value'])){
							      ?>
							         <input lay-verify="required" <?= $disable?> type="checkbox" name="<?= $val ?>[value][<?= $y ?>]" title="<?=$x['key'] ?>" value="<?=$x['key'] ?>" checked="">
							       <?php   }else{ ?>
							    	 <input lay-verify="required" <?= $disable?> type="checkbox" name="<?= $val ?>[value][<?= $y ?>]" title="<?=$x['key'] ?>" value="<?=$x['key'] ?>">
							       <?php }
							       } ?>
							    </div>
							    <?php if($one['remark']){?>
							    	<div class="layui-form-mid layui-word-aux"><?= $one['remark']?></div>
							    <?php } ?>
							  </div>
							 <?php }else if($one['display_type']=="select"){ ?>
							  <div class="layui-form-item layui-col-xs6 layui-col-sm6 layui-col-md6" style=" clear: none;">
							    <label class="layui-form-label required" for="<?= $val ?>"><?= $label ?></label>
							    <div class="layui-input-inline">
							      <select <?= $disable?> id="<?= $val ?>"  lay-verify="required" name="<?= $val ?>[value]" >
							      <?php foreach ($default as $key => $x ){ 
							               if($data[$val]['value']==$x['key']){
							      ?>
							  
							         <option value="<?=$x['key'] ?>" selected=""><?=$x['key'] ?></option>
							       <?php   }else{ ?>
							    	 <option value="<?=$x['key'] ?>" ><?=$x['key'] ?></option>
							       <?php }
							       } ?>
							      
							      </select>
							      
							    </div>
							    <?php if($one['remark']){?>
							    	<div class="layui-form-mid layui-word-aux"><?= $one['remark']?></div>
							    <?php } ?>
							  </div>
							 <?php }else if($one['display_type']=="attachment"){ ?>
							 <input type="hidden" value="<?= $data[$val]['value'] ?>" name="<?= $val ?>[value]">
							  <div class="layui-form-item layui-col-xs6 layui-col-sm6 layui-col-md6" style=" clear: none;">
							    <label class="layui-form-label required" for="<?= $val ?>"><?= $label ?></label>
							    <div class="layui-input-inline">
							      <button <?= $disable?> type="button" class="layui-btn" id="<?= $val ?>" name="<?= $val ?>"><i class="layui-icon"></i>上传文件</button>
							    </div>
							    <?php if($data[$val]['value']){ ?>
							    	<div class="layui-form-mid layui-word-aux layui-input-block"><a href="<?= Yii::$service->apply->attachment->getUrl($data[$val]['value']);  ?>">attachment</a></div>
							    <?php	}else{ ?>
							    	<?php if($one['remark']){?>
								    	<div class="layui-form-mid layui-word-aux"><?= $one['remark']?></div>
								    <?php } ?>
							    <?php	} ?>	
							  </div>
							  <?php }else if($one['display_type']=="address"){ 
								  	
								    $addressarr=explode('##',$data[$val]['value']);
								    if(empty($addressarr)){
								    	$addressarr=explode('##','1##1##1## ## ');
								    }
								    
								    list($countryvalue,$statevalue,$cityvalue,$street1,$street2)=$addressarr;
								    
									
							  ?>
								<input id="addressvalue" type="hidden" value="" name="<?= $val?>[value]">
								<input id="addressvalues" type="hidden" value="" name="<?= $val?>[values]">
								 <div class="layui-form-item layui-col-xs6 layui-col-sm6 layui-col-md6" style=" clear: none;">
									<label class="layui-form-label required" for="billing:country"><?= Yii::$service->page->translate->__('Country');?> </label>
									<div class="layui-input-inline">
										<select <?= $disable?> title="Country" data-country="<?= $countryvalue?>" class="billing_country validate-select" id="billing_country" name="country" lay-verify="required" lay-search lay-filter="province" lay-verify="required">
											
										</select>
									</div>
								</div>
								<div class="layui-form-item layui-col-xs6 layui-col-sm6 layui-col-md6" style=" clear: none;">
									<label class="layui-form-label required" for="billing:state" ><?= Yii::$service->page->translate->__('State');?></label>
									<div class="layui-input-inline">
									<select <?= $disable?> title="State" data-state="<?= $statevalue?>" class="billing_state validate-select" id="billing_state" name="state" lay-verify="required" lay-search lay-filter="city" lay-verify="required">
									
									</select>
									</div>
									
								</div>
								<div class="layui-form-item layui-col-xs6 layui-col-sm6 layui-col-md6" style=" clear: none;">
									<label class="layui-form-label required" for="billing:city"><?= Yii::$service->page->translate->__('City');?> </label>
									<div class="layui-input-inline">
									<select <?= $disable?> title="City" data-city="<?= $cityvalue?>" class="billing_city validate-select" id="billing_city" name="city" lay-verify="required" lay-search lay-filter="district" >
										
									</select>
									</div>
								</div>
								<div class="layui-form-item layui-col-xs6 layui-col-sm6 layui-col-md6" style=" clear: none;">
								    <div class="layui-inline">
								      <label class="layui-form-label required"><?= Yii::$service->page->translate->__('Street');?></label>
								      <div class="layui-input-inline">
								        <input <?= $disable?> type="tel" name="street1" id="billing_street1" lay-verify="required" value="<?= $street1 ?>" autocomplete="off" class="layui-input">
								      </div>
								    </div>
								    
								  </div>
							   
						     <?php } ?>
						   <?php } ?>
						<?php } ?>
						
				
						<?php if(Yii::$app->user->identity->credit_status == -1){?>
						  <div class="layui-form-item">
						    <div class="layui-input-block">
						      <button class="layui-btn" <?= $disable?> id="getcreditpaysubmit" lay-submit="" lay-filter="reg">立即提交</button>
						    </div>
						  </div>
					   <?php } ?>
						</form>
						
					</div>

				</div>
			</div>
		</div>
	</div>
	
		<?php
			$leftMenu = [
				'class' => 'fecshop\app\appfront\modules\Customer\block\LeftMenu',
				'view'	=> 'customer/leftmenu.php'
			];
		?>
		<?= Yii::$service->page->widget->render($leftMenu,$this); ?>
	
	<div class="clear"></div>
</div>
<script>
function submit_creditpayinfo(){
	$('#form-validate').submit();
}

</script>
<script>
	// add to cart js	
	<?php $this->beginBlock('add_creditpay_info') ?>
	$(document).ready(function(){
		layui.use('upload', function(){
		  var $ = layui.jquery
		  ,upload = layui.upload
		  ,form=layui.form
		  ,layer=layui.layer;
		  
		  //提交表单的方法
			 form.on('submit(reg)', function (data) {
			   $addressvalue=$("#billing_country").val()+"##"+$("#billing_state").val()+"##"+$("#billing_city").val()+"##"+$("#billing_street1").val()+"##"+'';
			   $addressvalues=$("#billing_country").find("option:selected").text()+" "+$("#billing_state").find("option:selected").text()+" "+$("#billing_city").find("option:selected").text()+" "+$("#billing_street1").val()+" ";
			   
			   $('#addressvalue').val($addressvalue);
			   $('#addressvalues').val($addressvalues);
			   var fd = new FormData();
			   var formData = new FormData($( "#creditForm" )[0]);
			  
			   $(this).attr("disabled", true);
			   $(this).css("background-color", "darkgray");
			   
			   $.ajax({
			    cache : true,
			    type : "post",
			    url : "<?= Yii::$service->url->getUrl('creditpay/info/applysave');?>",
			    async : false,
			    data : formData, // 你的formid
			    contentType: false, //jax 中 contentType 设置为 false 是为了避免 JQuery 对其操作，从而失去分界符，而使服务器不能正常解析文件
			    processData: false, //当设置为true的时候,jquery ajax 提交的时候不会序列化 data，而是直接使用data
			    error : function(request) {
			     layer.alert('操作失败');
			    },
			    success : function(ret) {
			    	ret=JSON.parse(ret);
			     if (ret.code=='fail') {
				      
				      layer.msg(ret.content);
			     } else  if (ret.code=='fail1') {
				      layer.msg('请登录');
				      
			    	  window.location.href=ret.url	
			     }else if(ret.code=='submitted'){
			     	 layer.msg(ret.content, {time: 20000});
			     	 window.location.href=ret.url
			     }else {
			    	layer.msg('success', {time: 20000});
			        
			     }
			     return false;
			    }
			    })
			    
			    return false;
			 })
    	form.verify({
    		required:function(value,item){
    			if(!value.length){
    				return '<?= Yii::$service->page->translate->__("This is a required field.") ?>';
    			}
    			
    		}
    	})
    
		  //指定允许上传的文件类型
		  <?php foreach( $info as $one ){ 
		  	     if($one['display_type']=='attachment'){
		  	?>
			  upload.render({
			    elem: "#<?= $one['name'] ?>"
			    ,url: 'https://httpbin.org/post' //改成您自己的上传接口
			    ,accept: 'file' //普通文件
			    ,auto: false
			    ,field: "<?= $one['name'] ?>"
			    ,bindAction: '#get'
			    ,done: function(res){
			      
			    }
			  });
		  <?php } } ?>
		});
	});
	<?php $this->endBlock(); ?> 
	<?php $this->registerJs($this->blocks['add_creditpay_info'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>	
</script>