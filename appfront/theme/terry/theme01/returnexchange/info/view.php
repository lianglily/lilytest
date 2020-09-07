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

	<div class="col-main account_center layui-form">
		<form class="std" id="returnForm">
			<div >
				<div class="my_account_order">
					<div class="order-items order-details ">
						
						<input type="hidden" class="csrf" value="<?php echo Yii::$app->getRequest()->getCsrfToken(); ?>" name="<?php echo Yii::$app->getRequest()->csrfParam; ?>" />
						<table summary="Items Ordered" id="my-orders-table" class="edit_order layui-form">
							<colgroup>
                               
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
							</colgroup>
							<thead>
								<tr class="first last ress_tit">
									
									<th><?= Yii::$service->page->translate->__('Product Name');?></th>
									<th><?= Yii::$service->page->translate->__('Product Image');?></th>
									<th><?= Yii::$service->page->translate->__('Sku');?></th>
									<th class="a-right"><?= Yii::$service->page->translate->__('Price');?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Qty');?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Return Status');?></th>
								</tr>
							</thead>
							
							<tbody class="odd">
								<?php if(is_array($products) && !empty($products)):  
									$total=0;
								?>
									<?php foreach($products as $product):
										$rate=1;
										if(!empty((float)$product['base_subtotal_with_discount'])){
											$rate=1-$product['base_subtotal_with_discount']/$product['base_subtotal'];
											
										}
										$total+=$product['price']*$product['qty'];
										$totalRate+=$product['price']*$product['qty']*$rate;
									?>
									<tr id="order-item-row" class="border first item_id_<?= $product['item_id'] ?>">
										<input type="hidden" name="editForm[items][]" value="<?= $product['item_id'] ?>">
										<td>
											<a href="<?=  Yii::$service->url->getUrl($product['redirect_url']); ?>">
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
											<div class="a-center_width" >
												
												<input disabled data-rate="<?= $rate ?>" data-price="<?= $product['price']; ?>" id="qty_<?= $product['item_id']; ?>" class="width_20" name="editForm[qty][]" onkeyup="keyUp(this)" onkeypress="keyPress(this)"   class="input-text qty cartqtychange" rel="<?= $product['item_id']; ?>" num="<?= $product['qty']; ?>" maxlength="100" t_value="<?= $product['qty']; ?>" value="<?= $product['qty']; ?>">
												<div class="clear"></div>
											</div>
										</td>
                                        <td class="a-center">
											<?php
                                            if($product['retuan_status']==1){ ?>
                                            	<?= Yii::$service->page->translate->__('Return / Exchange');?>
                                            <?php }elseif($product['retuan_status']==2){?>
                                            	<?= Yii::$service->page->translate->__('Return');?> <?= $product['return_unique_id']?>
                                            <?php }elseif($product['retuan_status']==3){?>
                                            	<?= Yii::$service->page->translate->__('Return');?> <?= $product['return_unique_id']?>
                                            <?php }elseif($product['retuan_status']==4){?>
                                            	<?= Yii::$service->page->translate->__('Exchange');?> <?= $product['return_unique_id']?>
                                            <?php } ?>
                                            
										</td>
										
									</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								
								</tbody>								   
						</table>
						
					</div>
				</div>
			</div>
		</form>
		
	</div>
	
<?php $this->registerJs($this->blocks['simpleproduct'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>