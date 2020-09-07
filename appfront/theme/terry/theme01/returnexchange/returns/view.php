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
$returnTypeArr=Yii::$service->returnexchange->getReturnTypeArr();
$returnReasonArr=Yii::$service->returnexchange->getReturnReasonArr();
$returnPaymentMethodArr=Yii::$service->returnexchange->getReturnPaymentMethodArr();
$returnShippingMethodArr=Yii::$service->returnexchange->getReturnShippingMethodArr();
$returnProcessStatusArr=Yii::$service->returnexchange->getReturnProcessStatusArr();
?>
    <?= Yii::$service->page->widget->render('base/breadcrumbs',$this); ?>
	<div class="col-main account_center">
		<div class="std">
			<div class="margin_19">
				<div class="my_account_order">
					<div class="page-title title-buttons">
						<h1><?= Yii::$service->page->translate->__('Return #');?><?=  $return_unique_id ?>  <?=  date('Y-m-d',$created_at); ?></h1>
					</div>
					<div class="col2-set order-info-box">
						<div class="col-1">
							<div class="box box-payment">
								<div class="box-title">
									<h2><?= Yii::$service->page->translate->__('Sales Return Type');?></h2>
								</div>
								<div class="box-content">
									<address><?= $returnTypeArr[$type]?>
                                    <br>
                                    
                                    <?= Yii::$service->page->translate->__('Return Status');?>: 
                                        <span class="color_777">
                                            <?=  $return_process_status ? $returnProcessStatusArr[$return_process_status] : Yii::$service->page->translate->__('No Message') ?>
                                        </span>
                                    </address>
								</div>
							</div>				
                        </div>
						<div class="col-1">
							<div class="box">
                                <div class="box-title">
                                    <h2><?= Yii::$service->page->translate->__('Repay Info');?></h2>
                                </div>
                                <div class="box-content">
                                    <address><?= $returnPaymentMethodArr[$repayment_method]?>
                                    <br>
                                    <?= $repayment_info?>
                                    </address>
                                </div>
                            </div>				
                        </div>
						<div class="col-1">
							<div class="box">
                                <div class="box-title">
                                    <h2><?= Yii::$service->page->translate->__('Return Info');?></h2>
                                </div>
                                <div class="box-content">
                                    <address>
                                    	<?= $returnShippingMethodArr[$shipping]?>
                                        <br>
                                    	<?= Yii::$service->page->translate->__('Tracking Number');?>: 
                                        <span class="color_777">
                                        	
                                            <?=  $tracking_number ? $tracking_number : Yii::$service->page->translate->__('No Message') ?>
                                        </span>
                                        <br>
                                        <?= $returnReasonArr[$reason] ?>
	                                    <br>
	                                    <?= $desc?>
                                    
                                    </address>
                                </div>
                            </div>				
						</div>
						<div class="col-1">
							<div class="box">
                                <div class="box-title">
                                    <h2><?= Yii::$service->page->translate->__('Upload');?></h2>
                                </div>
                                <div class="box-content">
                                    <address>
                                    <?php if($img){?>
                                    <img src="<?= Yii::$service->apply->attachment->getUrl($img,[100,100],false) ?>" alt="<?= $product['name'] ?>" width="75" height="75">
                                    <?php }else{ ?>
                                    No picture
                                    <?php }?>
                                    </address>
                                </div>
                            </div>				
						</div>
					</div>
					
					<div class="order-items order-details">
						<h2 class="table-caption"><?= Yii::$service->page->translate->__('Items Ordered');?></h2>

						<table summary="Items Ordered" id="my-orders-table" class="data-table">
							<colgroup>
                                <col>
                                <col width="1">
                                <col width="1">
                                <col width="1">
                                <col width="1">
							</colgroup>
							<thead>
								<tr class="first last">
									<th><?= Yii::$service->page->translate->__('Product Name');?></th>
									<th><?= Yii::$service->page->translate->__('Product Image');?></th>
									<th><?= Yii::$service->page->translate->__('Sku');?></th>
									<th class="a-right"><?= Yii::$service->page->translate->__('Price');?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Qty');?></th>
                                    <th class="a-center"><?= Yii::$service->page->translate->__('Review');?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Subtotal');?></th>
								</tr>
							</thead>
							
							<tbody class="odd">
								<?php if(is_array($products) && !empty($products)):  ?>
									<?php foreach($products as $product):
										//$total+=Format::price($product['price'])*$product['qty'];
									?>
									<tr id="order-item-row" class="border first">	
										<td>
											<a href="<?=  Yii::$service->url->getUrl($product['redirect_url']) ; ?>">
												<h3 class="product-name">
													<?= $product['name'] ?>
												</h3>
											</a>
											<?php  if(is_array($product['custom_option_info'])):  ?>
											<ul>
												<?php foreach($product['custom_option_info'] as $label => $val):  ?>
													
													<li><?= Yii::$service->page->translate->__($label.':') ?><?= Yii::$service->page->translate->__($val) ?> </li>
													
												<?php endforeach;  ?>
											</ul>
											<?php endif;  ?>
											<dl class="item-options">
												
											</dl>
											
										</td>
										<td>
											<a href="<?=  Yii::$service->url->getUrl($product['redirect_url']) ; ?>">
												<img src="<?= Yii::$service->product->image->getResize($product['image'],[100,100],false) ?>" alt="<?= $product['name'] ?>" width="75" height="75">
											</a>
										</td>
										<td><?= $product['sku'] ?></td>
										<td class="a-right">
											<span class="price-excl-tax">
												<span class="cart-price">
													<span class="price"><?= $currency_symbol ?><?= Format::price($product['price']); ?></span>                    
												</span>
											</span>
											<br>
										</td>
										<td class="a-center">
											<span class="nobr" >
                                                <strong><?= $product['qty'] ?></strong>
                                                <br>
											</span>
										</td>
                                        <td class="a-center">
											<a href="<?= Yii::$service->url->getUrl('/catalog/reviewproduct/add',['_id' => $product['product_id']])  ?>">
                                                <span class="" >
                                                    Review 
                                                    <br>
                                                </span>
                                            </a>
										</td>
										<td class="a-center last">
											<span class="price-excl-tax">
												<span class="cart-price">
													<span class="price"><?= $currency_symbol ?><?= Format::price($product['price'])*$product['qty'] ?></span>                    
												</span>
											</span>
											<br>
										</td>
									</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
								<tfoot>
									<tr class="grand_total last">
										<td class="a-right" colspan="6">
											<strong><?= Yii::$service->page->translate->__('Grand Total');?></strong>
										</td>
										<td class="last a-center">
											<strong><span class="price"><?= $currency_symbol ?><?=  Format::price($price); ?></span></strong>
										</td>
									</tr>
								</tfoot>
						</table>
						<br/>
						<div class="buttons-set">
							<p class="back-link"><a href="<?= Yii::$service->url->getUrl('returnexchange/returns/index'); ?>"><small> « </small><?= Yii::$service->page->translate->__('Back to My Returns');?></a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	