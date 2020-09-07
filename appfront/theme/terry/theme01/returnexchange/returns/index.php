<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
$returnTypeArr=Yii::$service->returnexchange->getReturnTypeArr();
$returnReasonArr=Yii::$service->returnexchange->getReturnReasonArr();
$returnPaymentMethodArr=Yii::$service->returnexchange->getReturnPaymentMethodArr();
$returnShippingMethodArr=Yii::$service->returnexchange->getReturnShippingMethodArr();
$returnProcessStatusArr=Yii::$service->returnexchange->getReturnProcessStatusArr();
?>

    <?= Yii::$service->page->widget->render('base/breadcrumbs',$this); ?>
    <?= Yii::$service->page->widget->render('base/flashmessage'); ?>
	<div class="col-main account_center">
		<div class="std">
			<div class="margin_4">
				<div class="page-title">
					<h2><?= Yii::$service->page->translate->__('Customer Return');?></h2>
				</div>
				<table id="my-orders-table" class="edit_order">
					<thead>
						<tr class="first last">
							<th><?= Yii::$service->page->translate->__('Return #');?> </th>
							<th><?= Yii::$service->page->translate->__('Date');?></th>
							<th><?= Yii::$service->page->translate->__('Return/Exchange');?></th>
							<th><span class="nobr"><?= Yii::$service->page->translate->__('Price');?></span></th>
							<th><span class="nobr"><?= Yii::$service->page->translate->__('Return Status');?></span></th>
                            <th><span class="nobr"><?= Yii::$service->page->translate->__('Repay Method');?></span></th>
                            <th><span class="nobr"><?= Yii::$service->page->translate->__('Tracking Number');?></span></th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php  if(is_array($order_list) && !empty($order_list)):  ?>
						<?php foreach($order_list as $order):
							$currencyCode = $order['order_currency_code'];
							$symbol = Yii::$service->page->currency->getSymbol($currencyCode);	
						?>
							<tr class="first odd">
								<td><?= $order['return_unique_id'] ?></td>
								<td><span class="nobr"><?= date('Y-m-d',$order['created_at']) ?></span></td>
								<td><?= $order['type']?$returnTypeArr[$order['type']]:Yii::$service->page->translate->__('No Message') ?> </td>
								<td><span class="price"><?= $symbol ?><?= $order['price'] ?></span></td>
								<td><em><?= $order['return_process_status']?$returnProcessStatusArr[$order['return_process_status']]:Yii::$service->page->translate->__('No Message') ?></em></td>
								<td><?= $order['repayment_method']?$returnPaymentMethodArr[$order['repayment_method']]:Yii::$service->page->translate->__('No Message') ?></td>
								<td><?= $order['tracking_number'] ?></td>
                                <td class="a-center last">
									<span class="nobr"><a href="<?=  Yii::$service->url->getUrl('returnexchange/returns/view',['return_id' => $order['return_id']]);?>"><?= Yii::$service->page->translate->__('View Order');?></a>
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
	