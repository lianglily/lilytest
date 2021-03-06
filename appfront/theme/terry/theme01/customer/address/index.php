<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
use fec\helpers\CRequest;
?>
<div class="main container two-columns-left">
	<div class="clear"></div>
    <?= Yii::$service->page->widget->render('base/breadcrumbs',$this); ?>
	<div class="col-main account_center">
		<div class="std">
			<div class="margin_4">
				<div class="page-title">
					<h2><?= Yii::$service->page->translate->__('Customer Address');?></h2>
				</div>
				<table class="addressbook" width="100%" cellspacing="0" cellpadding="0" border="0">
					<thead>
						<tr class="ress_tit">
							<th width="76" valign="middle" align="center" height="31"><?= Yii::$service->page->translate->__('First Name');?></th>  
							<th width="72" valign="middle" align="center" height="31"><?= Yii::$service->page->translate->__('Last Name');?></th>                                                                                       
							<th width="167" valign="middle" align="center"><?= Yii::$service->page->translate->__('Email Address');?></th>
							<th width="67" valign="middle" align="center"><?= Yii::$service->page->translate->__('Country');?></th>
							<th width="79" valign="middle" align="center"><?= Yii::$service->page->translate->__('State');?></th>
							<th width="79" valign="middle" align="center"><?= Yii::$service->page->translate->__('City');?></th>
						
							<th width="101" valign="middle" align="center"><?= Yii::$service->page->translate->__('Telephone');?> </th>
							<th class="th3" width="71" valign="middle" align="center"><?= Yii::$service->page->translate->__('Operation');?></th>
						</tr>
					</thead>
					<tbody>
					<?php   if(is_array($coll) && !empty($coll)):   ?>
					<?php 	$areas=Yii::$service->shipping->area;
							foreach($coll as $one): 
								$countryid=is_numeric($one['country'])?$one['country']-1:-1;
                       
                        
		                        if(isset($areas[$countryid])){
		                        	
		                        	if($areas[$countryid]['translate']){
		                        		$country = Yii::$service->page->translate->__($areas[$countryid]['translate']);
		                        	}else{
		                        		$country = $areas[$countryid]['name'];
		                        	}
		                        	$stateid=is_numeric($one['state'])?$one['state']-1:-1;
		                        	
		                        	if(isset($areas[$countryid]['cityList'][$stateid])){
		                        		if($areas[$countryid]['cityList'][$stateid]['translate']){
			                        		$state = Yii::$service->page->translate->__($areas[$countryid]['cityList'][$stateid]['translate']);
			                        	}else{
			                        		$state = $areas[$countryid]['cityList'][$stateid]['name'];
			                        	}
		                        	}
		                        	$cityid=is_numeric($one['city'])?$one['city']-1:-1;
		                        	if(isset($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid])){
		                        		if($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['translate']){
			                        		$city = Yii::$service->page->translate->__($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['translate']);
			                        	}else{
			                        		$city = $areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['name'];
			                        	}
			                        	$weekday=$areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['weekday'];
		                        	}
		                        }else{
		                        
		                        	$country = Yii::$service->helper->country->getCountryNameByKey($one['country']);
		                        	$state = Yii::$service->helper->country->getStateByContryCode($one['country'],$one['state']);
									$city = $one['city'];
		                        }
								
					?>
						<tr class="">
							<td valign="top" align="center"><?= $one['first_name'] ?></td>
							<td valign="top" align="center"><?= $one['last_name'] ?></td>
							<td valign="top" align="center"><?= $one['email'] ?></td>
							<td valign="top" align="center"><?= $country ?></td>
							<td valign="top" align="center"><?= $state ?></td>
							<td valign="top" align="center"><?= $city ?></td>
							<td valign="top" align="center"><?= $one['telephone'] ?></td>
							<td class="ltp" valign="top ltp" align="center">
								<a href="javascript:window.location.href='<?= Yii::$service->url->getUrl('customer/address/edit',['address_id' => $one['address_id']]); ?>'"  ><?= Yii::$service->page->translate->__('Modify');?></a>
								<a href="javascript:deleteAddress(<?= $one['address_id'] ?>)"><?= Yii::$service->page->translate->__('Delete');?></a>
								<?php  if($one['is_default'] == 1): ?>
								<span class="color_cc0000"><?= Yii::$service->page->translate->__('Default');?></span> 
								<?php  endif; ?>								
							</td>
						</tr>	
					<?php 		endforeach; ?>
					<?php 	endif; ?>
					</tbody>
				</table>
				<div class="product-Reviews">
					<input onclick="javascript:window.location.href='<?= Yii::$service->url->getUrl('customer/address/edit') ?>'" class="submitbutton addnew cpointer" value="<?= Yii::$service->page->translate->__('Add New Address');?>" name="" type="button">
					
				</div>
			</div>
		</div>

		<script>
            function deleteAddress(address_id){
				var r=confirm("<?= Yii::$service->page->translate->__('do you readly want delete this address?') ?>");
                if (r==true){ 
                    url = "<?= Yii::$service->url->getUrl('customer/address') ?>";
                    doPost(url, {"method": "remove", "address_id": address_id, "<?= CRequest::getCsrfName() ?>": "<?= CRequest::getCsrfValue() ?>" });
                }
            }
		</script>
	</div>
	
	
		<?= Yii::$service->page->widget->render('customer/left_menu', $this); ?>
	
	<div class="clear"></div>
</div>
	