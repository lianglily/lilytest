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
<div class="main container two-columns-left">
	<div class="clear"></div>
	<div class="col-main account_center">
		<div class="std">
		
			<div>
				<?= $content ?>
			</div>
		</div>
	</div>
	<div class="col-left sidebar">
		<?php
			$leftMenu = [
				'class' => 'appfront\local\local_modules\Cms\block\ArticleMenu',
				'view'	=> 'cms/articlemenu.php'
			];
		?>
		<?= Yii::$service->page->widget->render($leftMenu,$this); ?>
	</div>
	<div class="clear"></div>
</div>


	
