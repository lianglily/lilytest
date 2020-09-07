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

$returnTypeArr=Yii::$service->returnexchange->getReturnTypeArr();
$returnReasonArr=Yii::$service->returnexchange->getReturnReasonArr();
$returnPaymentMethodArr=Yii::$service->returnexchange->getReturnPaymentMethodArr();
$returnShippingMethodArr = Yii::$service->returnexchange->getReturnShippingMethodArr();
?>
<style>
table tr td:first-child{width:180px;}
</style>
	<div class="col-main account_center layui-form">
		<form class="std" id="returnForm">
			<div >
				<div class="my_account_order">
					<div class="order-items order-details layui-form">
						
						<input type="hidden" class="csrf" value="<?php echo Yii::$app->getRequest()->getCsrfToken(); ?>" name="<?php echo Yii::$app->getRequest()->csrfParam; ?>" />
						<table summary="Items Ordered" id="my-orders-table" class="edit_order ">
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
									<th class="a-center"><?= Yii::$service->page->translate->__('Return Status');?></th>
									<th class="a-center"><?= Yii::$service->page->translate->__('Actions');?></th>
								</tr>
							</thead>
							
							<tbody class="odd">
								<?php if(is_array($products) && !empty($products)):  
									$total=0;
								?>
									<?php foreach($products as $product):
										$rate=1;
										if(!empty((float)$product['base_subtotal_with_discount'])){
											$rate=1-$product['base_subtotal_with_discount']/$product['base_subtotal'];
											
										}
										$total+=$product['price']*$product['qty'];
										$totalRate+=$product['price']*$product['qty']*$rate;
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
											<div class="a-center_width" >
												<a href="javascript:void(0)" class="cartqtydown changeitemqty" rel="<?= $product['item_id']; ?>" num="<?= $product['qty']; ?>"></a>
												<input data-rate="<?= $rate ?>" data-price="<?= $product['price']; ?>" id="qty_<?= $product['item_id']; ?>" class="width_20" name="editForm[qty][]" onkeyup="keyUp(this)" onkeypress="keyPress(this)"   class="input-text qty cartqtychange" rel="<?= $product['item_id']; ?>" data-num="<?= $product['qty']; ?>" maxlength="100" t_value="<?= $product['qty']; ?>" value="<?= $product['qty']; ?>">
												<div class="clear"></div>
											</div>
										</td>
                                        <td class="a-center">
											<?php
                                            if(isset($returnTypeArr[$product['retuan_status']])){ ?>
                                            	<?= $returnTypeArr[$product['retuan_status']];?>
                                            <?php }else{?>
                                            	<?= Yii::$service->page->translate->__('Return / Exchange');?>
                                            <?php } ?>
                                            
										</td>
										<td class="a-center">
											<a href="#" class="addProductToCart" data-id="<?= $product['product_id'] ?>">
                                                    Delete 
                                            </a>
                                            
										</td>
									</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Return Type") ?></label></td>
									<td colspan="6">
									      <select lay-filter="selectType" name="editForm[type]" required lay-verify="required">
									        <?php foreach($returnTypeArr as $key => $val){?>
									        <option value="<?= $key ?>"><?= $val ?></option>
									        <?php }?>
									      </select>
									 </td>
								</tr>
								</tbody>
								</table>
								<table  class="display_inline-table" id="selecttypetable">
								<tr >
									<td class="width_150"><label class=" required" ><?= Yii::$service->page->translate->__("Sales Return Reason") ?></label></td>
									<td colspan="6">
									      <select name="editForm[reason]" required lay-verify="required">
									        <?php foreach($returnReasonArr as $key => $val){?>
									        <option value="<?= $key?>"><?= $val?></option>
									        <?php } ?>
									      </select>
									 </td>
								</tr>
								
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Return Money") ?></label></td>
									<td colspan="6">
										
									      <?= $currency_symbol ?><span id="total" class="text_through"><?= Format::price($total); ?></span><?= $currency_symbol ?><span id="total_rate"><?= Format::price($totalRate); ?></span>
									 </td>
								</tr>
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Repayment Method") ?></label></td>
									<td colspan="6">
									      <select name="editForm[repayment_method]" required lay-verify="required">
									      <?php foreach($returnPaymentMethodArr as $key => $val){ ?>
									        <option value="<?= $key ?>"><?= $val ?></option>
									      <?php } ?>
									      </select>
									 </td>
								</tr>
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Repayment Info") ?></label></td>
									<td colspan="6">
									      <textarea name="editForm[repayment_info]" required lay-verify="required" placeholder="" class="layui-textarea"></textarea>
									 </td>
								</tr>
								<tr>
									<td><label ><?= Yii::$service->page->translate->__("Desc") ?></label></td>
									<td colspan="6">
									      <textarea name="editForm[desc]" placeholder="" class="layui-textarea"></textarea>
									 </td>
								</tr>
								
								</table>
								<table>
								<tr>
									<td><label  ><?= Yii::$service->page->translate->__("Upload") ?></label></td>
									<td colspan="6">
									      <button type="button" class="layui-btn" id="test1">
											  <i class="layui-icon">&#xe67c;</i>上传图片
											</button>
									 </td>
								</tr>
								<tr>
									<td></td>
									<td colspan="6">
									      <button class="layui-btn" lay-submit lay-filter="reg">立即提交</button>
									 </td>
								</tr>
								</table>
						
					</div>
				</div>
			</div>
		</form>
		
	</div>
<script id="demo4" type="text/html">
  <tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Return Reason") ?></label></td>
									<td colspan="6">
									      <select name="editForm[reason]" required lay-verify="required">
									        <?php foreach($returnReasonArr as $key => $val){?>
									        <option value="<?= $key?>"><?= $val?></option>
									        <?php } ?>
									      </select>
									 </td>
								</tr>

								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Return Way") ?></label></td>
									<td colspan="6">
									      <select name="editForm[shipping]" required lay-verify="required">
									      <?php foreach($returnShippingMethodArr as $key => $val){?>
									        <option value="<?= $key ?>"><?= $val ?></option>
									      <?php } ?>
									      </select>
									 </td>
								</tr>
								<tr>
									<td><label ><?= Yii::$service->page->translate->__("Sales Return No") ?></label></td>
									<td colspan="6">
										  <input type="text" name="editForm[tracking_number]"   placeholder="" autocomplete="off" class="layui-input">
									     
									 </td>
								</tr>
								
								<tr>
									<td><label ><?= Yii::$service->page->translate->__("Desc") ?></label></td>
									<td colspan="6">
									      <textarea name="editForm[desc]" placeholder="" class="layui-textarea"></textarea>
									 </td>
								</tr>
</script>	
<script id="demo3" type="text/html">
  <tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Return Reason") ?></label></td>
									<td colspan="6">
									      <select name="editForm[reason]" required lay-verify="required">
									        <?php foreach($returnReasonArr as $key => $val){?>
									        <option value="<?= $key?>"><?= $val?></option>
									        <?php } ?>
									      </select>
									 </td>
								</tr>
								
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Return Money") ?></label></td>
									<td colspan="6">
										
									      <?= $currency_symbol ?><span id="total" class="text_through"><?= Format::price($total); ?></span><?= $currency_symbol ?><span id="total_rate"><?= Format::price($totalRate); ?></span>
									 </td>
								</tr>
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Repayment Method") ?></label></td>
									<td colspan="6">
									      <select name="editForm[repayment_method]" required lay-verify="required">
									      <?php foreach($returnPaymentMethodArr as $key => $val){ ?>
									        <option value="<?= $key ?>"><?= $val ?></option>
									      <?php } ?>
									      </select>
									 </td>
								</tr>
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Repayment Info") ?></label></td>
									<td colspan="6">
									      <textarea name="editForm[repayment_info]" required lay-verify="required" placeholder="" class="layui-textarea"></textarea>
									 </td>
								</tr>
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Return Way") ?></label></td>
									<td colspan="6">
									      <select name="editForm[shipping]" required lay-verify="required">
									      <?php foreach($returnShippingMethodArr as $key => $val){?>
									        <option value="<?= $key ?>"><?= $val ?></option>
									      <?php } ?>
									      </select>
									 </td>
								</tr>
								<tr>
									<td><label ><?= Yii::$service->page->translate->__("Sales Return No") ?></label></td>
									<td colspan="6">
										  <input type="text" name="editForm[tracking_number]"   placeholder="" autocomplete="off" class="layui-input">
									     
									 </td>
								</tr>
								
								<tr>
									<td><label ><?= Yii::$service->page->translate->__("Desc") ?></label></td>
									<td colspan="6">
									      <textarea name="editForm[desc]" placeholder="" class="layui-textarea"></textarea>
									 </td>
								</tr>

</script>
<script id="demo2" type="text/html">
<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Return Reason") ?></label></td>
									<td colspan="6">
									      <select name="editForm[reason]" required lay-verify="required">
									        <?php foreach($returnReasonArr as $key => $val){?>
									        <option value="<?= $key?>"><?= $val?></option>
									        <?php } ?>
									      </select>
									 </td>
								</tr>
								
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Return Money") ?></label></td>
									<td colspan="6">
										
									      <?= $currency_symbol ?><span id="total" class="text_through"><?= Format::price($total); ?></span><?= $currency_symbol ?><span id="total_rate"><?= Format::price($totalRate); ?></span>
									 </td>
								</tr>
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Repayment Method") ?></label></td>
									<td colspan="6">
									      <select name="editForm[repayment_method]" required lay-verify="required">
									      <?php foreach($returnPaymentMethodArr as $key => $val){ ?>
									        <option value="<?= $key ?>"><?= $val ?></option>
									      <?php } ?>
									      </select>
									 </td>
								</tr>
								<tr>
									<td><label class=" required" ><?= Yii::$service->page->translate->__("Sales Repayment Info") ?></label></td>
									<td colspan="6">
									      <textarea name="editForm[repayment_info]" required lay-verify="required" placeholder="" class="layui-textarea"></textarea>
									 </td>
								</tr>
								<tr>
									<td><label ><?= Yii::$service->page->translate->__("Desc") ?></label></td>
									<td colspan="6">
									      <textarea name="editForm[desc]" placeholder="" class="layui-textarea"></textarea>
									 </td>
								</tr>
</script>
<script>
<?php $this->beginBlock('simpleproduct') ?>  
function changeTotal(num){
	var total=0;
	var totalrate=0;
	$('input.cartqtychange').each(function(index, item){
		total+=$(item).data('price')*$(item).val();
		totalrate+=$(item).data('price')*$(item).data('rate')*$(item).val();
    });
    $('#total').text(total);
    $('#total_rate').text(totalrate);
}
function keyPress(ob) {
	
	var reg=/^[0-9]{1}[0-9]*$/;
	var val=ob.value;
	var num=$(ob).data('num')
	if(val){
		if(reg.test(val)){
			
			if(val>num){
				ob.value=ob.t_value=num;
			}
			ob.t_value = ob.value;
		}else{
			ob.value = ob.t_value?ob.t_value:1;
		}
		changeTotal(ob.value);
	}
	
 //if (!ob.value.match(/^[1-9]{1}[0-9]*$/)) ob.value = ob.t_value; else ob.t_value = ob.value; 
}
function keyUp(ob) {
	var reg=/^[0-9]{1}[0-9]*$/;
	var val=ob.value;
	var num=$(ob).data('num');
	if(val){
		if(reg.test(val)){
			
			if(val>num){
				ob.value=ob.t_value=num;
			}
			ob.t_value = ob.value;
		}else{
			ob.value = ob.t_value?ob.t_value:1;
		}
		changeTotal(ob.value);
	}
 //if (!ob.value.match(/^[1-9]{1}[0-9]*$/)) ob.value = ob.t_value; else ob.t_value = ob.value; 
}
$(document).ready(function(){
		
		
		 $(".cartqtydown").click(function(){
				var id=$(this).attr("rel");
				var num=$('#qty_'+id).val()-1;
				if(num>-1){
					$('#qty_'+id).val(num);	
					changeTotal(num);
				}
		});
		
		layui.use('upload', function(){
		  var $ = layui.jquery
		  ,upload = layui.upload
		  ,form=layui.form
		  ,layer=layui.layer;
		  var laytpl = layui.laytpl;
		  
		   form.on('select(selectType)', function(data){
		   	  demo="demo"+data.value;
		   	  
			  var getTpl = document.getElementById(demo).innerHTML,view = document.getElementById('selecttypetable');
			  
				laytpl(getTpl).render({}, function(html){
				  view.innerHTML = html;
				  form.render();
				});
			  //$('table[name=select_type]').html();
			  
			});
			
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
			     layer.alert("<?= Yii::$service->page->translate->__('操作失败') ?>");
			     $(this).attr("disabled", false);
			     $(this).css("background-color", "darkgray");
			    },
			    success : function(ret) {
			    	var ret=JSON.parse(ret);
			    	if(ret.code==0){
			    		layer.alert("<?= Yii::$service->page->translate->__('success') ?>");
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