<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

?>
<div class="product_page">
	<div class="product_view">
		<input type="hidden" class="product_view_id" value="<?=  $_id ?>">
		<input type="hidden" class="sku" value="<?= $sku; ?>" />
		<input type="hidden" class="product_csrf" name="" value="" />
		<div class="media_img">
			<div class="media_img_content">
				<?php # 图片部分。
					$imageParam = [
                        'media_size' => $media_size,
                        'image' => $image_thumbnails,
                    ];
				?>
				<?= Yii::$service->page->widget->render('product/image',$imageParam); ?>
			</div>
		</div>
		<div class="product_info">
			<h1><?= $name; ?></h1>
			<div>
				<div class="rbc_cold">
					<span>
						<span class="average_rating"><?= Yii::$service->page->translate->__('Average rating'); ?> :</span>
						<span class="review_star review_star_<?= round($reviw_rate_star_average) ?>" style="font-weight:bold;" itemprop="average"></span>
                        
						<a external rel="nofollow" href="<?= Yii::$service->url->getUrl('catalog/reviewproduct/lists',['spu'=>$spu,'_id'=>$_id]); ?>">
							(<span itemprop="count"><?= $review_count ?> <?= Yii::$service->page->translate->__('reviews'); ?></span>)
						</a>
					</span>
				</div>
				<div class="clear"></div>
				<div class="item_code">
					<?= Yii::$service->page->translate->__('Item Code:'); ?>
					<span class="item_sku"><?= $sku; ?></span>
				</div>
				<div class="clear"></div>
			</div>
			<div class="price_info">
                <?= Yii::$service->page->widget->render('product/price', ['price_info' => $price_info]); ?>
			</div>
			<div class="product_info_section" id="product_info_section">
				<div class="product_options">
					<?= Yii::$service->page->widget->render('product/options', ['options' => $options]); ?>
				</div>
				<div class="product_custom_options">
					
				</div>
				<div class="product_qty pg">
					<div class="label"><?= Yii::$service->page->translate->__('Qty:'); ?></div>
					<div class="rg">
						<input onkeyup="keyUp(this)" onkeypress="keyPress(this)" onblur="keyBlur(this)" t_value="1" type="text" name="qty" class="qty" value="1" />
                        <?php if ($package_number >= 2) { ?>
                            X <?= $package_number ?> items
                        <?php } ?>
                        <?php if(isset($unit)&&!empty($unit)){
                        	$unit_text='';
                        ?>
                        
					      <select name="unit" id="unit" lay-verify="required">
					      	<?php foreach($unit as $val){?>
					      	<?php if($val['unit_base']==1){
					      		$default=$val['unit_code'];
					      	?>
					        <option value="<?= $val['unit_rate']?>" selected><?= Yii::$service->page->translate->__($val['unit_code']) ?></option>
					        <?php }else{
					        	$unit_text.= "1{$val['unit_code']} = {$val['unit_rate']}$default ";
					        ?>
					        <option value="<?= $val['unit_rate']?>" ><?= Yii::$service->page->translate->__($val['unit_code']) ?></option>
					        <?php } ?>
					        <?php } ?>
					      </select>
					      <span><?= $unit_text ?> </span>
					    
                        <?php }?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="tier_price_info">
					<?= Yii::$service->page->widget->render('product/tier_price', ['tier_price' => $tier_price]); ?>
				</div>
				<div class="addtocart">
				<?php if(isset($qtys[$_id])&&$qtys[$_id]>0 &&$is_in_stock==1){?>
					<a external href="javascript:void(0)" id="js_registBtn" class="button button-fill button-success redBtn addProductToCart">
						<span><i></i><?= Yii::$service->page->translate->__('Add To Cart'); ?></span>
					</a>
				<?php }else{ ?>
					<a  href="javascript:void(0)" id="js_registBtn" class="button button-fill button-success redBtn">
						<span><i></i><?= Yii::$service->page->translate->__('Out Of Stock'); ?></span>
					</a>
				<?php }?>
					<a href="javascript:void(0)" url="<?= Yii::$service->url->getUrl('catalog/favoriteproduct/add'); ?>"  product_id="<?= $_id?>" id="divMyFavorite" rel="nofollow"  external class="button button-fill button-success redBtn addProductToFavo">
						<span><i></i><?= Yii::$service->page->translate->__('Add to Favorites'); ?></span>
					</a>
					
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="product_description_info">
		<div class="buttons-tab">
			<a href="#tab1" class="tab-link active button"><?= Yii::$service->page->translate->__('Description'); ?></a>
			<a href="#tab2" class="tab-link button"><?= Yii::$service->page->translate->__('Reviews'); ?></a>
			<!-- <a href="#tab3" class="tab-link button"><?= Yii::$service->page->translate->__('Shipping & Payment'); ?></a> -->
		</div>
		<div class="content-block">
			<div class="tabs">
			  <div id="tab1" class="tab active">
				<div class="content-block">
					<div class="text-description" >
                        <?php if(is_array($groupAttrArr)): ?>
                            <table>
                            <?php foreach($groupAttrArr as $k => $v): ?>
                                <tr>
                                    <td><?= Yii::$service->page->translate->__($k); ?></td>
                                    <td><?= Yii::$service->page->translate->__($v); ?></td></tr>
                            <?php endforeach; ?>
                            </table>
                            <br/>
                        <?php endif; ?>
						<?= $description; ?>
                        <div class="img-section">
                            <?php   if(is_array($image_detail)):  ?>
                                <?php foreach($image_detail as $image_detail_one): ?>
                                    <br/>
                                    <img alt="<?= $image_detail_one['image'] ?>" class="lazy" src="<?= Yii::$service->image->getImgUrl('images/lazyload.gif');   ?>" data-src="<?= Yii::$service->product->image->getUrl($image_detail_one['image']); //->getResize($image_detail_one['image'],550,false) ?>"  />
                                    
                                <?php  endforeach;  ?>
                            <?php  endif;  ?>
                        </div>
					</div>  
				</div>
			  </div>
			  <div id="tab2" class="tab">
				<div class="content-block">
					<div class="text-reviews" id="text-reviews" >
						<?php # review部分。
							$reviewParam = [
								'product_id' 	=> $_id,
								'spu'			=> $spu,
                            ];
							$reviewParam['reviw_rate_star_info'] = $reviw_rate_star_info;
                           $reviewParam['review_count'] = $review_count;
                           $reviewParam['reviw_rate_star_average'] = $reviw_rate_star_average;
						?>
						<?= Yii::$service->page->widget->DiRender('product/review', $reviewParam); ?>
					</div> 
				</div>
			  </div>
			  <!-- <div id="tab3" class="tab">
				<div class="content-block">
					<div class="text-questions" >
						<?= Yii::$service->page->widget->render('product/payment'); ?>
					
					</div>  
				</div>
			  </div> -->
			</div>
		</div>
	</div>
	<div class="buy_also_buy_cer">
        <?= Yii::$service->page->widget->render('product/buy_also_buy', ['products' => $buy_also_buy]); ?>
	</div>
</div>
<script>
	function keyPress(ob) {
	
		var reg=/^[1-9]{1}[0-9]*$/;
		var val=ob.value;
		if(val){
			if(reg.test(val)){
				ob.t_value = ob.value;
			}else{
				ob.value = ob.t_value?ob.t_value:1;
			}
		}
		
	 //if (!ob.value.match(/^[1-9]{1}[0-9]*$/)) ob.value = ob.t_value; else ob.t_value = ob.value; 
	}
	function keyUp(ob) {
		var reg=/^[1-9]{1}[0-9]*$/;
		var val=ob.value;
		if(val){
			if(reg.test(val)){
				ob.t_value = ob.value;
			}else{
				ob.value = ob.t_value?ob.t_value:1;
			}
		}
	 //if (!ob.value.match(/^[1-9]{1}[0-9]*$/)) ob.value = ob.t_value; else ob.t_value = ob.value; 
	}
	function keyBlur(ob) {
		var reg=/^[1-9]{1}[0-9]*$/;
		var val=ob.value;
		
			if(reg.test(val)){
				ob.t_value = ob.value;
			}else{
				ob.value = ob.t_value?ob.t_value:1;
			}
		
	 //if (!ob.value.match(/^[1-9]{1}[0-9]*$/)) ob.value = ob.t_value; else ob.t_value = ob.value; 
	}
	// add to cart js	
	<?php $this->beginBlock('add_to_cart') ?>
	$(document).ready(function(){
		productAjaxUrl = "<?= Yii::$service->url->getUrl('customer/ajax/product');  ?>";
		product_id   = $(".product_view_id").val();
		$.ajax({
			async:true,
			timeout: 6000,
			dataType: 'json',
			type:'get',
			data: {
				// 'currentUrl':window.location.href,
				'product_id':product_id
			},
			url:productAjaxUrl,
			success:function(data, textStatus){
				if(data.favorite){
					$("#divMyFavorite").addClass("active");
				}
				if(data.csrfName && data.csrfVal && data.product_id){
					$(".product_csrf").attr("name",data.csrfName);
					$(".product_csrf").val(data.csrfVal);
				}
			},
			error:function (XMLHttpRequest, textStatus, errorThrown){}
		});
	
		$("#product_info_section .addProductToCart").click(function(){
			i = 1;
			$(".product_custom_options .pg .rg ul.required").each(function(){
				val = $(this).find("li.current a.current").attr("value");
			    if(!val){
				    $(this).parent().parent().css("border","1px dashed #cc0000").css('padding-left','10px').css("margin-left","-10px");
					i = 0;
				}else{
					$(this).parent().parent().css("border","none").css('padding-left','0px').css("margin-left","0px");
			    
			    }
			});
			if(i){
				custom_option = new Object();
				$(".product_custom_options .pg .rg ul").each(function(){
					$m = $(this).find("li.current a.current");
					attr = $m.attr("attr");
					value = $m.attr("value");
					custom_option[attr] = value;
				});
				custom_option_json = JSON.stringify(custom_option);
				//alert(custom_option_json);
				sku = $(".sku").val();
				qty = $(".qty").val();
				qty = qty ? qty : 1;
				if($('#unit').val()){
					qty = qty*$('#unit').val();
				}
				csrfName = $(".product_csrf").attr("name");
				csrfVal  = $(".product_csrf").val();
				
				$(".product_custom_options").val(custom_option_json);
				$(this).addClass("dataUp");
				// ajax 提交数据
				
				addToCartUrl = "<?= Yii::$service->url->getUrl('checkout/cart/add'); ?>";
				$data = {};
				$data['custom_option'] 	= custom_option_json;
				$data['product_id'] 	= $(".product_view_id").val();
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
							$.alert('success');
						}else{
							content = data.content;
							$(".addProductToCart").removeClass("dataUp");
							$.alert(content);
						}
						
					},
					error:function (XMLHttpRequest, textStatus, errorThrown){}
				});
			}
		});
	  // product favorite
	   $("#divMyFavorite").click(function(){
			
				
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
				if($('#unit').val()){
					qty = qty*$('#unit').val();
				}
				custom_option_sku = '';
				/*for(x in custom_option_arr){
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
				}*/
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
        // 改变个数的时候，价格随之变动
	   $("#unit").blur(function(){
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
				if($('#unit').val()){
					qty = qty*$('#unit').val();
				}
				custom_option_sku = '';
				/*for(x in custom_option_arr){
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
				}*/
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
		function isInteger(str){
		   	if(!/^\d+$/.test(str)){
	               return false;
		   	}
			return true;
	   }
		// 改变个数的时候，价格随之变动
	   $(".btn_qty").click(function(){
	   		if($(this).data('qty')){
	   	    	qty = $(this).data('qty');
	   	    }else{
	   			return false;
	   	    }
	   	    
	   	    $(".qty").val(qty);
	   		if(!isInteger(qty)){
	   			$(".qty").val(1);
	   		}
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
				if($('#unit').val()){
					qty = qty*$('#unit').val();
				}
				custom_option_sku = '';
				/*for(x in custom_option_arr){
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
				}*/
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
	<?php $this->registerJs($this->blocks['add_to_cart'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>
</script> 
<?= Yii::$service->page->trace->getTraceProductJsCode($sku)  ?>
  
 