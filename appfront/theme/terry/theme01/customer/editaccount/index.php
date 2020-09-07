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
<div class="main container two-columns-left">
	<div class="clear"></div>
    <?= Yii::$service->page->widget->render('base/breadcrumbs',$this); ?>
    <?= Yii::$service->page->widget->render('base/flashmessage'); ?>
	<div class="col-main account_center">
		<div class="std">
			<div class="margin_4">
				<div class="page-title">
					<h2><?= Yii::$service->page->translate->__('Personal Information'); ?></h2>
				</div>
				
				<div class="box-account box-info" style="margin-top:0px">
					<div class="col2-set">
						<div class="col-12">
							<div class="box">
								
								<div class="box-content">
									<div>							
										<form class="layui-form"  method="post" id="form-validate" autocomplete="off" action="<?=  Yii::$service->url->getUrl('customer/editaccount') ?>">
											<?= \fec\helpers\CRequest::getCsrfInputHtml();  ?>
										  <div class="layui-form-item">
										    <div class="layui-inline">
										      <label class=" required layui-form-label account_info_label"><?= Yii::$service->page->translate->__('Company CN');?></label>
										      <div class="layui-input-inline">
										        <input  readonly="true" class="border_none" id="customer_companycn" name="editForm[companycn]" value="<?= Yii::$app->user->identity->companycn ?>" title="companycn" maxlength="255" class="layui-input required-entry" type="text">
										       
										      </div>
										    </div>
										    </div>
										    <div class="layui-form-item">
										    <div class="layui-inline">
										      <label class="layui-form-label required account_info_label"><?= Yii::$service->page->translate->__('Company EN');?></label>
										      <div class="layui-input-inline">
										        <input readonly="true" class="border_none" id="customer_companyen" name="editForm[companyen]" value="<?= Yii::$app->user->identity->companyen ?>" title="companyen" maxlength="255" class=" required-entry layui-input" type="text">
										      </div>
										    </div>
										  </div>
										  <div class="layui-form-item">
										    <div class="layui-inline">
										      <label class=" required layui-form-label account_info_label"><?= Yii::$service->page->translate->__('Email Address');?></label>
										      <div class="layui-input-inline">
										        <input  readonly="true" class="border_none" id="customer_email" lay-verify="require|email" name="editForm[email]" value="<?= $email ?>" title="Email" maxlength="255" class=" required-entry layui-input" type="text">
										      </div>
										    </div>
										  </div>
										  <div class="layui-form-item">
										    <div class="layui-inline">
										      <label class=" required layui-form-label account_info_label"><?= Yii::$service->page->translate->__('First Name');?></label>
										      <div class="layui-input-inline">
										        <input  id="firstname" lay-verify="require" name="editForm[firstname]" value="<?= $firstname ?>" title="First Name" maxlength="255" class=" required-entry layui-input" type="text">
										      </div>
										    </div>
										    <div class="layui-inline">
										      <label class="layui-form-label required account_info_label"><?= Yii::$service->page->translate->__('Last Name');?></label>
										      <div class="layui-input-inline">
										        <input id="lastname" lay-verify="require" name="editForm[lastname]" value="<?= $lastname ?>" title="Last Name" maxlength="255" class=" required-entry layui-input" type="text">
										      </div>
										    </div>
										  </div>
										  <div class="layui-form-item">
										    <div class="layui-inline">
										      <label for="contact" class=" required layui-form-label account_info_label"><?= Yii::$service->page->translate->__('Contact To');?></label>
										      <div class="layui-input-inline">
										        <input   id="contact" lay-verify="require" name="editForm[contact]" value="<?= $contact ?>" title="Contact" maxlength="255" class=" required-entry layui-input" type="text">
										      </div>
										    </div>
										  </div>
										  <div class="layui-form-item" pane="">
										    <div class="layui-inline">
										    	<label class="layui-form-label account_info_label"></label>
										      <input lay-skin="primary" name="editForm[change_password]" id="change_password" value="1" lay-filter="setPasswordForm"  title="<?= Yii::$service->page->translate->__('Change Password');?>" class="checkbox" type="checkbox" >
										    </div>
										  </div>
										  <div class="display_none" id="fieldset_pass" >
										  	 <div class="layui-form-item">
										  	 	
											    <div class="layui-inline">
											      <label for="current_password" class="required layui-form-label account_info_label"><?= Yii::$service->page->translate->__('Current Password');?></label>
											      <div class="layui-input-inline">
											        <input  title="Current Password" lay-verify="require|checkPass" class=" required-entry layui-input" name="editForm[current_password]" lay-verType="tips" id="current_password" type="password">
											      </div>
											    </div>
											  </div>
											  <div class="layui-form-item">
											    <div class="layui-inline">
											      <label for="password" class="required layui-form-label account_info_label"><?= Yii::$service->page->translate->__('New Password');?></label>
											      <div class="layui-input-inline">
											        <input  title="New Password" lay-verType="tips" lay-verify="require|checkPass" class=" validate-password required-entry layui-input" name="editForm[password]" id="password" type="password">
											      </div>
											    </div>
											  </div>
											  <div class="layui-form-item">
											    <div class="layui-inline">
											      <label for="confirmation" class="required layui-form-label account_info_label"><?= Yii::$service->page->translate->__('Confirm New Password');?></label>
											      <div class="layui-input-inline">
											        <input  title="Confirm New Password" lay-verType="tips" lay-verify="require|checkPass" class=" validate-cpassword required-entry layui-input" name="editForm[confirmation]" id="confirmation" type="password">
											        <div class="validation-advice display_none" id="required_confirm_password" ><?= Yii::$service->page->translate->__('This is a required field.');?></div>
						
											      </div>
											    </div>
											  </div>
										  </div>
										  <div class="layui-form-item">
										    <div class="layui-input-block">
										      <button class="layui-btn" lay-submit lay-filter="check_edit" ><?= Yii::$service->page->translate->__('Update Personal Information');?></button>
										    </div>
										  </div>
										</form>
				
									</div>
								</div>
							</div>
						</div>
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
<?php $this->beginBlock('customer_account_info_update') ?> 
layui.use(['form', 'layedit', 'laydate'], function(){
	var form = layui.form
  ,layer = layui.layer;
  //自定义验证规则
  form.verify({
  	require:function(value,item){
  		if(value) {$(item).removeClass("validation-failed");return '';}
  		$(item).parent().append('<div class="validation-advice" id="min_lenght"><?= Yii::$service->page->translate->__('This is a required field.');?></div>');
		$(item).addClass("validation-failed");
  		return ''; 
  	}
    ,checkEmail: function(value,item){
      var myReg = /^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/; 
        if(myReg.test(value)){ $(item).removeClass("validation-failed"); return '';} 
        $(item).parent().append('<div class="validation-advice" id="min_lenght">Invalid email.</div>');
		$(item).addClass("validation-failed");
        return ''; 
      
    }
    ,checkPass:function(value,item){
    	
    	var myReg = /^[\S]{6,12}$/; 
        if(myReg.test(value)){$(item).removeClass("validation-failed"); return '';} 
       
        $(item).parent().append('<div class="validation-advice" id="min_lenght">Must have 6 to 30 characters and no spaces.</div>');
		$(item).addClass("validation-failed");
        return '';
    }
    
  });
   function checkPass(value){
    	
    	var myReg = /^[\S]{6,12}$/; 
        if(myReg.test(value)) return true; 
       
        
        return false;
    }
  
  //监听指定开关
  form.on('checkbox(setPasswordForm)', function(data){
  	
  	if(this.checked){
        $('#fieldset_pass').show();
    }else{
        $('#fieldset_pass').hide();
    }
    
  });
  
  //监听提交
  form.on('submit(check_edit)', function(data){
  	
    	$check_current_password = true;
        $check_new_password = true;
        $check_confir_password = true;
		$check_current_firstname = true;
		$check_current_lastname = true;
		
		$firstname =data.field["editForm[firstname]"];
		$lastname = data.field["editForm[lastname]"];
		$check_confir_password_with_pass = true;
		
		if($firstname == ''){
		   
		   $check_current_firstname = false;
		}else{
		   
		   $check_current_firstname = true;
		}
		
		if($lastname == ''){
		   
		   $check_current_lastname = false;
		}else{
		   
		   $check_current_lastname = true;
		}
		
		
        if($('#change_password').is(':checked')){
            $current_password = data.field["editForm[current_password]"];
            $password = data.field["editForm[password]"];
            $confirmation = data.field["editForm[confirmation]"];
            if($current_password == ''){
               
               $check_current_password = false;
            }else{
               
               $check_current_password = true;
            }
            if($password == ''){
               
               $check_new_password = false;
            }else{
                if(!checkPass($password)){
                    
                    $check_new_password = false;
                }else{
                    
                    $check_new_password = true;
                }
            }
			
            if($confirmation == ''){
               
               $check_confir_password = false;
            }else{
                if(!checkPass($confirmation)){
                    
                    $check_confir_password = false;
                 }else{
                 
					if($password != $confirmation){
						$('#confirmation').addClass('validation-failed');
						$('#required_confirm_password').show();
						$('#required_confirm_password').html('Two password is not the same！');
						$check_confir_password_with_pass = false;
					}else{
						$('#confirmation').removeClass('validation-failed');
						$('#required_confirm_password').hide();
						$check_confir_password = true;
					}
                    
                }
            }
		}
		
		if( $check_confir_password_with_pass && $check_current_firstname && $check_current_lastname && $check_confir_password && $check_new_password && $check_current_password){
			return true;
		}else{
			return false;
		}
    return false;
  });
});

   
<?php $this->endBlock(); ?>  
</script>  
<?php $this->registerJs($this->blocks['customer_account_info_update'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>

	