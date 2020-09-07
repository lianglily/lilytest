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
use fecshop\app\apphtml5\helper\Format;

$refundVaildPaymentStatusArr=Yii::$service->returnexchange->getRefundVaildPaymentStatusArr();
$refundVaildProcessStatusArr=Yii::$service->returnexchange->getRefundVaildProcessStatusArr();
$orderStatus=Yii::$service->order->getSelectStatusArr();
$orderProcessStatus=Yii::$service->order->getSelectProcessStatusArr();
$credentialsType=Yii::$service->order->credentialsTypeArr();
$paymentConfig=Yii::$service->payment->paymentConfig['standard'][$payment_method];
?>
<style>
#fileToUpload{
	width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}
.upload{
	padding: 5px;
    border: 1px solid #4c6b99;
    border-radius: 5px;
    color: #4c6b99;
}

</style>
<div class="account-ds">
	<div class="bar bar-nav account-top-m">
		<a external class="button button-link button-nav pull-left" href="<?= Yii::$service->url->getUrl('customer/order/index'); ?>">
			<span class="icon icon-left"></span>
		</a>
		<h1 class='title'><?= Yii::$service->page->translate->__('View Order'); ?></h1>
	</div>
</div>
<?= Yii::$service->page->widget->render('base/flashmessage'); ?>


<div class="account-container">
	<div class="col-main account_center">
		<div class="std">
			<div class="margin-2" >
				<div class="my_account_order">
					<table class="page-title title-buttons">
						<tbody>
							<tr><td><?= Yii::$service->page->translate->__('Order#');?> :</td><td><?=  $increment_id ?>	</td></tr>		
							<tr><td><?= Yii::$service->page->translate->__('Payment Status');?>:</td><td><?= Yii::$service->order->getSelectStatusArr()[$order_status];?></td></tr>
							<tr><td><?= Yii::$service->page->translate->__('Order Status');?>:</td><td><?= Yii::$service->order->getSelectProcessStatusArr()[$order_process_status];?></td></tr>
							<tr><td><?= Yii::$service->page->translate->__('Order Date');?>:</td><td><?=  date('Y-m-d',$created_at); ?></td></tr>	
							<tr><td><?= Yii::$service->page->translate->__('Shipping Date');?>:</td><td><?=  date('Y-m-d',$shipping_date); ?></td></tr>
						</tbody>
					</table>
					<div class="col2-set order-info-box">
						<div class="col-1">
							<div class="box">
							<div class="box-title">
								<h5><?= Yii::$service->page->translate->__('Shipping Address');?>:</h5>
							</div>
							<div class="box-content">
								<table>
									<tbody>
										<tr><td><?=  $customer_firstname ?> <?=  $customer_lastname ?></td></tr>	
										<tr><td><?=  $customer_address_street1 ?><br><?=  $customer_address_street2 ?></td></tr>	
										<tr><td><?=  $customer_address_city_name ?>,<?=  $customer_address_state_name ?>,<?=  $customer_address_country_name ?></td></tr>	
										<tr><td><?= Yii::$service->page->translate->__('T:');?><?=  $customer_telephone ?></td></tr>	

									</tbody>
								</table>
							</div>
						</div>				</div>
						
                        
						<div class="col-2">
							<div class="box box-payment">
								<div class="box-title">
									<h5><?= Yii::$service->page->translate->__('Payment Method');?>:</h5>
								</div>
								<div class="box-content">
									<table>
										<tbody>
											<tr><td><?=  Yii::$service->page->translate->__(Yii::$service->payment->paymentConfig['standard'][$payment_method]['label']) ?></td></tr>  
										</tbody>
									</table>
								</div>
							</div>			
						</div>
						<?php if(in_array($order_status,$credentialsType) &&$paymentConfig['credentials'] ):?>
						<div class="col-2">
							<div class="box box-payment">
								<div class="box-title">
									<input type="file" id="fileToUpload"  class="fileToUpload" accept="image/*"  onchange="fileSelected();"><label  class="icon icon-download upload" for="fileToUpload"> <?= Yii::$service->page->translate->__('Upload Credentials');?></label><span id="progressNumber"></span> 
								</div>
								<div class="box-content">
									<table>
										<tbody>
											<tr><td>
												<?php if($credentials_payment){?>
											    <img class="layui-upload-img img-100-100" id="demo1"  src="<?=  Yii::$service->url->getUrl('checkout/credentialsupload/imageshow',['msg' => $credentials_payment]);?>">
											    <?php }else{ ?>
											    <img class="layui-upload-img" id="demo1" >
											    <?php } ?>
									    	</td></tr>  
										</tbody>
									</table>
								</div>
							</div>			
						</div>
						<?php endif;?>
					</div>
					
					<div class="order-items order-details box-title">
						<h5 class="table-caption"><?= Yii::$service->page->translate->__('Items Ordered');?>:</h5>

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
									<th><?= Yii::$service->page->translate->__('Product Image');?></th>
									<th><?= Yii::$service->page->translate->__('Product Info');?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Qty');?></th>
                                    <th class="a-center"><?= Yii::$service->page->translate->__('Review');?></th>
									<th class="a-right"><?= Yii::$service->page->translate->__('Subtotal');?></th>
								</tr>
							</thead>
							<tfoot>
								<tr class="subtotal first">
									<td class="a-right" colspan="4"><?= Yii::$service->page->translate->__('Subtotal');?></td>
									<td class="last a-center"><span class="price"><?= $order_currency_code ?><?=  Format::price($subtotal); ?></span></td>
								</tr>
								<tr class="shipping">
									<td class="a-right" colspan="4"><?= Yii::$service->page->translate->__('Shipping Cost');?></td>
									<td class="last a-center">
										<span class="price"><?= $order_currency_code ?><?=  Format::price($shipping_total); ?></span>    
									</td>
								</tr>
								<tr class="discount">
									<td class="a-right" colspan="4"><?= Yii::$service->page->translate->__('Discount');?></td>
									<td class="last a-center">
										<span class="price"><?= $order_currency_code ?><?=  Format::price($subtotal_with_discount); ?></span>    
									</td>
								</tr>
								<tr class="grand_total last">
									<td class="a-center" colspan="4">
										<strong><?= Yii::$service->page->translate->__('Grand Total');?></strong>
									</td>
									<td class="last a-right">
										<strong><span class="price"><?= $order_currency_code ?><?=  Format::price($grand_total); ?></span></strong>
									</td>
								</tr>
							</tfoot>
							<tbody class="odd">
								<?php if(is_array($products) && !empty($products)):  ?>
									<?php foreach($products as $product): ?>
									<tr id="order-item-row" class="border first">	
										<td>
											<a href="<?=  Yii::$service->url->getUrl($product['redirect_url']) ; ?>">
												<img src="<?= Yii::$service->product->image->getResize($product['image'],[100,100],false) ?>" alt="<?= $product['name'] ?>" width="75" height="75">
											</a>
										</td>
										<td>
											<div><?= Yii::$service->page->translate->__('sku')?>:<?= $product['sku'] ?></div>
											<?php  if(is_array($product['custom_option_info'])):  ?>
											
												<?php foreach($product['custom_option_info'] as $label => $val):  ?>
													<div>
														<?= Yii::$service->page->translate->__($label.':') ?><?= Yii::$service->page->translate->__($val) ?>
													</div>
												<?php endforeach;  ?>
											
											<?php endif;  ?>
											
											<dl class="item-options">
											</dl>
										</td>
										
										<td class="a-center">
											<span class="nobr" ><strong><?= $product['qty'] ?></strong><br>
											</span>
										</td>
                                        <td class="a-center">
											<a class="a-center-text" href="<?= Yii::$service->url->getUrl('/catalog/reviewproduct/add',['_id' => $product['product_id']])  ?>">
                                                <span class="" >
                                                    Review 
                                                    <br>
                                                </span>
                                            </a>
										</td>
										<td class="a-right last">
											<span class="price-excl-tax">
												<span class="cart-price">
													<span class="price"><?= $order_currency_code ?><?= Format::price($product['row_total']); ?></span>                    
												</span>
											</span>
											<br>
										</td>
									</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>								   
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="clear"></div>
</div>
<script>
function fileSelected() {
    var file = document.getElementById('fileToUpload').files[0];
    if (file) {
    	//判断size
    	if (file.size > 1024 * 1024* 2){
    		$.alert("out of size");
    		return false;
    	}
    	var img=document.getElementById('demo1');
    	reader = new FileReader();
    	reader.onload = function (ev) {
            img.src = ev.target.result;
        }
        reader.readAsDataURL(file);
    	console.log(file.name,file.size,file.type);
        uploadFile();
    }
    
}

function uploadFile() {
    var fd = new FormData();
    fd.append("fileToUpload", document.getElementById('fileToUpload').files[0]);
    var xhr = new XMLHttpRequest();
    xhr.upload.addEventListener("progress", uploadProgress, false);
    xhr.addEventListener("load", uploadComplete, false);
    xhr.addEventListener("error", uploadFailed, false);
    xhr.addEventListener("abort", uploadCanceled, false);
    xhr.open("POST", "<?=  Yii::$service->url->getUrl('checkout/credentialsupload/imageupload',['order_id' => $increment_id]);?>"); //修改成自己的接口
    xhr.send(fd);
}

function uploadProgress(evt) {
    if (evt.lengthComputable) {
        var percentComplete = Math.round(evt.loaded * 100 / evt.total);
        document.getElementById('progressNumber').innerHTML = percentComplete.toString() + '%';
    } else {
        document.getElementById('progressNumber').innerHTML = 'unable to compute';
    }
}

function uploadComplete(evt) {
    /* 服务器端返回响应时候触发event事件*/
    var data =JSON.parse(evt.target.responseText);
    if(data.err==0){
    	$.alert('Upload Success');
    }else{
    	$.alert('Upload Fail');
    }
}

function uploadFailed(evt) {
    $.alert("There was an error attempting to upload the file.");
}

function uploadCanceled(evt) {
    $.alert("The upload has been canceled by the user or the browser dropped the connection.");
}
</script> 