
<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<style>
.paypal_success{line-height:24px;}
</style>
<div class="main container one-column">
	<div class="col-main">
		<div class="clear"></div>
		<div class="paypal_success text_center">
			
			<h2 class="sub-title"><?= Yii::$service->page->translate->__('Your order has been received,Thank you for your purchase!'); ?><?= Yii::$service->page->translate->__('Your order # is:'); ?> <?= $orderRef ?>.</h2>
			<div class="page-title color_4c6b99" >
				<?= Yii::$service->page->translate->__('The pay method you chose is:'); ?> PayDollar传款易.<?= Yii::$service->page->translate->__('Your due amount is:'); ?> <?= Yii::$service->page->currency->getCurrencyInfo()['symbol'] ?><?= $amount; ?>.
			</div>
			<!-- form id="paydollar_submit" action="https://test.paydollar.com/b2cDemo/eng/payment/payForm.jsp" method="post" --> 
			<form id="paydollar_submit" action="<?= $action?>" method="post">
			  <input type="hidden" name="merchantId" value="<?php echo $merchantId; ?>" />
			  <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
			  <input type="hidden" name="orderRef" value="<?php echo $orderRef; ?>" />
			  <input type="hidden" name="currCode" value="<?php echo $currCode; ?>" />
			  <input type="hidden" name="successUrl" value="<?php echo $successUrl; ?>" />
			  <input type="hidden" name="failUrl" value="<?php echo $failUrl; ?>" />
			  <input type="hidden" name="cancelUrl" value="<?php echo $cancelUrl; ?>" />
			  <input type="hidden" name="payType" value="<?php echo $payType; ?>" />
			  <input type="hidden" name="lang" value="<?php echo $lang; ?>" />
			  <input type="hidden" name="mpsMode" value="<?php echo $mpsMode; ?>" />
			  <input type="hidden" name="payMethod" value="<?php echo $payMethod; ?>" />
			  <input type="hidden" name="secureHash" value="<?php echo $secureHash; ?>" />
			  <input type="hidden" name="remark" value="<?php echo $remark; ?>" />
			  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
			  <input type="hidden" name="oriCountry" value="<?php echo $oriCountry; ?>" />
			  <input type="hidden" name="destCountry" value="<?php echo $destCountry; ?>" />
			  <div class="buttons">
				<div class="pull-right paydollar" >
				  <button  id="tit_time" onclick="processing()" type="button" ><?= Yii::$service->page->translate->__('Use PayDollar to Pay'); ?></button>
				</div>
			  </div>
			</form>
			
			<?php // var_dump($order); ?>
		</div>
	</div>
</div>
<script>

window.onload = function(){

    RunTimer = function (k) {
        document.getElementById('tit_time').innerHTML="<?= Yii::$service->page->translate->__('Use PayDollar to Pay'); ?>(" + k + ")";
        k--;
        if (k >= 0) {
            timer = setTimeout(function () {
                RunTimer(k)
            }, 1000);
        }
        else {
        	
            document.getElementById("tit_time").click();  //十秒后系统自动提交
        }

    };
	RunTimer(10);//调用倒计时
}
function processing(){
	
	jQuery.ajax({
		async:true,
		timeout: 6000,
		dataType: 'json', 
		type:'post',
		data: '',
		url:"<?= Yii::$service->url->getUrl('paydollar/paydollar/standard/processing'); ?>",
		success:function(data, textStatus){
			
			document.getElementById("paydollar_submit").submit();  //十秒后系统自动提交
		},
		error:function (XMLHttpRequest, textStatus, errorThrown){}
	});
	return false;
	
}

</script>
