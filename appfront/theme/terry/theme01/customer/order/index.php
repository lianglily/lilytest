<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
 $orderProcessStatus=Yii::$service->order->getSelectProcessStatusArr();
?>
<div class="main container two-columns-left">
	<div class="clear"></div>
    <?= Yii::$service->page->widget->render('base/breadcrumbs',$this); ?>
    <?= Yii::$service->page->widget->render('base/flashmessage'); ?>
	<div class="col-main account_center">
		<div class="std">
			<div class="margin_4">
				<div class="page-title">
					<h2><?= Yii::$service->page->translate->__('Customer Order');?></h2>
				</div>
				<table id="my-orders-table" class="edit_order">
					<thead>
						<tr class="first last">
							<th><?= Yii::$service->page->translate->__('Order #');?> </th>
							<th><?= Yii::$service->page->translate->__('Date');?></th>
							<th><?= Yii::$service->page->translate->__('Shipping Date');?></th>
							<th><?= Yii::$service->page->translate->__('Ship To');?></th>
							<th><span class="nobr"><?= Yii::$service->page->translate->__('Order Total');?></span></th>
							<th><span class="nobr"><?= Yii::$service->page->translate->__('Payment Status');?></span></th>
                            <th><span class="nobr"><?= Yii::$service->page->translate->__('Order Status');?></span></th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php  if(is_array($order_list) && !empty($order_list)):  ?>
						<?php foreach($order_list as $order):
							
							$currencyCode = $order['order_currency_code'];
							$symbol = Yii::$service->page->currency->getCurrencyInfo($currencyCode)['code'];	
						?>
							<tr class="first odd">
								<td><?= $order['increment_id'] ?></td>
								<td><span class="nobr"><?= date('Y-m-d',$order['created_at']) ?></span></td>
								<td><span class="nobr"><?= date('Y-m-d',$order['shipping_date']) ?></span></td>
								<td><?= $order['customer_firstname'] ?> <?= $order['customer_lastname'] ?></td>
								<td><span class="price"><?= $symbol ?><?= $order['grand_total'] ?></span></td>
								<td><em><?= Yii::$service->page->translate->__($order['order_status']); ?></em></td>
								<td><em><?= Yii::$service->page->translate->__($orderProcessStatus[$order['order_process_status']]); ?></em></td>
								
                                <td class="a-center last">
									<span class="nobr"><a href="<?=  Yii::$service->url->getUrl('customer/order/view',['order_id' => $order['order_id']]);?>"><?= Yii::$service->page->translate->__('View Order');?></a>
									<span class="separator">|</span> <a class="link-reorder" href="<?=  Yii::$service->url->getUrl('customer/order/reorder',['order_id' => $order['order_id']]);?>"><?= Yii::$service->page->translate->__('Reorder');?></a>
									</span>
								</td>
                                
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
	
	
    <?= Yii::$service->page->widget->render('customer/left_menu', $this); ?>
	
	<div class="clear"></div>
</div>
	