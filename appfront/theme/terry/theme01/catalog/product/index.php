<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<div class="main container one-column">
	<div class="col-main">
		<?= Yii::$service->page->widget->render('base/breadcrumbs',$this); ?>
		<div class="product_page">
			<div class="product_view">
				<input type="hidden" class="product_view_id" value="<?=  $_id ?>">
				<input type="hidden" class="sku" value="<?= $sku; ?>" />
				<input type="hidden" class="product_csrf" name="" value="" />
				<div class="product_info" id="product_page_info">
					<h1 ><?= $name; ?></h1>
					<div>
						<div class="rbc_cold">
							<span>
								<span class="average_rating"><?= Yii::$service->page->translate->__('Average rating'); ?> :</span>
								<span class="review_star review_star_<?= round($reviw_rate_star_average) ?>" class="bold" itemprop="average"></span>  
								
								<a rel="nofollow" href="#text-reviews">
									(<span itemprop="count"><?= $review_count ?> <?= Yii::$service->page->translate->__('reviews'); ?></span>)
								</a>
							</span>
						</div>
					</div>
					<div class="item_code"><?= Yii::$service->page->translate->__('Item Code:'); ?> <?= $sku; ?></div>
					<div class="price_info">
						<?= Yii::$service->page->widget->render('product/price', ['price_info' => $price_info]); ?>
					
					</div>
					<div class="product_info_section">
						<div class="product_options">
							
							<?= Yii::$service->page->widget->render('product/options', ['options' => $options]); ?>
						
						</div>
						
						<div class="product_qty pg">
							
							<div class="rg">
								<div class="layui-input-inline"><?= Yii::$service->page->translate->__('Qty:'); ?></div>
								<input onkeyup="keyUp(this)" onkeypress="keyPress(this)" onblur="keyBlur(this)" t_value="1" type="text" name="qty" class="qty" value="1" />
								<?php if ($package_number >= 2) { ?>
                                X <?= $package_number ?> items
                                <?php } ?>
                                <?php if(isset($unit)&&!empty($unit)){
                                	$unit_text='';
                                ?>
                                <div class="layui-input-inline">
							      
							      <?php foreach($unit as $val){?>
							      	<?php if($val['unit_base']==1){
							      		$default=$val['unit_code'];
							      	?>
							      	<span><?= Yii::$service->page->translate->__($val['unit_code']) ?> </span>
							      	<?php }else{
							        	$unit_text.= "1{$val['unit_code']} = {$val['unit_rate']}$default ";
							        ?>
							      	<?php } ?>
							      <?php } ?>
							      <span><?= $unit_text ?> </span>
							    </div>
                                <?php }?>
							</div>
							<div class="clear"></div>
						</div>
						
						<div class="addtocart">
						<?php if(isset($qtys[$_id]) && $qtys[$_id]>0 && $is_in_stock==1){?>
							<button  type="button" id="js_registBtn" class="redBtn addProductToCart"><em><span><i></i><?= Yii::$service->page->translate->__('Add To Cart'); ?></span></em></button>
						<?php }else{?>
							<button  type="button" id="js_registBtn" class="redBtn"><em><span><i></i><?= Yii::$service->page->translate->__('Out Of Stock'); ?></span></em></button>
						<?php }?>
							<div class="myFavorite_nohove" id="myFavorite">
								<i></i>
								<a href="javascript:" url="<?= Yii::$service->url->getUrl('catalog/favoriteproduct/add'); ?>"   class="addheart" id="divMyFavorite" rel="nofollow" >
									<?= Yii::$service->page->translate->__('Add to Favorites'); ?>
								</a>				
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="tier_price_info">
						<?= Yii::$service->page->widget->render('product/tier_price', ['tier_price' => $tier_price]); ?>
					</div>
				</div>
				<div class="media_img">
					<div class="col-left ">
						<?php # 图片部分。
							$imageParam = [
								'media_size' => $media_size,
								'image' => $image_thumbnails,
								'productImgMagnifier' => $productImgMagnifier,
							];
						?>
						<?= Yii::$service->page->widget->render('product/image',$imageParam); ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			
			<div>
				<?= Yii::$service->page->widget->render('product/buy_also_buy', ['products' => $buy_also_buy]); ?>
			</div>
			
			<div class="clear"></div>
			<div class="product_description_info">
				<div class="nav" id="nav-container">  
					<ul id="nav-box">
						<li  class="nav_tab cur" rel="description"><?= Yii::$service->page->translate->__('Description'); ?></li>  
						<li  class="nav_tab" rel="reviews"><?= Yii::$service->page->translate->__('Reviews'); ?></li>  
						<!-- <li  class="nav_tab" rel="questions"><?= Yii::$service->page->translate->__('Shipping & Payment'); ?></li>   -->
						<?php   if(isset($certFile)&&is_array($certFile)):  ?>
						<li   class="nav_tab" rel="certfile"><?= Yii::$service->page->translate->__('Cert File'); ?></li>
						<?php  endif;  ?>
					</ul>    
				</div>  
				<div id="text">  
					<div class="text-description" style="">
                        <?php if(is_array($groupAttrArr)): ?>
                            <table>
                            <?php foreach($groupAttrArr as $k => $v): ?>
                            
                                <tr><td><?= $k ?></td><td><?= $v ?></td></tr>
                            
                            <?php endforeach; ?>
                            </table>
                            <br/>
                        <?php endif; ?>
                        
						<?php echo str_replace("\n","<br>","$description"); ?>
                        
                        <div class="img-section text_center" >
                            <?php   if(is_array($image_detail)):  ?>
                                <?php foreach($image_detail as $image_detail_one): ?>
                                    <br/>
                                    <img class="js_lazy" alt="<?= $image_detail_one['image'] ?>" src="<?= Yii::$service->image->getImgUrl('images/lazyload.gif');   ?>" data-original="<?= Yii::$service->product->image->getUrl($image_detail_one['image']);  ?>"  />
                                    
                                <?php  endforeach;  ?>
                            <?php  endif;  ?>
                        </div>
					</div>  
					<div class="text-reviews" id="text-reviews" style="">
						<?php # review部分。
							$reviewParam = [
								'product_id' 	=> $_id,
								'spu'			=> $spu,
							];
                            
							$reviewParam['reviw_rate_star_info'] = $reviw_rate_star_info;
                            $reviewParam['review_count'] = $review_count;
                            $reviewParam['reviw_rate_star_average'] = $reviw_rate_star_average;
                            // var_dump($reviewParam);exit;
						?>
						<?= Yii::$service->page->widget->DiRender('product/review', $reviewParam); ?>
					</div>  
					<?php   if(isset($certFile)&&is_array($certFile)):  ?>
					<div class="text-certfile" id="text-certfile" style="">
						<div class="product-Reviews">
							<div id="pic_list_2" class="scroll_horizontal">
								<div class="scroll_left">
									<a href=""><?= Yii::$service->page->translate->__('Product Cert'); ?></a>
								</div>
								<div class="clear"></div>
								<div class="box pro_commit">
									<?php Yii::$service->product->image->imageFloder='media/cert'; ?>
									
									<?php	foreach($certFile as $val): ?>
									<p><a download="<?= Yii::$service->store->getStoreAttrVal(unserialize($val['name']), 'name')?>" href="<?= Yii::$service->product->image->getUrl($val['root']) ?>"><?= Yii::$service->store->getStoreAttrVal(unserialize($val['name']), 'name')?></a></p>
									<?php  endforeach;  ?>
									
								</div>
							</div>
						</div>
						
					</div>  
					<?php  endif;  ?>					
					<!--					
					<div class="text-wholesale" style="width:100%;height:500px;background:yellow;text-align:center;">
						
					</div>  
					-->
				</div> 
			</div>
		</div>
		<div class="proList">
		</div>
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
		$(".addProductToCart").click(function(){
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
				if($('#unit').val()){
					qty = $(".qty").val()*$('#unit').val();
				}else{
					qty = $(".qty").val();
				}
				
				
				qty = qty ? qty : 1;
				csrfName = $(".product_csrf").attr("name");
				csrfVal  = $(".product_csrf").val();
				
				$(".product_custom_options").val(custom_option_json);
				$(this).addClass("dataUp");
				// ajax 提交数据
				
				addToCartUrl = "<?= Yii::$service->url->getUrl('checkout/cart/add'); ?>";
				$data = {};
				$data['custom_option'] 	= custom_option_json;
				$data['product_id'] 	= $('.product_view_id').val();
				$data['unit'] 	= '<?=$default?>';
				$data['qty'] 			= qty;
				if (csrfName && csrfVal) {
					$data[csrfName] 		= csrfVal;
				}
				jQuery.ajax({
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
							$(".addProductToCart").removeClass("dataUp");
							layer.msg("<?= Yii::$service->page->translate->__('Add to cart success!'); ?>");
							//window.location.href="<?= Yii::$service->url->getUrl("checkout/cart") ?>";
						}else if(data.status == 'login'){
							layer.msg("Login first!");
						}else{
							content = data.content?data.content:'An unknown error';
							$(".addProductToCart").removeClass("dataUp");
							layer.msg(content);
						}
						
					},
					error:function (XMLHttpRequest, textStatus, errorThrown){}
				});
				
			}
		});
	   
	   // product favorite
	   $("#divMyFavorite").click(function(){
		    url = $(this).attr('url');
			product_id = $('.product_view_id').val();
			csrfName = $(".product_csrf").attr("name");
			csrfVal  = $(".product_csrf").val();
			param = {};
			param["product_id"] = product_id;
			if (csrfName && csrfVal) {
				param[csrfName] = csrfVal;
			}
			if($(this).hasClass('act')){
				param["status"] = 0;
				
			}else{
				param["status"] = 1;
			}
                
				
				
			//doPost(url, param);
			jQuery.ajax({
				async:true,
				timeout: 6000,
				dataType: 'json', 
				type:'post',
				data: param,
				url:url,
				success:function(data, textStatus){ 
					
					if(data.status == 'success'){
						count=$("#js_favour_num").text();
						if(param["status"]){
							$("#js_favour_num").text(parseInt(count)+1);
							$('.myFavorite_nohove').addClass('act');
							$('#divMyFavorite').addClass('act');
						}else{
							$("#js_favour_num").text(parseInt(count)-1);
							$('.myFavorite_nohove').removeClass('act');
							$('#divMyFavorite').removeClass('act');
						}
					}else if(data.status == 'login'){
						layer.msg('Login first!');
					}else{
						content = data.content?data.content:'An unknown error';
						//$(".addProductToCart").removeClass("dataUp");
						layer.msg(content);
					}
					
				},
				error:function (XMLHttpRequest, textStatus, errorThrown){}
			});
			
	   });
	   function isInteger(str){
		   	if(!/^\d+$/.test(str)){
	               return false;
		   	}
			return true;
	   }
	   // 改变个数的时候，价格随之变动
	   $(".qty").blur(function(){
	   	    if($('#unit').val()){
	   	    	qty = $(".qty").val()*$('#unit').val();
	   	    }else{
	   			qty = $(".qty").val();
	   	    }
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
				product_id = $('.product_view_id').val();;	
				if($('#unit').val()){
					qty = $(".qty").val()*$('#unit').val();
				}else{
					qty = $(".qty").val();
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
				jQuery.ajax({
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
		$("#unit").blur(function(){
	   	    if($('#unit').val()){
	   	    	qty = $(".qty").val()*$('#unit').val();
	   	    }else{
	   			qty = $(".qty").val();
	   	    }
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
				product_id = $('.product_view_id').val();;	
				if($('#unit').val()){
					qty = $(".qty").val()*$('#unit').val();
				}else{
					qty = $(".qty").val();
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
				jQuery.ajax({
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
				product_id = $('.product_view_id').val();;	
				if($(this).data('qty')){
		   	    	qty = $(this).data('qty');
		   	    }else{
		   			return false;
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
				jQuery.ajax({
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
	<?php $this->endBlock(); ?> 
	<?php $this->registerJs($this->blocks['add_to_cart'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>

	//tab 切换js
	<?php $this->beginBlock('product_info_tab') ?> 
	var navContainer = document.getElementById("nav-container");  
	var navBox = document.getElementById("nav-box");  
	var text = document.getElementById("text");  
	var navBoxChild = navBox.children;  
	var textChild = text.children;  
	var num = navContainer.offsetTop;  
	var a = navContainer.offsetHeight;  
	window.onscroll = function(){  
		var scrollTop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;  
		if(scrollTop >= num){  
			navContainer.className = "nav fixed";  
			text.style.paddingTop = a +"px";  
		}else{  
			navContainer.className = "nav";  
			text.style.paddingTop = "";  
		}  
		//当导航与相应文档接触的时候自动切换  
		//method1  
		for(var i=0;i<navBoxChild.length;i++){  
			if( scrollTop + a >= textChild[i].offsetTop){  
				for(var j=0;j<navBoxChild.length;j++){  
					navBoxChild[j].className = "";  
				}  
				navBoxChild[i].className = "cur";  
		   }  
		}  
	};  
	for(var i=0;i<navBoxChild.length;i++){  
		var interval;  
		navBoxChild[i].index = i;  
		navBoxChild[i].onclick = function(){  
			var self = this;  
			clearInterval(interval); 
			
			if(document.body.scrollTop){
				scroll = document.body;
			}else if(document.documentElement.scrollTop){
				scroll = document.documentElement;
			}

			interval = setInterval(function(){  
				if(scroll.scrollTop + a<=textChild[self.index].offsetTop){  
					scroll.scrollTop += 1500;  
					if(scroll.scrollTop + a>=textChild[self.index].offsetTop){  
						scroll.scrollTop = textChild[self.index].offsetTop-a;  
						clearInterval(interval);  
					}  
				}else{  
					scroll.scrollTop /= 1.1;  
					if(scroll.scrollTop + a<=textChild[self.index].offsetTop){  
						scroll.scrollTop = textChild[self.index].offsetTop-a;  
						clearInterval(interval);  
					}  
				}  
			},4);  
		};  
	}  
	<?php $this->endBlock(); ?>  
	<?php $this->registerJs($this->blocks['product_info_tab'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>
</script> 
<?= Yii::$service->page->trace->getTraceProductJsCode($sku)  ?>
 