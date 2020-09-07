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

	<div class="col-main account_center layui-form">
		<form class="std" id="returnForm">
			<div >
				<div class="my_account_order">
					<div class="order-items order-details ">
						
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
							</colgroup>
							<thead>
								<tr class="first last ress_tit">
									
									<th><?= Yii::$service->page->translate->__('Product Name');?></th>
									<th><?= Yii::$service->page->translate->__('Product Image');?></th>
									<th><?= Yii::$service->page->translate->__('Sku');?></th>
									<th class="a-right"><?= Yii::$service->page->translate->__('Price');?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Qty');?></th>
									
								</tr>
							</thead>
							
							<tbody class="odd">
								<?php  if(is_array($products['returnItemData']) && !empty($products['returnItemData'])):  
									
								?>
									<?php foreach($products['returnItemData'] as $product):
										
									?>
									<tr id="order-item-row" class="border first item_id_<?= $product['item_id'] ?>">
										<input type="hidden" name="editForm[items][]" value="<?= $product['item_id'] ?>">
										<td>
											<a href="<?=  Yii::$service->url->getUrl($product['redirect_url']); ?>">
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
											<div class="a-center_width">
												
												<input disabled data-rate="<?= $rate ?>" data-price="<?= $product['price']; ?>" id="qty_<?= $product['item_id']; ?>" class="width_20" name="editForm[qty][]" onkeyup="keyUp(this)" onkeypress="keyPress(this)"   class="input-text qty cartqtychange" rel="<?= $product['item_id']; ?>" num="<?= $product['qty']; ?>" maxlength="100" t_value="<?= $product['qty']; ?>" value="<?= $product['qty']; ?>">
												<div class="clear"></div>
											</div>
										</td>
                                        
									</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Return Type") ?></label></td>
									<td colspan="4">
										
									      <?= Yii::$service->page->translate->__($products['returnData']['type'])?>
									 </td>
								</tr>
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Return Reason") ?></label></td>
									<td colspan="4">
									      <?= Yii::$service->page->translate->__($products['returnData']['repayment_method'])?>
									 </td>
								</tr>
								
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Return Money") ?></label></td>
									<td colspan="4">
										
									      <span ><?= $currency_symbol ?><?= Format::price($products['returnData']['price']); ?></span>
									 </td>
								</tr>
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Repayment Method") ?></label></td>
									<td colspan="4">
									      <?= Yii::$service->page->translate->__($products['returnData']['repayment_method'])?>
									 </td>
								</tr>
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Repayment Info") ?></label></td>
									<td colspan="4">
									      <textarea name="editForm[repayment_info]" required lay-verify="required" placeholder="" class="layui-textarea"><?= Yii::$service->page->translate->__($products['returnData']['repayment_info'])?></textarea>
									 </td>
								</tr>
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Return Way") ?></label></td>
									<td colspan="4">
									      <select name="editForm[tracking_number]" required lay-verify="required">
									      
									        <option value="return_way_0"><?= Yii::$service->page->translate->__("順豐退回(買家負責運費)") ?></option>
									        <option value="return_way_1"><?= Yii::$service->page->translate->__("待賣家安排時間上門回收") ?></option>
									      </select>
									 </td>
								</tr>
								<tr>
									<td><label ><?= Yii::$service->page->translate->__("Sales Return No") ?></label></td>
									<td colspan="4">
										  <input type="text" name="editForm[tracking_number]"   placeholder="" autocomplete="off" class="layui-input">
									     
									 </td>
								</tr>
								
								<tr>
									<td><label ><?= Yii::$service->page->translate->__("Desc") ?></label></td>
									<td colspan="4">
									      <textarea name="editForm[desc]" placeholder="" class="layui-textarea"></textarea>
									 </td>
								</tr>
								<tr>
									<td><label  ><?= Yii::$service->page->translate->__("Upload") ?></label></td>
									<td colspan="4">
										<?php if($products['returnData']['img']){?>
									      <img src="<?= Yii::$service->product->image->getResize($products['returnData']['img'],[100,100],false) ?>" alt="<?= $product['name'] ?>" width="75" height="75">
									      <?php } ?>
									 </td>
								</tr>
								<tr>
									<td></td>
									<td colspan="4">
									      <button class="layui-btn" lay-submit lay-filter="reg">立即提交</button>
									 </td>
								</tr>
								</tbody>								   
						</table>
						
					</div>
				</div>
			</div>
		</form>
		
	</div>
	
<script>
<?php $this->beginBlock('simpleproduct') ?>  
function keyPress(ob) {
	
	var reg=/^[1-9]{1}[0-9]*$/;
	var val=ob.value;
	if(val){
		if(reg.test(val)){
			ob.t_value = ob.value;
		}else{
			ob.value = ob.t_value?ob.t_value:1;
		}
		changeTotal(ob.value);
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
		changeTotal(ob.value);
	}
 //if (!ob.value.match(/^[1-9]{1}[0-9]*$/)) ob.value = ob.t_value; else ob.t_value = ob.value; 
}
$(document).ready(function(){
		function changeTotal(num){
			var total=0;
			var totalrate=0;
			$('input.cartqtychange').each(function(index, item){
				total+=$(item).data('price')*$(item).val();
				totalrate+=$(item).data('price')*$(item).data('rate')*$(item).val();
	        });
	        console.log(total);
		}
		
		 $(".cartqtydown").click(function(){
				var id=$(this).attr("rel");
				var num=$('#qty_'+id).val()-1;
				if(num>0){
					$('#qty_'+id).val(num);	
					changeTotal(num);
				}
		});
		
		layui.use('upload', function(){
		  var $ = layui.jquery
		  ,upload = layui.upload
		  ,form=layui.form
		  ,layer=layui.layer;
		  
		  //提交表单的方法
			 form.on('submit(reg)', function (data) {
			  
			   var fd = new FormData();
			   var formData = new FormData($( "#returnForm" )[0]);
			  
			   $(this).attr("disabled", true);
			   $(this).css("background-color", "darkgray");
			   
			   $.ajax({
			    cache : true,
			    type : "post",
			    url : "<?= Yii::$service->url->getUrl('returnexchange/info/savesalesreturn');?>",
			    async : false,
			    data : formData, // 你的formid
			    contentType: false, //jax 中 contentType 设置为 false 是为了避免 JQuery 对其操作，从而失去分界符，而使服务器不能正常解析文件
			    processData: false, //当设置为true的时候,jquery ajax 提交的时候不会序列化 data，而是直接使用data
			    error : function(request) {
			     layer.alert('操作失败');
			     $(this).attr("disabled", false);
			     $(this).css("background-color", "darkgray");
			    },
			    success : function(ret) {
			    	var ret=JSON.parse(ret);
			    	if(ret.code==0){
			    		layer.alert('success');
			    	}else if(ret.code==1||ret.code==2||ret.code==3||ret.code==8) {
			    		layer.alert(ret.content);
			    	}else if(ret.code==4||ret.code==5||ret.code==6||ret.code==7){
			    		layer.alert(ret.content);
			    		var item_id=ret.data.item_id;
			    		$('.item_id_'+item_id)[0].style.border="1px solid red";
			    	}
			    }
			    })
			    
			    return false;
			 })
    	form.verify({
    		required:function(value,item){
    			if(!value.length){
    				return '<?= Yii::$service->page->translate->__("This is a required field.") ?>';
    			}
    			
    		}
    	})
    
		 
		  upload.render({
		    elem: "#test1"
		    ,url: 'https://httpbin.org/post' //改成您自己的上传接口
		    ,accept: 'file' //普通文件
		    ,auto: false
		    ,field: "img"
		    ,bindAction: '#get'
		    ,done: function(res){
		      
		    }
		  });
		});
	});
<?php $this->endBlock(); ?>  
</script>  
<?php $this->registerJs($this->blocks['simpleproduct'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>