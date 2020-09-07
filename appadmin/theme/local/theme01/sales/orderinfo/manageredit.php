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

$orderStatus=Yii::$service->order->getSelectStatusArr();
$orderProcessStatus=Yii::$service->order->getSelectProcessStatusArr();
$credentialsType=Yii::$service->order->credentialsTypeArr();
$paymentConfig=Yii::$service->payment->paymentConfig['standard'][$order['payment_method']];
/** 
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
 
 $areas=Yii::$service->shipping->area;
$countryid=is_numeric($order['customer_address_country'])?$order['customer_address_country']-1:-1;

if(isset($areas[$countryid])){
	
	if($areas[$countryid]['translate']){
		$country = Yii::$service->page->translate->__($areas[$countryid]['translate']);
	}else{
		$country = $areas[$countryid]['name'];
	}
	$stateid=is_numeric($order['customer_address_state'])?$order['customer_address_state']-1:-1;
	
	if(isset($areas[$countryid]['cityList'][$stateid])){
		if($areas[$countryid]['cityList'][$stateid]['translate']){
    		$state = Yii::$service->page->translate->__($areas[$countryid]['cityList'][$stateid]['translate']);
    	}else{
    		$state = $areas[$countryid]['cityList'][$stateid]['name'];
    	}
	}
	$cityid=is_numeric($order['customer_address_city'])?$order['customer_address_city']-1:-1;
	if(isset($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid])){
		if($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['translate']){
    		$city = Yii::$service->page->translate->__($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['translate']);
    	}else{
    		$city = $areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['name'];
    	}
    	$weekday=$areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['weekday'];
	}
}else{

	$country = Yii::$service->helper->country->getCountryNameByKey($order['customer_address_country']);
	$state = Yii::$service->helper->country->getStateByContryCode($order['customer_address_country'],$order['customer_address_state']);
	$city = $order['customer_address_city'];
}

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
			
				<input type="hidden"  value="<?=  $order['order_id']; ?>" size="30" name="editForm[order_id]" class="textInput ">
				
				<fieldset id="fieldset_table_qbe">
					<legend style="color:#009688"><?= Yii::$service->page->translate->__('Order Info')  ?></legend>
					<div>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Increment Id')  ?>：</label>
							<span><?= $order['increment_id'] ?></span>
						</p>
						
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Order Payment Status')  ?>：</label>
							<span><select name="editForm[order_status]"><?= $order['order_payment_status_options'] ?></select></span>
						</p>
						
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Order Status')  ?>：</label>
							<span><select name="editForm[order_process_status]"><?= $order['order_status_options'] ?></select></span>
						</p>

						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Store')  ?>: </label>
							<span>
                                <input type="text" name="editForm[store]" value="<?= $order['store'] ?>" />
                            </span>
						</p>
						
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Item Count')  ?>：</label>
							<span><?= $order['items_count'] ?></span>
						</p>
						
						
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Currency Code')  ?>：</label>
                            <span><?= $order['order_currency_code'] ?></span>
                            <!--
							<span>
                                <select name="editForm[order_currency_code]"><?= $order['order_currency_code_options'] ?></select>
                            </span>
                            -->
						</p>
						<?php $symbol = Yii::$service->page->currency->getSymbol($order['order_currency_code']);  ?>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Rate / Base')  ?>：</label>
							<span><?= $order['order_to_base_rate'] ?></span>
						</p>
						
						<!--
						<p class="edit_p">
							<label>支付类型：</label>
							<span>
                                <select name="editForm[checkout_method]"><?= $order['checkout_method_options'] ?></select>
                            </span>
						</p>
                        -->
                        <p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Checkout Method')  ?>：</label>
							<span><?= $order['checkout_method'] ?></span>
						</p>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Payment Method')  ?>：</label>
							<span><?= Yii::$service->page->translate->__($order['payment_method_label']) ?></span>
						</p>
						
						<?php  if($order['remote_ip']){  ?>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Ip')  ?>：</label>
							<span><?= $order['remote_ip'] ?></span>
						</p>
						<?php  }  ?>
						
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Order Grand Total')  ?>：</label>
							<span><?= $symbol.$order['grand_total'] ?></span>
						</p>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Order Base Grand Total')  ?>：</label>
							<span><?= $order['base_grand_total'] ?></span>
						</p>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Product Subtotal')  ?>：</label>
							<span><?= $symbol.$order['subtotal'] ?></span>
						</p>
						
						<?php  if($order['subtotal_with_discount']){  ?>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Coupon Code')  ?>：</label>
							<span><?= $symbol ?><?= $order['coupon_code'] ? $order['coupon_code'] : '0.00' ?></span>
						</p>
						<?php }  ?>
						
						<?php  if($order['subtotal_with_discount']){  ?>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Discount')  ?>：</label>
							<span><?= $symbol.$order['subtotal_with_discount'] ?></span>
						</p>
						<?php  }  ?>
						
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Shipping Total')  ?>: </label>
							<span><?= $symbol.$order['shipping_total'] ?></span>
						</p>
						
						<?php  if($order['payment_fee'] == 1){  ?>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Payment Fee')  ?>：</label>
							<span><?= $order['payment_fee'] ?></span>
						</p>
						<?php  }  ?>
						<?php if($paymentConfig['credentials'] ):?>
						<p class="edit_p">
						  <label><?= Yii::$service->page->translate->__('Payment Credentials')  ?>：</label>
						  
							<?php if($order['credentials_payment']){?>
							<a alt="credentialsupload" onclick="imgShow(this)"  src="<?=  Yii::$service->url->getUrl('payment/credentialsupload/imageshow',['msg' => $order['credentials_payment']]);?>"> <?= Yii::$service->page->translate->__('Open') ?> </a>
							<?php }else{ ?>
							<?= Yii::$service->page->translate->__('No Upload'); ?>
							<?php } ?>
							
						</p>
						<?php endif;?>
						<?php /**  if(in_array($order['payment_method'],Yii::$service->creditpay->refund->creditpay_payment)  ){  ?>
							<?php  if(in_array($order['credit_refund_status'],Yii::$service->creditpay->refund->creditpay_refund_status_yet) ){  ?>
							<p class="edit_p">
								<label><?= Yii::$service->page->translate->__('Credit Refund')  ?>：</label>
								<span><?= Yii::$service->page->translate->__('Refund Yet')  ?></span>
								
							</p>
							<?php  }  ?>
							<?php  if(in_array($order['credit_refund_status'],Yii::$service->creditpay->refund->creditpay_refund_status_notyet) ){  ?>
							<p class="edit_p">
								<label><?= Yii::$service->page->translate->__('Credit Refund')  ?>：</label>
								<a class="textInput icon creditpayRefundOne" href="javascript:void(0)"  postType="string"   title=""><?= Yii::$service->page->translate->__('Creditpay Refund') ?></a>
								<script>
				
								$(document).ready(function(){
									$(".creditpayRefundOne").click(function(){
										if($(this).hasClass('act')){
											alertMsg.warn('您提交的order已还款！');
											return false;
										}
										alertMsg.confirm("Are You Sure To Refund Creditpay"+"<?php echo $order['increment_id'].',total:'.$order['base_grand_total'];	
										?>", {okCall: function(){
									 url = "<?= $creditpayRefundUrl ?>" ;
									 $.ajax({
										async:true,
										url:url,
										type:"post",//请求的方式
										data:{"order_ids": "<?= $order['order_id'] ?>","refund": "<?= $order['base_grand_total'] ?>", "<?= CRequest::getCsrfName() ?>":"<?= CRequest::getCsrfValue() ?>"},//请求的数据
										success:function (backdata) {//请求成功后返回的数据会封装在回调函数的第一个参数中
										   if(backdata.code==1){
												$('.creditpayRefundOne').addClass('act');
												//通过backdata来获取所需要的数据
												alertMsg.error(backdata.message);
										   }else{
										   		alertMsg.error(backdata.message);
										   }
										},error:function () {//响应不成功时返回的函数
											alertMsg.error("请求失败！")
										},dataType:"json"//设置返回的数据类型
									  });
										},cancelCall : function() {}});
									});
								})
								</script>
							</p>
							<?php  }  ?>
						<?php  }  **/ ?>
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
							<label><?= Yii::$service->page->translate->__('Is Guest')  ?>：</label>
							<span>
                                <select name="editForm[customer_is_guest]"><?= $order['customer_is_guest_options'] ?></select>
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
							<label><?= Yii::$service->page->translate->__('First Name')  ?>: </label>
							<span>
                                <?= $order['customer_firstname'] ?>
                            </span>
                        </p>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Last Name')  ?>: </label>
							<span>
                                <?= $order['customer_lastname'] ?>
                            </span>
                        </p>
						
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Email')  ?>: </label>
							<span>
                                <?= $order['customer_email'] ?>
                            </span>
                            
                        </p>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Shipping Method')  ?>: </label>
							<span><?= $order['shipping_method_label'] ?></span>
						</p>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Shipping Date')  ?>: </label>
							<span>
                                <input type="text" required name="editForm[shipping_date]" value="<?= date("Y-m-d",$order['shipping_date']) ?>" />
                            </span>
						</p>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Shipping Total')  ?>: </label>
							<span><?= $symbol.$order['shipping_total'] ?></span>
						</p>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Tracking Number')  ?>：</label>
                            <span>
                                <input type="text" name="editForm[tracking_number]" value="<?= $order['tracking_number'] ?>" />
                            </span>
						</p>
                        <p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Tracking Company')  ?>：</label>
                            <span>
                                <input type="text" name="editForm[tracking_company]" value="<?= $order['tracking_company'] ?>" />
                            </span>
						</p>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Telephone')  ?>: </label>
							<span>
                                <input type="text" name="editForm[customer_telephone]" value="<?= $order['customer_telephone'] ?>" />
                            </span>
                        </p>
						
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Country')  ?>: </label>
							<span>
								 <?= $country?>
                            </span>
                        </p>
						
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('State')  ?>: </label>
                            <input type="hidden" class="hidden_state" value="<?= $order['customer_address_state']; ?>"  />
                            <span class="state_span">
                            	<?= $state ?>
                            </span>
                        </p>
                       
                        <script>
                            $(document).ready(function(){
                                $(".customer_country").change(function(){
                                    url = '<?= Yii::$service->url->getUrl('sales/orderinfo/getstate')  ?>';
                                    country = $(this).val();
                                    state   = $(".hidden_state").val();
                                    url += '?country='+country+'&state='+state;
                                    //data = {"country":country};
                                    $.ajax({
                                        url:url,
                                        type:'GET',
                                        async:false,
                                        //data:data,
                                        dataType: 'json', 
                                        timeout: 8000,
                                        cache: false,
                                        contentType: false,		//不可缺参数
                                        processData: false,		//不可缺参数
                                        success:function(data, textStatus){
                                            if(data.status == "success"){
                                                content = data.content;
                                                if(content){
                                                    str = '<select class="customer_state" style="width:200px;" name="editForm[customer_address_state]">'+content+'</select>';
                                                }else{
                                                    str = '<input class="customer_state"  type="text" name="editForm[customer_address_state]" value="" />';
                                                }
                                                $(".state_span").html(str); 
                                            }
                                        },
                                        error:function(){
                                            alert('<?= Yii::$service->page->translate->__('Get address state error')  ?>');
                                        }
                                    });
                                    
                                });
                            });
                        
                        </script>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('City')  ?>: </label>
							<span>
                                <?= $city ?>
                            </span>
                        </p>
					
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Street')  ?>: </label>
							<span>
                                <input type="text" name="editForm[customer_address_street1]" value="<?= $order['customer_address_street1'] ?>" />
                            </span>
                        </p>
						<p class="edit_p">
							<label><?= Yii::$service->page->translate->__('Building')  ?>: </label>
							<span>
                                <input type="text" name="editForm[customer_address_street2]" value="<?= $order['customer_address_street2'] ?>" />
                            </span>
                        </p>
						
					</div>
				</fieldset>
				
                <fieldset id="fieldset_table_qbe">
					<legend style="color:#009688"><?= Yii::$service->page->translate->__('Order Customer Remark')  ?></legend>
					<div>
                        <textarea style="width:98%;height:100px;"><?= $order['order_remark'] ?></textarea>
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
											<a href="<?= Yii::$service->url->getUrl($product['redirect_url']) ; ?>">
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
													<span class="price"><?= $symbol ?><?= Format::price($product['row_total']); ?></span>                    
												</span>
											</span>
											<br>
										</td>
									</tr>
									<?php } ?>
								<?php } ?>
							</tbody>	

							<tfoot>
								<tr class="subtotal first">
									<td class="a-right" colspan="5"><?= Yii::$service->page->translate->__('Subtotal')  ?></td>
									<td class="last a-right"><span class="price"><?= $symbol ?><?=  Format::price($order['subtotal']); ?></span></td>
								</tr>
								<tr class="shipping">
									<td class="a-right" colspan="5"><?= Yii::$service->page->translate->__('Shipping Total')  ?></td>
									<td class="last a-right">
										<span class="price"><?= $symbol ?><?=  Format::price($order['shipping_total']); ?></span>    
									</td>
								</tr>
								<tr class="discount">
									<td class="a-right" colspan="5"><?= Yii::$service->page->translate->__('Discount')  ?></td>
									<td class="last a-right">
										<span class="price"><?= $symbol ?><?=  Format::price($order['subtotal_with_discount']); ?></span>    
									</td>
								</tr>
								<tr class="grand_total last">
									<td class="a-right" colspan="5">
										<strong><?= Yii::$service->page->translate->__('Grand Total')  ?></strong>
									</td>
									<td class="last a-right">
										<strong><span class="price"><?= $symbol ?><?=  Format::price($order['grand_total']); ?></span></strong>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</fieldset>
				
				<fieldset id="fieldset_table_qbe">
					<legend style="color:#009688"><?= Yii::$service->page->translate->__('Order Record Info')  ?></legend>
					<div>
						<input type="hidden" id="order_admin_record_admin" name="editForm[order_admin_record][admin]" value="<?= Yii::$app->user->identity->username ?>">
                        <label><?= Yii::$service->page->translate->__('Record')  ?>: </label><textarea name="editForm[order_admin_record][record]" style="width:98%;height:100px;"><?= $order['order_remark'] ?></textarea>
                    </div>
					<?php if(isset($order['order_admin_record'])&&!empty($order['order_admin_record'])){?>
					<div>
						<table summary="Items Ordered" id="my-orders-table" class="data-table list" style="width:100%;table-layout: auto;">
							
							<thead>
								<tr class="first last">
									<th><?= Yii::$service->page->translate->__('Operator')  ?></th>
									<th><?= Yii::$service->page->translate->__('Order Payment Status')  ?></th>
									<th class="a-right"><?= Yii::$service->page->translate->__('Order Status')  ?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Record')  ?></th>
									<th class="a-right"><?= Yii::$service->page->translate->__('Time')  ?></th>
								</tr>
							</thead>
							
							<tbody class="odd">
								<?php $records=json_decode($order['order_admin_record'],true);
								if(is_array($records) && !empty($records)){  ?>
									<?php foreach($records as $record){ ?>
									<tr id="order-item-row" class="border first">	
										<td>
										<?php if($record['type']==1){?>
											 <?= Yii::$service->page->translate->__('Customer')."(".$record['admin'].")"?>
										<?php }elseif($record['type']==3){?>	
											 <?= Yii::$service->page->translate->__('System')?>
									    <?php }else{ ?>
											 <?= Yii::$service->page->translate->__('Administrator')."(".$record['admin'].")" ?>
										<?php } ?>
											
										</td>
										<td><?= Yii::$service->order->getSelectStatusArr()[$record['order_status']]; ?></td>
										<td><?= Yii::$service->order->getSelectProcessStatusArr()[$record['order_process_status']] ?></td>
										
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

