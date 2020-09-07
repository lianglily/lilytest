<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
use yii\helpers\Html;
use fec\helpers\CRequest;
use fecadmin\models\AdminRole;
/** 
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
?>
<style>
.checker{float:left;}
.dialog .pageContent {background:none;}
.dialog .pageContent .pageFormContent{background:none;}
</style>

<div class="pageContent"> 
	<form  method="post" action="<?= $saveUrl ?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDoneCloseAndReflush);">
		<?php echo CRequest::getCsrfInputHtml();  ?>	
		<div layouth="56" class="pageFormContent" style="height: 240px; overflow: auto;">
			
				<input type="hidden"  value="<?=  $product_id; ?>" size="30" name="product_id" class="textInput ">
				
				<fieldset id="fieldset_table_qbe">
					<legend style="color:#009688"><?= Yii::$service->page->translate->__('Edit Info') ?></legend>
					<div>
						<?= $editBar; ?>
					</div>
				</fieldset>
				<?= $lang_attr ?>
				<?= $textareas ?>
				<?php  if(is_array($return_arr['order_list']) && !empty($return_arr['order_list'])):  ?>
				<fieldset id="fieldset_table_qbe">
					<legend style="color:#009688"><?= Yii::$service->page->translate->__('Credit Info') ?></legend>
					<div>
				<table id="my-orders-table" class="data-table list" style="width:100%;table-layout: auto;">
					<thead>
						<tr class="first last">
							<th><?= Yii::$service->page->translate->__('Order #');?> </th>
							<th><?= Yii::$service->page->translate->__('Date');?></th>
							<th><span class="nobr"><?= Yii::$service->page->translate->__('Order Total');?></span></th>
							<th><span class="nobr"><?= Yii::$service->page->translate->__('Order Status');?></span></th>
						</tr>
					</thead>
					<tbody class="odd">
					
						<?php foreach($return_arr['order_list'] as $order):
							
						?>
							<tr class="first odd border">
								<td ><?= $order['order_id'] ?></td>
								<td><span class="nobr"><?= date('Y-m-d H:i:s',$order['time']) ?></span></td>
								<td> <?= $order['amount'] ?></td>
								
								<td><?php  if($order['type']==1){
									echo Yii::$service->page->translate->__('Deductions');
								}else if($order['type']==2){
								
									echo Yii::$service->page->translate->__('Repayment'); 
								}else{
									echo Yii::$service->page->translate->__('Invalid');
								}
								?></td>
					
							</tr>
						<?php endforeach; ?>
					
						
					</tbody>
				</table>
				<?php if($return_arr['pageToolBar']): ?>
					<div class="pageToolbar">
						<label class="title"><?= Yii::$service->page->translate->__('Page:');?></label><?= $return_arr['pageToolBar'] ?>
					</div>
				<?php endif; ?>
				</fieldset>
				<?php endif; ?>
		</div>
	
		<div class="formBar">
			<ul>
				<!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
				<li>
                    <div class="buttonActive"><div class="buttonContent"><button onclick="func('accept')"  value="accept" name="accept" type="submit"><?= Yii::$service->page->translate->__('Save') ?></button></div></div>
                </li>
				<li>
					<div class="button"><div class="buttonContent"><button type="button" class="close"><?= Yii::$service->page->translate->__('Cancel') ?></button></div></div>
				</li>
			</ul>
		</div>
	</form>
</div>	

