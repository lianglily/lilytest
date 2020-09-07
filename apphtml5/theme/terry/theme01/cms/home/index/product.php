<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<?php $i = 0; ?>
<?php  if(is_array($parentThis['products']) && !empty($parentThis['products'])): 
?>
<input type="hidden" class="product_csrf" name="" value="" />
	<?php foreach($parentThis['products'] as $product): 
	?>
		<?php  if(isset($product['sku']) && $product['sku']): ?> 
            <div class="row flex-end width-90" id="productid_<?= $product['product_id'] ?>">
                <div class="col-50 product_list">
                    <a href="<?= $product['url'] ?>" external>
                        <img alt="<?= $product['name'] ?>" width="100%" src="<?= Yii::$service->image->getImgUrl('images/lazyload.gif'); ?>"  class="lazy" data-src="<?= Yii::$service->product->image->getResize($product['image'],296,false) ?>"  />
                    </a> 
                    
                </div>
				<div class="col-50 product_list">
                    <p class="product_name" >
                        <a href="<?= $product['url'] ?>" external>
                            <?= $product['name'] ?>
                        </a>
                    </p>
                    <p class="color-333" >
                        <?php
                            $diConfig = [
                                'price' 		=> $product['price'],
                                'special_price' => $product['special_price'],
                            ];
                            echo Yii::$service->page->widget->DiRender('home/product_price',$diConfig);
                        ?>
                    </p>
                    
                    <div class="addtocart">
					<?php if(isset($parentThis['qtys'][$product['product_id']]) && $parentThis['qtys'][$product['product_id']]>0 && $product['is_in_stock']==1){?>
						<a external href="javascript:void(0)" id="js_registBtn" data-id="<?= $product['product_id'] ?>" class="button button-fill button-success redBtn addProductToCart">
							<span><i></i><?= Yii::$service->page->translate->__('Add To Cart'); ?></span>
						</a>
					<?php }else{ ?>
						<a external href="javascript:void(0)" id="js_registBtn" class="button button-fill button-success redBtn ">
							<span><i></i><?= Yii::$service->page->translate->__('Out Of Stock'); ?></span>
						</a>
					<?php }?>
	
						<a href="javascript:void(0)" url="<?= Yii::$service->url->getUrl('catalog/favoriteproduct/add'); ?>"  data-id="<?= $product['product_id'] ?>" product_id="<?= $product['product_id'] ?>" id="divMyFavorite" rel="nofollow"  external class="button button-fill button-success redBtn addProductToFavo">
							<span><i></i><?= Yii::$service->page->translate->__('Add to Favorites'); ?></span>
						</a>
						
						<div class="clear"></div>
					</div>
					
                </div>
            <?php $i++; ?>
        </div>    
        <?php endif; ?>
	<?php  endforeach;  ?>
    
	<?php if($i%2 != 0):  ?>
		</div>
	<?php endif; ?>
    
<?php  endif;  ?>
<script>
	// add to cart js	
	<?php $this->beginBlock('add_to_cart1') ?>
	$(document).ready(function(){
		productAjaxUrl = "<?= Yii::$service->url->getUrl('customer/ajax/product');  ?>";
		product_id   = $(".product_view_id").val();
		product_id   = $(".product_view_id").val();
		$.ajax({
			async:true,
			timeout: 6000,
			dataType: 'json',
			type:'get',
			data: {
				// 'currentUrl':window.location.href,
				'product_id':product_id,
				'action':'all'
			},
			url:productAjaxUrl,
			success:function(data, textStatus){
				if(data.favorite.length>0){
					for(var x in data.favorite){
						$('.addProductToFavo').each(function(index){
						  if(data.favorite[x]['product_id']==$(this).attr('product_id')){
								$(this).addClass("active");
						  }
						})
						
						$("#productid_"+data.favorite[x]['product_id']+" #divMyFavorite").addClass("active");
					}
				}
				if(data.csrfName && data.csrfVal && data.product_id){
					$(".product_csrf").attr("name",data.csrfName);
					$(".product_csrf").val(data.csrfVal);
				}
			},
			error:function (XMLHttpRequest, textStatus, errorThrown){}
		});
		$(".row .addProductToCart").click(function(){
			qty = 1;
			csrfName = $(".product_csrf").attr("name");
			csrfVal  = $(".product_csrf").val();
			// ajax 提交数据
			
			addToCartUrl = "<?= Yii::$service->url->getUrl('checkout/cart/add'); ?>";
			$data = {};
			$data['product_id'] 	= $(this).data('id');
			$data['qty'] 			= qty;
			if (csrfName && csrfVal) {
				$data[csrfName] 		= csrfVal;
			}
			$.ajax({
				async:true,
				timeout: 6000,
				dataType: 'json', 
				type:'post',
				data: $data,
				url:addToCartUrl,
				success:function(data, textStatus){ 
					if(data.status == 'success'){
						items_count = data.items_count;
						$("#js_cart_items").html(items_count);
						$.alert("<?= Yii::$service->page->translate->__('Add To Cart Success'); ?>");
					}else{
						content = data.content;
						$(".addProductToCart").removeClass("dataUp");
						$.alert(content);
					}
					
				},
				error:function (XMLHttpRequest, textStatus, errorThrown){}
			});
			
		});
		
	   // product favorite
	   $(".addProductToFavo").click(function(){
			url = $(this).attr('url');
				product_id = $(".product_view_id").val()?$(".product_view_id").val():$(this).data('id');
				csrfName = $(".product_csrf").attr("name");
				csrfVal  = $(".product_csrf").val();
				param = {};
				if($(this).hasClass('active')){
					param["status"] = 0;
				}else{
					param["status"] = 1;
				}
				param["product_id"] = product_id;
				param[csrfName] = csrfVal;
				var that=this;
				//doPost(url, param);
				$.ajax({
					async:true,
					timeout: 6000,
					dataType: 'json', 
					type:'post',
					data: param,
					url:url,
					success:function(data, textStatus){ 
						if(data.status == 'success'){
							if(param["status"]){
								$(that).addClass('active');
							}else{
								$(that).removeClass('active');
							}
							$.alert("<?= Yii::$service->page->translate->__('Success'); ?>");
						}else if(data.status == 'fail'){
							window.location.href="<?= Yii::$service->url->getUrl("customer/account/login") ?>";
						}else{
							content = data.content;
							$.alert(content);
						}
						
					},
					error:function (XMLHttpRequest, textStatus, errorThrown){
						var data=JSON.parse(XMLHttpRequest.responseText);
						if(data.status == 'success'){
							$.alert("<?= Yii::$service->page->translate->__('Success'); ?>");
						}else if(data.status == 'fail'){
							window.location.href="<?= Yii::$service->url->getUrl("customer/account/login") ?>";
						}else{
							content = data.content;
							$.alert(content);
						}
						
					}
				});
			
	   });
	   // 改变个数的时候，价格随之变动
	   $(".qty").blur(function(){
			// 如果全部选择完成，需要到ajax请求，得到最后的价格
			i = 1;
			$(".product_custom_options .pg .rg ul.required").each(function(){
				val = $(this).find("li.current a.current").attr("value");
				attr  = $(this).find("li.current a.current").attr("attr");
				if(!val){
				   i = 0;
				}
			});
			if(i){
				getCOUrl = "<?= Yii::$service->url->getUrl('catalog/product/getcoprice'); ?>";
				product_id = $(".product_view_id").val();		
				qty = $(".qty").val();
				custom_option_sku = '';
				for(x in custom_option_arr){
					one = custom_option_arr[x];	
					j = 1;
					$(".product_custom_options .pg .rg ul.required").each(function(){
						val = $(this).find("li.current a.current").attr("value");
						attr  = $(this).find("li.current a.current").attr("attr");
						if(one[attr] != val){
							j = 0;
							//break;
						}
					});
					if(j){
						custom_option_sku = one['sku'];
						break;
					}
				}
				$data = {
					custom_option_sku:custom_option_sku,
					qty:qty,
					product_id:product_id
				};
				$.ajax({
					async:true,
					timeout: 6000,
					dataType: 'json', 
					type:'get',
					data: $data,
					url:getCOUrl,
					success:function(data, textStatus){ 
						$(".price_info").html(data.price);
					},
					error:function (XMLHttpRequest, textStatus, errorThrown){}
				});
			}
		});
        
	});
    $.init(); 
	<?php $this->endBlock(); ?> 
	<?php $this->registerJs($this->blocks['add_to_cart1'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>
</script> 
