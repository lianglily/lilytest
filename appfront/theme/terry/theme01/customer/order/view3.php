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

$refundVaildPaymentStatusArr=Yii::$service->returnexchange->getRefundVaildPaymentStatusArr();
$refundVaildProcessStatusArr=Yii::$service->returnexchange->getRefundVaildProcessStatusArr();
$orderStatus=Yii::$service->order->getSelectStatusArr();
$orderProcessStatus=Yii::$service->order->getSelectProcessStatusArr();
?>
<style>
.label_info{
	padding: 4px;
    width: 120px;
    font-size: smaller;
    line-height: 20px;
    text-align: right;
    display: inline-grid;
}
</style>
<div class="main container two-columns-left">
	<div class="clear"></div>
    <?= Yii::$service->page->widget->render('base/breadcrumbs',$this); ?>
	<div class="col-main account_center">
		<div class="std">
			<div >
				<div class="my_account_order">
					<div class="page-title title-buttons">
						<h1><?= Yii::$service->page->translate->__('Order #');?><?=  $increment_id ?>											</h1>
					</div>
					
					<div class="col2-set order-info-box">
						<div class="col-1">
							<div class="box">
                                <div class="box-content">
                                    <address>
                                    	<label class="label_info"><?= Yii::$service->page->translate->__('Order Date');?>：</label><label style="text-align: left;" class="label_info"><?=  date('Y-m-d',$created_at); ?></label><br>
                                		<label class="label_info"><?= Yii::$service->page->translate->__('Shipping Date');?>：</label><label style="text-align: left;" class="label_info"><?=  date('Y-m-d',$shipping_date); ?></label><br>
                                		<label class="label_info"><?= Yii::$service->page->translate->__('Order Total');?>：</label><label style="text-align: left;" class="label_info"><?= $currency_symbol ?><?=  Format::price($grand_total); ?></label><br>
                                		<label class="label_info"><?= Yii::$service->page->translate->__('Payment Method');?>：</label><label style="text-align: left;" class="label_info"><?=  Yii::$service->page->translate->__(Yii::$service->payment->paymentConfig['standard'][$payment_method]['label']) ?></label><br>
                                		<label class="label_info"><?= Yii::$service->page->translate->__('Payment Status');?>：</label><label style="text-align: left;" class="label_info"><?= Yii::$service->order->getSelectStatusArr()[$order_status] ;?></label><br>
                                		<label class="label_info"><?= Yii::$service->page->translate->__('Order Status');?>：</label><label style="text-align: left;" class="label_info"><?= Yii::$service->order->getSelectProcessStatusArr()[$order_process_status] ;?></label><br>
                                    </address>
                                </div>
                            </div>				
                        </div>
						<div class="col-2">
							<div class="box">
                                <div class="box-title">
                                    <h2><?= Yii::$service->page->translate->__('Shipping Address');?></h2>
                                </div>
                                <div class="box-content">
                                    <address><?=  $customer_firstname ?> <?=  $customer_lastname ?><br>
                                    <?=  $customer_address_street1 ?> <?=  $customer_address_street2 ?><br><?=  $customer_address_city_name ?>,<?=  $customer_address_state_name ?>,<?=  $customer_address_country_name ?><br>
                                    <?= Yii::$service->page->translate->__('Tel:');?><?=  $customer_telephone ?>
                                  
                                    </address>
                                </div>
                            </div>				
                        </div>
						
					</div>
					
					<div class="order-items order-details ">
						<div>
						<h2 style="float:left" class="table-caption"><?= Yii::$service->page->translate->__('Items Ordered');?></h2>
						<h2 style="float:right;     text-transform: none;padding-left:10px" ><a href="<?=  Yii::$service->url->getUrl('customer/order/reorder',['order_id' => $order_id]);?>"><span class="" ><?= Yii::$service->page->translate->__('Reorder all item(s)');?> <br></span></a></h2>
						<h2 style="float:right;     text-transform: none" ><a href="javascript:0" id="checkExchange"><span class="" ><?= Yii::$service->page->translate->__('Return / Exchange');?> <br></span></a></h2>
						</div>
						<table summary="Items Ordered" id="my-orders-table" class="data-table layui-form">
							<colgroup>
                                <col>
                                <col width="1">
                                <col width="1">
                                <col width="1">
                                <col width="1">
							</colgroup>
							<thead>
								<tr class="first last">
									<th class="a-center"><input lay-skin="primary" lay-filter="items" type="checkbox"/></th>
									<th><?= Yii::$service->page->translate->__('Product Name');?></th>
									<th><?= Yii::$service->page->translate->__('Product Image');?></th>
									<th><?= Yii::$service->page->translate->__('Sku');?></th>
									<th class="a-right"><?= Yii::$service->page->translate->__('Price');?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Qty');?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Sales Return');?></th>
                                    <th class="a-center"><?= Yii::$service->page->translate->__('Review');?></th>
                                    <th class="a-center"><?= Yii::$service->page->translate->__('Reorder');?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Subtotal');?></th>
								</tr>
							</thead>
							<tfoot>
								<tr class="subtotal first">
									<td class="a-right" colspan="9"><?= Yii::$service->page->translate->__('Subtotal');?></td>
									<td class="last a-center"><span class="price"><?= $currency_symbol ?><?=  Format::price($subtotal); ?></span></td>
								</tr>
								<tr class="shipping">
									<td class="a-right" colspan="9"><?= Yii::$service->page->translate->__('Shipping Cost');?></td>
									<td class="last a-center">
										<span class="price"><?= $currency_symbol ?><?=  Format::price($shipping_total); ?></span>    
									</td>
								</tr>
								<tr class="discount">
									<td class="a-right" colspan="9"><?= Yii::$service->page->translate->__('Discount');?></td>
									<td class="last a-center">
										<span class="price"><?= $currency_symbol ?><?=  Format::price($subtotal_with_discount); ?></span>    
									</td>
								</tr>
								<tr class="grand_total last">
									<td class="a-right" colspan="9">
										<strong><?= Yii::$service->page->translate->__('Grand Total');?></strong>
									</td>
									<td class="last a-center">
										<strong><span class="price"><?= $currency_symbol ?><?=  Format::price($grand_total); ?></span></strong>
									</td>
								</tr>
							</tfoot>
							<tbody class="odd">
								<?php if(is_array($products) && !empty($products)):  ?>
									<?php foreach($products as $product): ?>
									<tr id="order-item-row" class="border first">	
										<td class="a-center">
											
											<?php
											  if(in_array($order_status,$refundVaildPaymentStatusArr)&&in_array($order_process_status,$refundVaildProcessStatusArr)){
                                                if($product['retuan_status']==1){ ?>
                                                	<input lay-skin="primary" name="item" type="checkbox" value="<?= $product['item_id']?>"/>
                                                <?php }else{?>
                                                	<input lay-skin="primary" name="item" type="checkbox" disabled value="<?= $product['item_id']?>"/>
                                                <?php } 
                                               }else{ ?>
                                            		<input lay-skin="primary" name="item" type="checkbox" disabled value="<?= $product['item_id']?>"/>
                                              <?php }?>
										</td>
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
											<span class="nobr" >
                                                <strong>
                                                <?php
                                                
                                                if($product['retuan_status']==1){ ?>
                                                	<?= Yii::$service->page->translate->__('Return / Exchange');?>
                                                <?php }elseif($product['retuan_status']==2){?>
                                                	<?= Yii::$service->page->translate->__('Return');?><a href="<?= Yii::$service->url->getUrl('/returnexchange/returns/view',['return_unique_id' => $product['return_unique_id']])  ?>" >
												<?= $product['return_unique_id'];?>
											</a>
                                                <?php }elseif($product['retuan_status']==3){?>
                                                	<?= Yii::$service->page->translate->__('Return');?><a href="<?= Yii::$service->url->getUrl('/returnexchange/returns/view',['return_unique_id' => $product['return_unique_id']])  ?>" >
												<?= $product['return_unique_id'];?>
											</a>
                                                <?php }elseif($product['retuan_status']==4){?>
                                                	<?= Yii::$service->page->translate->__('Exchange');?><a href="<?= Yii::$service->url->getUrl('/returnexchange/returns/view',['return_unique_id' => $product['return_unique_id']])  ?>" >
												<?= $product['return_unique_id'];?>
											</a>
                                                <?php } ?>
                                                </strong>
                                                <br>
											</span>
										</td>
                                        <td class="a-center">
											<a  href="<?= Yii::$service->url->getUrl('/catalog/reviewproduct/add',['_id' => $product['product_id']])  ?>">
                                                <span class="" >
                                                     <?= Yii::$service->page->translate->__('Review');?>
                                                    <br>
                                                </span>
                                            </a>
										</td>
										<td class="a-center">
											<a href="#" class="addProductToCart" data-id="<?= $product['product_id'] ?>">
                                                
                                                     <?= Yii::$service->page->translate->__('Reorder');?>
                                                   
                                            </a>
                                            
										</td>
										<td class="a-center last">
											<span class="price-excl-tax">
												<span class="cart-price">
													<span class="price"><?= $currency_symbol ?><?= Format::price($product['row_total']); ?></span>                    
												</span>
											</span>
											<br>
										</td>
									</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>								   
						</table>
						<br/>
						<div class="buttons-set">
							<p class="back-link"><a href="<?= Yii::$service->url->getUrl('customer/order/index'); ?>"><small> « </small><?= Yii::$service->page->translate->__('Back to My Orders');?></a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
		<?= Yii::$service->page->widget->render('customer/left_menu', $this); ?>

	<div class="clear"></div>
</div>
<script>
<?php $this->beginBlock('simpleproduct') ?>  
$(document).ready(function(){
	layui.use('layer', function(){
		var layer = layui.layer;
		var form = layui.form;
		
		//这里的 menu　就是 HTML上面的lay-filter值，就固定一个值就好
        form.on('checkbox(items)', function(data){
        
          var id = data.value;
          //这里实现勾选 
          $('#my-orders-table input[name=item]').each(function(index, item){
          	if(!item.disabled){
             item.checked = data.elem.checked;
          	}
          });
          form.render('checkbox');
          
          // console.log(data.elem); //得到checkbox原始DOM对象
          // console.log(data.elem.checked); //是否被选中，true或者false
          // console.log(data.value); //复选框value值，也可以通过data.elem.value得到
          // console.log(data.othis); //得到美化后的DOM对象
        });
		$('.addProductToCart').click(function(){
		    var product_id=$(this).data('id');
			layer.open({
			  area:['80vw', '80vh'],
			  type: 2,
			  title:$(this).data('name'),
			  content: "<?=  Yii::$service->url->getUrl('catalog/productsimple/index'); ?>?id="+product_id,
			  resizing: function(layero){
				  
				  $(layero).children('div').eq(1).children('iframe').eq(0).height($(layero).height()-43);
				},
			  full: function(layero){
				  
				  $(layero).children('div').eq(1).children('iframe').eq(0).height($(layero).height()-43);
				},
			  restore: function(layero){
				  
				  $(layero).children('div').eq(1).children('iframe').eq(0).height($(layero).height()-43);
				},
			});
		});
		//通过选中多个商品进行退换货
		$('#checkExchange').click(function(){
			  // 获取选中的分类值
			  var check_arr = [];
			  $('#my-orders-table input[name=item]:checked').each(function(){
			      check_arr.push($(this).val());
			  });
			   if(check_arr.length == 0){
			     layer.msg("<?= Yii::$service->page->translate->__('You have add at least one item'); ?>", {icon: 7, time:1500});return;
			   }
			   $csrf_val=$('.csrf').val();
			   $csrf_name=$('.csrf').attr("name");
			   url = "<?= Yii::$service->url->getUrl('returnexchange/info/salesreturn'); ?>";
					layer.open({
					  type: 2, 
					  area:['80vw','80vh'],
					  content: url+"?items="+check_arr.join(',')+"&"+$csrf_name+"="+$csrf_val //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
					}); 
					
		});
	});
});
<?php $this->endBlock(); ?>  
</script>  
<?php $this->registerJs($this->blocks['simpleproduct'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>