<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title><?= Yii::$app->store->get('base_info', 'default_meta_title')['default_meta_title_'.Yii::$service->store->currentLangCode]?> <?= \Yii::$app->view->title; ?></title>
<link rel="shortcut icon" href="<?=  Yii::$service->url->getUrl('favicon.ico'); ?>">
<link rel="apple-touch-icon" href="<?=  Yii::$service->url->getUrl('apple-touch-icon.png'); ?>">
<meta name="robots" content="INDEX,FOLLOW" />
<?php $parentThis->head() ?>
<script type="application/ld+json">
    var title={
      "@context": "https://schema.org/",
      "@type": "Recipe",
      "name": "<?= \Yii::$app->view->title; ?>",
      "author": {
        "@type": "Person",
        "name": "burotech"
      },
	  "image": "<?=  Yii::$service->url->getUrl('favicon.ico'); ?>",
      "datePublished": "2018-03-10",
      "description": "<?= \Yii::$app->view->title; ?>",
      "prepTime": "PT20M"
    };
</script>
