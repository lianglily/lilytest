<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<div class="main container two-columns-left">
    <?= Yii::$service->page->widget->render('base/breadcrumbs',$this); ?>
    <?= Yii::$service->page->widget->render('base/flashmessage'); ?>
	<div class="col-main account_center">
		<div class="std">
			<div class="margin-4">
				<div class="page-title">
					<h2><?= Yii::$service->page->translate->__('Customer Credit');?></h2>
				</div>
				<table id="my-orders-table" class="edit_order">
					<thead>
						<tr class="first last">
							<th><?= Yii::$service->page->translate->__('Order #');?> </th>
							<th><?= Yii::$service->page->translate->__('Date');?></th>
							<th><span class="nobr"><?= Yii::$service->page->translate->__('Order Total');?></span></th>
							<th><span class="nobr"><?= Yii::$service->page->translate->__('Order Status');?></span></th>
						</tr>
					</thead>
					<tbody>
					<?php  if(is_array($order_list) && !empty($order_list)):  ?>
						<?php foreach($order_list as $order):
							
						?>
							<tr class="first odd">
								<td><?php $order_ids=explode(',',$order['order_id']);
									foreach ($order_ids as $val){
										echo '<a href="'.Yii::$service->url->getUrl('creditpay/info/view',['order_id' => $val]).'">'.$val.'</a> | ';
									}
								?></td>
								<td><span class="nobr"><?= date('Y-m-d H:i:s',$order['time']) ?></span></td>
								<td> <?= Yii::$service->page->currency->getCurrencyInfo()['symbol'] ?><?= Yii::$service->product->price->formatPrice($order['amount'])['value'] ?></td>
								
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
					<?php endif; ?>
						
					</tbody>
				</table>
				<?php if($pageToolBar): ?>
					<div class="pageToolbar">
						<label class="title"><?= Yii::$service->page->translate->__('Page:');?></label><?= $pageToolBar ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	
	<div class="col-left ">
    <?= Yii::$service->page->widget->render('customer/left_menu', $this); ?>
	</div>
	<div class="clear"></div>
</div>
	