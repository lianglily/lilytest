<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<footer id="footer" class="footer-container ">
	<div class="footer-top sidebar">
		<div class="container">
			<div class="row">
				<?=  Yii::$service->cms->staticblock->getStoreContentByIdentify('shopping_guide','appfront') ?>
				
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<?=  Yii::$service->cms->staticblock->getStoreContentByIdentify('copy_right','appfront') ?>
	</div>
</footer>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-173918000-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

 

  gtag('config', 'UA-173918000-1');
</script>
	