<?php
/**
 * FecMall file.
 *
 * @link http://www.fecmall.com/
 * @copyright Copyright (c) 2016 FecMall Software LLC
 * @license http://www.fecmall.com/license
 */
use yii\helpers\Html;
use fec\helpers\CRequest;
use fecadmin\models\AdminRole;
/** 
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
?>
<style>
.checker{float:left;}
.dialog .pageContent {background:none;}
.dialog .pageContent .pageFormContent{background:none;}
</style>

<div class="pageContent systemConfig"> 
	<form  method="post" action="<?= $saveUrl ?>" class="pageForm required-validate" onsubmit="return thissubmit(this);">
		<?php echo CRequest::getCsrfInputHtml();  ?>	
		<div layouth="56" class="pageFormContent" style="height: 240px; overflow: auto;">
			
				<input type="hidden"  value="<?=  $_id; ?>" size="30" name="editFormData[_id]" class="textInput ">
				
				<fieldset id="fieldset_table_qbe">
					<legend style="color:#cc0000"><?= Yii::$service->page->translate->__('Base Config') ?></legend>
					<div>
						<?= $editBar; ?>
					</div>
				</fieldset>
				<?= $lang_attr ?>
				<?= $textareas ?>
				<input type="hidden" name="editFormData[values]" class="langs_input">
				<input type="hidden" name="editFormData[total_values]" class="total_input">
				<div class="langs" style="float:left;width:700px;">
                    <table style="">
                        <thead>
                            <tr>
                                
                                <th><?=  Yii::$service->page->translate->__('Weight Min') ?></th>
								<th><?=  Yii::$service->page->translate->__('Weight Max') ?></th>
								<th><?=  Yii::$service->page->translate->__('Formula') ?></th>
                                <th><?=  Yii::$service->page->translate->__('Action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(is_array($values) && !empty($values)){  ?>
                                <?php foreach($values as $ones){ 
                                	foreach($ones as $one){ 
									if(isset($one['weight'])){
								?>
                                <tr>
									<td>
                                        <input class="weight_min" type="text" value="<?= $one['weight']['min'] ?>">
                                    </td>
									<td>
                                        <input class="weight_max" type="text" value="<?= $one['weight']['max'] ?>">
                                    </td>
                                    <td>
                                        <input class="formula" type="text" value="<?= $one['formula'] ?>">
                                    </td>
                                    
                                    <td>
                                        <i class="fa fa-trash-o"></i>
                                    </td>
                                </tr>
							<?php }}}}?>
								
                        </tbody>
                        <tfoot style="text-align:right;">
                            <tr>
                                <td colspan="100" style="text-align:right;">						
                                    <a rel="2" style="text-align:right;margin-top:15px;" href="javascript:void(0)" class="addWeight button">
                                        <span><?=  Yii::$service->page->translate->__('Add Weight') ?></span>
                                    </a>
									
                                </td>				
                            </tr>			
                        </tfoot>
                    </table>
					<table style="">
                        <thead>
                            <tr>
                                
                                <th><?=  Yii::$service->page->translate->__('Total Min') ?></th>
								<th><?=  Yii::$service->page->translate->__('Total Max') ?></th>
								<th><?=  Yii::$service->page->translate->__('Formula') ?></th>
                                <th><?=  Yii::$service->page->translate->__('Action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(is_array($values) && !empty($values)){  ?>
                                <?php foreach($values as $ones){ 
                                	
                                	foreach($ones as $one){ 
                                	
									if(isset($one['total'])){
								?>
                          
								<tr>
									<td>
                                        <input class="total_min" type="text" value="<?= $one['total']['min'] ?>">
                                    </td>
									<td>
                                        <input class="total_max" type="text" value="<?= $one['total']['max'] ?>">
                                    </td>
                                    <td>
                                        <input class="formula" type="text" value="<?= $one['formula'] ?>">
                                    </td>
                                    
                                    <td>
                                        <i class="fa fa-trash-o"></i>
                                    </td>
                                </tr>
							<?php } } }} ?>
                        </tbody>
                        <tfoot style="text-align:right;">
                            <tr>
                                <td colspan="100" style="text-align:right;">						
                             
									<a rel="2" style="text-align:right;margin-top:15px;" href="javascript:void(0)" class="addTotal button">
                                        <span><?=  Yii::$service->page->translate->__('Add Total') ?></span>
                                    </a>
                                </td>				
                            </tr>			
                        </tfoot>
                    </table>
					<style>
					
						.edit_p .langs input{
							width:100px;
						}
						.edit_remark p{
							width:500px;font-size:14px;
							line-height:30px;
							height:auto;
							color:#777;
						}
						.langs table thead tr th{
							 background: #ddd none repeat scroll 0 0;
							border: 1px solid #ccc;
							padding: 4px 10px;
							width: 100px;
						}

						.langs table tbody tr td{
							background: #fff;
							border-right: 1px solid #ccc;
							border-bottom: 1px solid #ccc;
							padding:3px;
							width: 100px;
						}

						.edit_p .langs input{width:100px;}
					</style>
                    <script>
						


						function thissubmit(thiss){
							
							var fill = true;
							langs_input = "";
							total_input='';
							$(".langs table tbody tr").each(function(){
								formula = $(this).find(".formula").val();
								weight_min = $(this).find(".weight_min").val();
								weight_max = $(this).find(".weight_max").val();
								total_min = $(this).find(".total_min").val();
								total_max = $(this).find(".total_max").val();
								if (formula && weight_min != undefined  && weight_max){
									langs_input += formula+'##'+weight_min+'##'+weight_max+'||';
								} else if (formula && total_min != undefined  && total_max){
									
									total_input += formula+'##'+total_min+'##'+total_max+'||';
								}else{
									fill = false
								}
							});
							if (fill == false) {
								alert('can not empty');
								return false;
							}
							console.log(langs_input);
							console.log(total_input);
							jQuery(".langs_input").val(langs_input);
							jQuery(".total_input").val(total_input);
							return validateCallback(thiss, navTabAjaxDone);
						}

                        $(document).ready(function(){
                            $(".addWeight").click(function(){
                                str = "<tr>";
                                
                                str +="<td><input class=\"weight_min textInput\" type=\"text\"   /></td>";
								str +="<td><input class=\"weight_max textInput\" type=\"text\"   /></td>";
								str +="<td><input class=\"formula textInput \" type=\"text\"   /></td>";
                                str +="<td><i class='fa fa-trash-o'></i></td>";
                                str +="</tr>";
                                $(".langs table tbody").append(str);
                            });
							$(".addTotal").click(function(){
                                str = "<tr>";
                                
                                str +="<td><input class=\"total_min textInput\" type=\"text\"   /></td>";
								str +="<td><input class=\"total_max textInput\" type=\"text\"   /></td>";
								str +="<td><input class=\"formula textInput \" type=\"text\"   /></td>";
                                str +="<td><i class='fa fa-trash-o'></i></td>";
                                str +="</tr>";
                                $(".langs table tbody").append(str);
                            });
                            $(".systemConfig").off("click").on("click",".langs table tbody tr td .fa-trash-o",function(){
                                $(this).parent().parent().remove();
                            });
                            
                        });
                    </script>
                </div>
				<div class="edit_remark" style="width:500px;margin-right:50px;float:right;font-size:14px;">
                <p> 
                    1.运算公式(Formula)，当固定价格时可直接填对应数值，当需要使用
                </p>  
            
            </div>
		</div>
		
		<div class="formBar">
			<ul>
				<!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
				<li>
                    <div class="buttonActive"><div class="buttonContent"><button onclick="func('accept')"  value="accept" name="accept" type="submit"><?= Yii::$service->page->translate->__('Save') ?></button></div></div>
                </li>
				<li>
					<div class="button"><div class="buttonContent"><button type="button" class="close"><?= Yii::$service->page->translate->__('Cancel') ?></button></div></div>
				</li>
			</ul>
		</div>
	</form>
</div>	

<style>
.pageForm  .pageFormContent .edit_p{
    width:100%;
    line-height:35px;
}
.pageForm  .pageFormContent .edit_p .remark-text{
    font-size: 11px;
    color: #777;
    margin-left: 20px;
}
.pageForm   .pageFormContent p.edit_p label{
        width: 240px;
    line-height: 30px;
    font-size: 13px;
    font-weight: 500;
}

.pageContent .combox {
        margin-left:5px;
        
}
</style>





