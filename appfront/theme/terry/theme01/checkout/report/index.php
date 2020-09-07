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
use fec\helpers\CRequest;

$identity=Yii::$app->user->identity;
?>
<div class="main container one-column">
	<div class="col-main col-main_width" >
		<img class="width_150" alt="copy" src="<?=  Yii::$service->apply->getImgUrl('images\/copy.png')?>">
    <?= Yii::$service->page->widget->render('base/flashmessage'); ?>
	<?php if(is_array($cart_info) && !empty($cart_info)):   ?>
			    
		<div class="product_page">
			
			<div class="cart">
				<div class="page-title title-buttons">
					<div class="a-center">
						<h2 class="font_bold_28"><?= Yii::$app->store->get('base_info', 'default_title')['default_title_'.Yii::$service->store->currentLangCode]?></h2>
						<div class="font_16">貨品價格清單</div>
					</div>
				</div>
				<div>
					<div class="shopping-cart-div" class="margin-bottom_20">
					<table id="shopping-cart-table">
						<colgroup>
							<col width="66">
								<col width="26">
								<col width="166">
								<col width="16">
								<col width="106">
                                <col width="106">
                                <col width="26">
								<col width="166">
								<col width="16">
						</colgroup>
						<tbody>
							<tr>
								<td  class="a-left border_none" >
									<?= Yii::$service->page->translate->__('Contact Person');?>
								</td>
								<td  class="a-left border_none" >
									：
								</td>
								<td  class="a-left border_none">
									<span class="price color_black" ><?= $identity['firstname'].' '.$identity['lastname'] ?></span>
								</td>
								<td class="a-left border_none">
									
								</td>
								<td class="a-left border_none">
									
								</td>
								<td  class="a-left border_none" >
									<?= Yii::$service->page->translate->__('Company CN');?>
								</td>
								<td  class="a-left border_none" >
									：
								</td>
								<td  class="a-left border_none">
									<span class="price color_black" ><?= $identity['companycn'] ?></span>
								</td>
								
							</tr>
							<tr>
								<td  class="a-left border_none" >
									<?= Yii::$service->page->translate->__('Contact Tel');?>
								</td>
								<td  class="a-left border_none" >
									：
								</td>
								<td  class="a-left border_none">
									<span class="price color_black" ><?= $identity['contact'] ?></span>
								</td>
								<td class="a-left border_none">
									
								</td>
								<td class="a-left border_none">
									
								</td>
								<td  class="a-left border_none" >
									<?= Yii::$service->page->translate->__('Date');?>
								</td>
								<td  class="a-left border_none" >
									：
								</td>
								<td  class="a-left border_none">
									<span class="price" class="color_black"><?= date("Y-m-d")?></span>
								</td>
							</tr>
						</tbody>
					</table>
					</div>
					<?php if(is_array($cart_info['products']) && (!empty($cart_info['products']))): ?>
								
					<div class="shopping-cart-div">
						<div class="shopping-cart-ab">
						</div>
						<table id="shopping-cart-table" class="data-table cart-table">
							<colgroup>
								<col width="66">
								<col width="106">
								<col width="106">
								<col width="76">
								<col width="76">
								<col width="91">
                                <col width="76">
							</colgroup>
							<thead>
								<tr class="first last">
								    <th rowspan="5"><span class="nobr"><?= Yii::$service->page->translate->__('Sku'); ?></span></th>
									<th rowspan="5"><span class="nobr"><?= Yii::$service->page->translate->__('Product Name');?></span></th>
									<th rowspan="1">&nbsp;</th>
									<th class="a-center" colspan="1"><span class="nobr"><?= Yii::$service->page->translate->__('Unit Price');?></span></th>
									<th rowspan="1" class="a-center"><?= Yii::$service->page->translate->__('Qty');?></th>
									<th class="a-center" colspan="1"><span class="nobr"><?= Yii::$service->page->translate->__('Unit');?></span></th>
									<th class="text_right"  colspan="1"><?= Yii::$service->page->translate->__('Sub Price');?></th>
								</tr>
							</thead>
							<tfoot>
								
							</tfoot>
							<tbody>
								<?php foreach($cart_info['products'] as $product_one): 
									if($product_one['active']!=1){
										continue;
									}
								?>
								
								<tr class="first last odd">
									<td>
										<h2 class="product-name">
											<a href="<?= $product_one['url'] ?>"><?= $product_one['sku'] ?></a>
										</h2>
										
									</td>
									<td>
										<h2 class="product-name">
											<a href="<?= $product_one['url'] ?>"><?= $product_one['name'] ?></a>
										</h2>
										<?php  if(is_array($product_one['custom_option_info'])):  ?>
										<ul>
											<?php foreach($product_one['custom_option_info'] as $label => $val):  ?>
												
												<li><?= Yii::$service->page->translate->__(ucwords($label)).':' ?><?= Yii::$service->page->translate->__($val) ?> </li>
												
											<?php endforeach;  ?>
										</ul>
										<?php endif;  ?>
									</td>
									
									<td>
										<a href="<?= $product_one['url'] ?>" title="<?= $product_one['name'] ?>" class="product-image">
										<img src="<?= Yii::$service->product->image->getResize($product_one['image'],[100,100],false) ?>" alt="<?= $product_one['name'] ?>" width="75" height="75">
										</a>
									</td>
									<td class="a-right">
										<span class="cart-price">
											<span class="price"><?=  $currency_info['code'];  ?><?= Format::price($product_one['product_price']); ?></span>                
										</span>

									</td>

									<td class="a-center">
										<div class="width_20_margin_auto">
											
											<span><?= $product_one['qty']; ?></span>
											
											<div class="clear"></div>
										</div>
									</td>

									<td class="a-center">
										<div class="width_20_margin_auto">
											
											<span><?= $product_one['unit']; ?></span>
											
											<div class="clear"></div>
										</div>
									</td>
									
									<td class="text_right">
										<span class="cart-price">
											<span class="price"><?=  $currency_info['code'];  ?><?= Format::price($product_one['product_row_price']); ?></span>                            
										</span>
									</td>
                                    
                                    
								</tr>
								<?php  endforeach;  ?>
								
							</tbody>
						</table>
					</div>
					<?php  endif;  ?>
				</div>
				
				<div class="cart-collaterals">
					<div class="col2-set">
						<div class="col-1">
						</div>
						<div class="col-2">
							
							
							
						</div>
					</div>
					<div class="totals cart-totals" >
						<div class="process_total">
							<table id="shopping-cart-totals-table">
								<colgroup>
									<col width="76">
									<col width="91">
	                                <col width="76">
								</colgroup>
								
								<tbody>
									<tr>
										<td  class="a-left" colspan="2">
											<?= Yii::$service->page->translate->__('Sub Total');?> : 
                                        </td>
										<td  class="a-right">
											<span class="price">
                                                <?=  $currency_info['code'];  ?><?= Format::price($cart_info['product_total']); ?>
                                            </span>    
                                        </td>
									</tr>
                                   
                                    <tr>
										<td  class="a-left" colspan="2">
											<?= Yii::$service->page->translate->__('Discount');?> :    </td>
										<td  class="a-right">
											<span class="price">-<?=  $currency_info['code'];  ?><?= Format::price($cart_info['coupon_cost']); ?></span>    </td>
									</tr>
								</tbody>
							</table>
							<table id="shopping-cart-totals-table2">
								<colgroup>
									<col>
									<col width="90">
								</colgroup>
								<tbody>
									<tr>
										<td  class="a-left" colspan="2">
											<strong><?= Yii::$service->page->translate->__('Grand Total');?></strong>
										</td>
										<td  class="a-right">
											<strong><span class="price" class="color_black"><?=  $currency_info['code'];  ?><?= Format::price($cart_info['grand_total']) ?></span></strong>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						
					</div>
					<div class="clear"></div>
				</div>
				
			</div>
		</div>
	<?php else: ?>
		<div class="empty_cart">
		<?php
			$param = ['urlB' => '<a rel="nofollow" href="'.Yii::$service->url->getUrl('customer/account/login').'">','urlE' =>'</a>'];
		?>	
		
		<div id="empty_cart_info">
			<?= Yii::$service->page->translate->__('Your Shopping Cart is empty');?>
			<a href="<?= Yii::$service->url->homeUrl(); ?>"><?= Yii::$service->page->translate->__('Start shopping now!');?></a>
			<br>
			<?= Yii::$service->page->translate->__('Please {urlB}log in{urlE} to view the products you have previously added to your Shopping Cart.',$param);?>
		</div>
  
  
		</div>
	<?php  endif; ?>
	
	</div>
	
</div>
<div class="report_copy">
<?=  Yii::$service->cms->staticblock->getStoreContentByIdentify('copy-desc','appfront') ?>
</div>
<?php  // Yii::$service->page->trace->getTraceCartJsCode($trace_cart_info) // 这个改成服务端发送加入购物车数据，而不是js传递的方式 ?>

