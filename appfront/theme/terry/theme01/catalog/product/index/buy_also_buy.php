<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<?php  if(is_array($parentThis['products']) && !empty($parentThis['products'])):  $mode= isset($parentThis['mode'])?$parentThis['mode']:true; ?>
<div class="buy_also_buy" >
	<div class="scroll_left">
		<a href=""><?= Yii::$service->page->translate->__('Customers Who Bought This Item Also Bought'); ?></a>
	</div>
	<div class="scrollBox">	
		<div class="viewport scrollBox_position" >
			<div id="owl-buy-also-buy" class="owl-carousel">	
				<?php foreach($parentThis['products'] as $product): ?>
					<div class="item">
						<p class="tc pro_img" >
							<a class="i_proImg i_proImg_margin" href="<?= $product['url'] ?>">
								<img style="i_proImg_img" alt="<?= $product['name'] ?>" class="lazyOwl" data-src="<?= Yii::$service->product->image->getResize($product['image'],[180,200],false) ?>"  src="<?= Yii::$service->image->getImgUrl('appfront/images/lazyload1.gif') ; ?>">
							</a>
						</p>
						
						<p class="proName proName_align" >
							<a href="<?= $product['url'] ?>">
								<?= $product['name'] ?>
							</a>
						</p>
					
						<?php
							$config = [
								'class' 		=> 'fecshop\app\appfront\modules\Catalog\block\category\Price',
								'view'  		=> 'cms/home/index/price.php',
								'price' 		=> $product['price'],
								'special_price' => $product['special_price'],
							];
							echo Yii::$service->page->widget->renderContent('category_product_price',$config);
						?>
						
						<div class="addtocart addtocart_margin" >
									
							<button  type="button" id="js_registBtn" data-name="<?= $product['name'] ?>" data-id="<?= $product['_id'] ?>" class="redBtn addProductToCartsimple"><em><span><i></i><?= Yii::$service->page->translate->__('Add To Cart'); ?></span></em></button>
							
							
							<div class="clear"></div>
						</div>
								
					</div>
				<?php  endforeach;  ?>
			</div>
		</div>
	</div>
</div>
 
<script>
<?php $this->beginBlock('owl_fecshop_slider') ?>  
$(document).ready(function(){
	$("#owl-buy-also-buy").owlCarousel({
		items : 6,
		lazyLoad : true,
		navigation : true,
		scrollPerPage : true,
		pagination:false,
		itemsCustom : false,
        slideSpeed : 900
	});
	$('.addProductToCartsimple').click(function(){
		var product_id=$(this).data('id');
		<?php if($mode){?>
			
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
		<?php }else { ?>
			window.location.href="<?=  Yii::$service->url->getUrl('catalog/productsimple/index'); ?>?id="+product_id;
		<?php } ?>
		//parent.layer.close(parent.layer.getFrameIndex(window.name));
	});
});
<?php $this->endBlock(); ?>  
</script>  
<?php $this->registerJs($this->blocks['owl_fecshop_slider'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>
<?php  endif;  ?>

