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
<div class="main container two-columns-left">
	<div class="clear"></div>
    <?= Yii::$service->page->widget->render('base/breadcrumbs',$this); ?>
	<div class="col-main account_center">
		<div class="std">
			<div >
				<div class="my_account_order">
					<div class="order-items order-details ">
						<div>
						<h2 style="float:left" class="table-caption"><?= Yii::$service->page->translate->__('Items Ordered');?><?=  $increment_id ?></h2>
						<h2 style="float:right;     text-transform: none" ><a href="javascript:0" id="checkExchange"><span class="" ><?= Yii::$service->page->translate->__('Reorder all item(s)');?> <br></span></a></h2>
						</div>
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
                                <col>
							</colgroup>
							<thead>
								<tr class="first last ress_tit">
									<th class="a-center"><input lay-skin="primary" lay-filter="items" type="checkbox"/></th>
									<th><?= Yii::$service->page->translate->__('Product Name');?></th>
									<th><?= Yii::$service->page->translate->__('Product Image');?></th>
									<th><?= Yii::$service->page->translate->__('Sku');?></th>
									<th class="a-right"><?= Yii::$service->page->translate->__('Price');?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Qty');?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Subtotal');?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Actions');?></th>
								</tr>
							</thead>
							
							<tbody class="odd">
								<?php if(is_array($products) && !empty($products)):  ?>
									<?php foreach($products as $product): ?>
									<tr id="order-item-row" class="border first">
										<td class="a-center">
											<input lay-skin="primary" name="item" type="checkbox" value="<?= $product['item_id']?>"/>
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
                                        
										
										<td class="a-center last">
											<span class="price-excl-tax">
												<span class="cart-price">
													<span class="price"><?= $currency_symbol ?><?= Format::price($product['row_total']); ?></span>                    
												</span>
											</span>
											<br>
										</td>
										<td class="a-center">
											<a href="#" class="addProductToCart" data-id="<?= $product['product_id'] ?>">
                                                    Reorder 
                                            </a>
                                            
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
	layui.use('form', function(){
		var form = layui.form;
		
		//这里的 menu　就是 HTML上面的lay-filter值，就固定一个值就好
        form.on('checkbox(items)', function(data){
        
          var id = data.value;
          //这里实现勾选 
          $('#my-orders-table input[name=item]').each(function(index, item){
             item.checked = data.elem.checked;
          });
          form.render('checkbox');
          
          // console.log(data.elem); //得到checkbox原始DOM对象
          // console.log(data.elem.checked); //是否被选中，true或者false
          // console.log(data.value); //复选框value值，也可以通过data.elem.value得到
          // console.log(data.othis); //得到美化后的DOM对象
        });  
	});
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
<?php $this->endBlock(); ?>  
</script>  
<?php $this->registerJs($this->blocks['simpleproduct'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>