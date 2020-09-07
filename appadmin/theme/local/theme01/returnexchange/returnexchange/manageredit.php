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
use fecshop\app\appfront\helper\Format;
/** 
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
 $returnProcessStatusArr=Yii::$service->returnexchange->getReturnProcessStatusArr();
 $returnPaymentMethodArr=Yii::$service->returnexchange->getReturnPaymentMethodArr();
 $returnShippingMethodArr=Yii::$service->returnexchange->getReturnShippingMethodArr();
 
 $returnReasonArr=Yii::$service->returnexchange->getReturnReasonArr();
 $returnTypeArr=Yii::$service->returnexchange->getReturnTypeArr();
?>
<style>
.checker{float:left;}
.dialog .pageContent {background:none;}
.dialog .pageContent .pageFormContent{background:none;}
</style>

<div class="pageContent" style="background:#fff;">
	<form  id="order_save" method="post" action="<?= $saveUrl ?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDoneCloseAndReflush);">
		<?php echo CRequest::getCsrfInputHtml();  ?>	
		<div layouth="56" class="pageFormContent" style="height: 240px; overflow: auto;">
			
				<input type="hidden"  value="<?=  $order['return_id']; ?>" size="30" name="editForm[return_id]" class="textInput ">
				
				<fieldset id="fieldset_table_qbe">
					<legend style="color:#009688"><?= Yii::$service->page->translate->__('Order Info')  ?></legend>
					<div>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Increment Id')  ?>：</label>
							<span><?= $order['return_unique_id'] ?></span>
						</p>
						
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Return Process Status')  ?>：</label>
							<span>
							<select name="editForm[return_process_status]">
								<?php 
								foreach($returnProcessStatusArr as $key => $val ){
									if($key==$order['return_process_status']){
								?>
										<option value="<?= $key ?>" selected="selected" ><?= $val ?></option>
									<?php }else{ ?>
										<option value="<?= $key ?>" ><?= $val ?></option>
									
								<?php } }?>
							</select></span>
						</p>

						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Item Count')  ?>：</label>
							<span><?= $order['items_count'] ?></span>
						</p>
						
					
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Currency Code')  ?>：</label>
                            <span><?= $order['order_currency_code'] ?></span>
                       
						</p>
						<?php $symbol = Yii::$service->page->currency->getSymbol($order['order_currency_code']);  ?>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Rate / Base')  ?>：</label>
							<span><?= $order['order_to_base_rate'] ?></span>
						</p>
						
			
                        <p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Return Type')  ?>：</label>
							<span><?= $returnTypeArr[$order['type']] ?></span>
						</p>
					
						
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Total')  ?>：</label>
							<span><?= $symbol.$order['price'] ?></span>
						</p>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Base Total')  ?>：</label>
							<span><?= $order['base_price'] ?></span>
						</p>

					</div>
				</fieldset>
				
				<fieldset id="fieldset_table_qbe">
					<legend style="color:#009688"><?= Yii::$service->page->translate->__('Order Customer Info')  ?></legend>
					<div>
				
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('First Name')  ?>: </label>
							<span>
                                <?= $order['order_customer_firstname'] ?>
                            </span>
                        </p>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Last Name')  ?>: </label>
							<span>
                                <?= $order['order_customer_lastname'] ?> 
                            </span>
                        </p>
						
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Email')  ?>: </label>
							<span>
                                <?= $order['order_customer_email'] ?>
                            </span>
                            
                        </p>
						
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Customer Id')  ?>: </label>
							<span>
                                <?= $order['customer_id'] ?>
                            </span>
						</p>
					</div>
				</fieldset>
				
				<fieldset id="fieldset_table_qbe">
					<legend style="color:#009688"><?= Yii::$service->page->translate->__('Order Shipping Info')  ?></legend>
					<div>
				
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Shipping Method')  ?>: </label>
							<span><?= $returnShippingMethodArr[$order['shipping']] ?></span>
						</p>
						
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Tracking Number')  ?>：</label>
                            <span>
                                <input type="text" name="editForm[tracking_number]" value="<?= $order['tracking_number'] ?>" />
                            </span>
						</p>
					</div>
				</fieldset>
				
                <fieldset id="fieldset_table_qbe">
					<legend style="color:#009688"><?= Yii::$service->page->translate->__('Order Customer Remark')  ?></legend>
					<div>
                        <textarea style="width:98%;height:100px;"><?= $order['descs'] ?></textarea>
                    </div>
                </fieldset>   
				
				<fieldset id="fieldset_table_qbe">
					<legend style="color:#009688"><?= Yii::$service->page->translate->__('Order Product Info')  ?></legend>
					<div>
						<table summary="Items Ordered" id="my-orders-table" class="data-table list" style="width:100%;table-layout: auto;">
							<colgroup><col>
							<col width="1">
							<col width="1">
							<col width="1">
							<col width="1">
							</colgroup>
							<thead>
								<tr class="first last">
									<th><?= Yii::$service->page->translate->__('Product Name')  ?></th>
									<th><?= Yii::$service->page->translate->__('Image')  ?></th>
									<th><?= Yii::$service->page->translate->__('Sku')  ?></th>
									<th class="a-right"><?= Yii::$service->page->translate->__('Price')  ?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Qty')  ?></th>
									<th class="a-right"><?= Yii::$service->page->translate->__('Total')  ?></th>
								</tr>
							</thead>
							
							<tbody class="odd">
								<?php if(is_array($order['products']) && !empty($order['products'])){  ?>
									<?php foreach($order['products'] as $product){ ?>
									<tr id="order-item-row" class="border first">	
										<td>
											<a href="<?= '#' //Yii::$service->url->getUrl($product['redirect_url']) ; ?>">
												<h3 class="product-name">
													<?= $product['name'] ?>
												</h3>
											</a>
											<?php  if(is_array($product['custom_option_info'])){  ?>
											<ul>
												<?php foreach($product['custom_option_info'] as $label => $val){  ?>
													
													<li><?= $label ?>:<?= $val ?> </li>
													
												<?php }  ?>
											</ul>
											<?php }  ?>
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
													<span class="price"><?= $symbol ?><?= Format::price($product['price']); ?></span>                    
												</span>
											</span>
											<br>
										</td>
										<td class="a-right">
											<span class="nobr" style="text-align:center;width:30px;display:block" ><strong><?= $product['qty'] ?></strong><br>
											</span>
										</td>
										<td class="a-right last">
											<span class="price-excl-tax">
												<span class="cart-price">
													<span class="price"><?= $symbol ?><?= Format::price($product['price'])*$product['qty']; ?></span>                    
												</span>
											</span>
											<br>
										</td>
									</tr>
									<?php } ?>
								<?php } ?>
							</tbody>	

							<tfoot>
								<tr class="grand_total last">
									<td class="a-right" colspan="5">
										<strong><?= Yii::$service->page->translate->__('Grand Total')  ?></strong>
									</td>
									<td class="last a-right">
										<strong><span class="price"><?= $symbol ?><?=  Format::price($order['price']); ?></span></strong>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</fieldset>
				
				<fieldset id="fieldset_table_qbe">
					<legend style="color:#009688"><?= Yii::$service->page->translate->__('Return Record Info')  ?></legend>
					<div>
						<input type="hidden" id="return_admin_record_admin" name="editForm[return_admin_record][admin]" value="<?= Yii::$app->user->identity->username ?>">
                        <label><?= Yii::$service->page->translate->__('Record')  ?>: </label><textarea name="editForm[return_admin_record][record]" style="width:98%;height:100px;"><?= $order['desc'] ?></textarea>
                    </div>
					<?php if(isset($order['return_admin_record'])&&!empty($order['return_admin_record'])){?>
					<div>
						<table summary="Items Ordered" id="my-orders-table" class="data-table list" style="width:100%;table-layout: auto;">
							
							<thead>
								<tr class="first last">
									<th><?= Yii::$service->page->translate->__('Operator')  ?></th>
									<th><?= Yii::$service->page->translate->__('Return Process Status')  ?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Record')  ?></th>
									<th class="a-right"><?= Yii::$service->page->translate->__('Time')  ?></th>
								</tr>
							</thead>
							
							<tbody class="odd">
								<?php $records=json_decode($order['return_admin_record'],true);
								if(is_array($records) && !empty($records)){  ?>
									<?php foreach($records as $record){ ?>
									<tr id="order-item-row" class="border first">	
										<td>
											 <?= $record['admin']?>
											
										</td>
										<td><?= $returnProcessStatusArr[$record['return_process_status']]; ?></td>
									
										<td>
											<?= $record['record']?>
										</td>
										<td><?= date("Y-m-d h:i:s",$record['time']) ?></td>
									</tr>
									<?php } ?>
								<?php } ?>
							</tbody>	

							
						</table>
					</div>
					<?php }?>
				</fieldset>
				
		</div>
	
		<div class="formBar">
			<ul>
				<!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
				<li><div class="buttonActive"><div class="buttonContent"><button onclick="func('accept')"  value="accept" name="accept" type="submit"><?= Yii::$service->page->translate->__('Save')  ?></button></div></div></li>
			
				<li>
					<div class="button"><div class="buttonContent"><button type="button" class="close"><?= Yii::$service->page->translate->__('Cancel')  ?></button></div></div>
				</li>
			</ul>
		</div>
		
		<script>
		    function funcrecord(val){
				//打开记录询问窗，再提交
				layer.prompt({title: '请输入用户名', formType: 2}, function(admin, index){
				  layer.close(index);
				  layer.prompt({title: '请输入操作，并确认', formType: 2}, function(record, index){
					layer.close(index);
					$('#order_admin_record_admin').val(admin);
					$('#order_admin_record_record').val(record);
					$('#order_save').submit();
				  });
				});
				//$('#order_save').submit();
			}
		</script>
	</form>
</div>	

