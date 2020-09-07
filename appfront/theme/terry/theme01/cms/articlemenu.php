<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>

	<div class="block block-account">
		<?php  if(!empty($leftMenuArr) && is_array($leftMenuArr)):  ?>
		<?php foreach($leftMenuArr as $one): ?>
		<?php if($one['type']==0):?>
		<div class="block-title">
			<strong><span><?= Yii::$service->page->translate->__($one['name']); ?></span></strong>
		</div>
		<?php endif; ?>	
		<?php if($one['type']==1):?>
		<div >
			<ul>
					<li <?= $one['current'] ?>>
						<a href="<?= $one['url'] ?>"  ><?= Yii::$service->page->translate->__($one['name']); ?></a>
					</li>
			</ul>
		</div>
		<?php endif; ?>	
		<?php endforeach; ?>
		<?php endif; ?>	
	</div>
</div>