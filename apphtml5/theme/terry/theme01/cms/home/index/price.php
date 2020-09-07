<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<p class="proPrice">
	<?php if(isset($special_price) && !empty($special_price)):  ?>
        <?php  $special_price['value'] = Yii::$service->helper->format->number_format($special_price['value']);  ?>
        <span class="bizhong"></span>
        <del orgp="<?= $price['value'] ?>" class="my_shop_price">
            <span class="icon"><?= $price['code'] ?></span><?= $price['value'] ?>
        </del>
		<span class="bizhong"></span>
        <span orgp="<?= $special_price['value'] ?>" class="my_shop_price f14">
            <span class="icon"><?= $special_price['code'] ?></span><?= $special_price['value'] ?>
        </span>
	<?php else: ?>
        <?php  $price['value'] = Yii::$service->helper->format->number_format($price['value']);  ?>
		<span class="bizhong"></span>
        <span orgp="<?= $price['value'] ?>" class="my_shop_price f14">
            <span class="icon"><?= $price['code'] ?></span><?= $price['value'] ?>
        </span>
	<?php endif; ?>
</p>