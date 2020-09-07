<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<div class="list-block margin-top-80" >
    <ul>
		<?php  if(!empty($leftMenuArr) && is_array($leftMenuArr)):  ?>
			<?php foreach($leftMenuArr as $one): ?>
			
			<li class="item-content item-link" onclick="window.open('<?= $one['url'] ?>','_self')">
				<div class="item-media"><i class="icon icon-f7"></i></div>
				<div class="item-inner">
					<div class="item-title">
						<a external href="<?= $one['url'] ?>"  ><?= Yii::$service->page->translate->__($one['name']); ?></a>
					</div>
				</div>
			</li>
			<?php endforeach; ?>
		<?php endif; ?>	
    </ul>
</div>

<div class="account_footer">
	<a   external  href="<?= Yii::$service->url->getUrl("customer/account/logout");?> " class="button button-fill button-bbb">
        <?= Yii::$service->page->translate->__('Logout'); ?>
    </a>
</div>