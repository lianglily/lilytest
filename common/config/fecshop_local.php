<?php
/**
 * FecShop file.
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

/**
 * 本文件在app/web/index.php 处引入。
 * 本配置文件为各个入口部分的公用模块和服务。
 */
$modules = [];
foreach (glob(__DIR__.'/fecshop_local_modules/*.php') as $filename) {
    $modules = array_merge($modules, require($filename));
}
// 服务
$services = [];
foreach (glob(__DIR__.'/fecshop_local_services/*.php') as $filename) {
    $services = array_merge($services, require($filename));
}
// 组件
$components = [
	'elasticsearch' => [
		'class' => 'yii\elasticsearch\Connection',
		'nodes' => [
			['http_address' => '127.0.0.1:9200'],
		],
	],
	'xunsearch' => [
		'class' => 'hightman\xunsearch\Connection', // 此行必须
		'iniDirectory' => '@fecshop/config/xunsearch',    // 搜索 ini 文件目录，默认：@vendor/hightman/xunsearch/app
		'charset' => 'utf-8',   // 指定项目使用的默认编码，默认即时 utf-8，可不指定
	],
];
// param
$params = [];
/**
 * Yii框架的class rewrite重写，这个一般不用，您可以通过这个重写基本上任何的class，但是这种方式是替换，重写的class无法继承原来的class，因此是替换的方式重写
 * Yii framework class rewrite: 文档：http://www.fecmall.com/doc/fecshop-guide/develop/cn-2.0/guide-fecmall-rewrite-func.html#7yii2classclassmapfecmall
 */
$yiiClassMap = [
    // 下面是一个重写的格式例子
    // 'fecshop\app\apphtml5\helper\test\My' => '@apphtml5/helper/My.php'
];
/**
 * Fecmall model 和 block 重写，可以在RewriteMap中配置
 * 文档地址：http://www.fecmall.com/doc/fecshop-guide/develop/cn-2.0/guide-fecmall-rewrite-func.html#8rewritemapblock-model
 */
$fecRewriteMap = [
    // 下面是一个重写的格式例子
    // '\fecshop\app\appfront\modules\Cms\block\home\Index'  => '\fectfurnilife\appfront\modules\Cms\block\home\Index',
	'\fecshop\app\appadmin\modules\Customer\block\account\Index'  => 'appadmin\local\local_modules\Creditpay\block\accountcreditpay\Index',
	'\fecshop\app\appadmin\modules\Sales\block\orderinfo\Manager'  => 'appadmin\local\local_modules\Creditpay\block\orderinfo\Manager',
	'\fecshop\app\appadmin\modules\Sales\block\orderinfo\Manageredit'  => 'appadmin\local\local_modules\Creditpay\block\orderinfo\Manageredit',
	'\fecshop\app\appfront\modules\Payment\block\success\Index'  => 'appfront\local\local_modules\Payment\block\success\Index',
	'\fecshop\app\appfront\modules\Catalog\block\favoriteproduct\Add'  => 'appfront\local\local_modules\Catalog\block\favoriteproduct\Add',
	'\fecshop\app\appadmin\modules\Config\block\email\Manager'  => 'appadmin\local\local_modules\Config\block\email\Manager',
	'\fecshop\app\appfront\modules\Checkout\block\onepage\Index'  => 'appfront\local\local_modules\Checkout\block\onepage\Index',
	'\fecshop\app\appadmin\modules\Config\block\base\Manager'  => 'appadmin\local\local_modules\Config\block\base\Manager',
	'\fecshop\app\appadmin\modules\Config\block\appfrontpayment\Manager'  => 'appadmin\local\local_modules\Creditpay\block\appfrontpayment\Manager',
	'\fecshop\app\appadmin\modules\Config\block\apphtml5payment\Manager'  => 'appadmin\local\local_modules\Creditpay\block\apphtml5payment\Manager',
	'\fecshop\app\apphtml5\modules\Catalog\block\favoriteproduct\Add'  => 'apphtml5\local\local_modules\Catalog\block\favoriteproduct\Add',
	'\fecshop\app\appfront\modules\Customer\block\address\Edit'  => 'appfront\local\local_modules\Customer\block\address\Edit',
	'\fecshop\app\appfront\modules\Checkout\block\onepage\Placeorder'  => 'appfront\local\local_modules\Checkout\block\onepage\Placeorder',
	'\fecshop\app\appfront\modules\Cms\block\article\Index'  => 'appfront\local\local_modules\Cms\block\article\Index',
	'\fecshop\app\appfront\modules\Catalog\block\productsimple\Reviewadd' => 'appfront\local\local_modules\Catalog\block\productsimple\Reviewadd',
	'\fecshop\app\appfront\modules\Catalog\block\productsimple\Reviewlists' => 'appfront\local\local_modules\Catalog\block\productsimple\Reviewlists',
	'\fecshop\app\appfront\modules\Customer\block\editaccount\Index' => 'appfront\local\local_modules\Customer\block\editaccount\Index',
	'\fecshop\app\appfront\modules\Cms\block\ArticleMenu' => 'appfront\local\local_modules\Cms\block\ArticleMenu',	
	'\fecshop\app\appadmin\modules\Catalog\block\productupload\Manager'=>'appadmin\local\local_modules\Catalog\block\productupload\Manager',
	'\fecshop\app\appadmin\modules\Catalog\block\categoryupload\Manager' => 'appadmin\local\local_modules\Catalog\block\categoryupload\Manager',
	'\fecshop\app\apphtml5\modules\Checkout\block\onepage\Index' => 'apphtml5\local\local_modules\Checkout\block\onepage\Index',
	'\fecshop\app\apphtml5\modules\Payment\block\success\Index' => 'apphtml5\local\local_modules\Payment\block\success\Index',
	'\fecshop\app\apphtml5\modules\Cms\block\article\Index' => 'apphtml5\local\local_modules\Cms\block\article\Index',
	'\fecshop\app\apphtml5\modules\Cms\block\home\Index' => 'apphtml5\local\local_modules\Cms\block\home\Index',
	'\fecshop\app\apphtml5\modules\Catalog\block\product\Index' => 'apphtml5\local\local_modules\Catalog\block\product\Index',
	'\appadmin\local\local_modules\Paydollar\block\appfrontpayment\Manager' => 'fecshop\app\appadmin\modules\Config\block\appfrontpayment\Manager',
	'\fecshop\app\appfront\modules\Catalog\block\product\Index'  => '\certmanage\app\appfront\modules\Catalog\block\product\Index',
	'\fecshop\app\appadmin\modules\Config\block\apphtml5store\Manageredit' => 'appadmin\local\local_modules\Config\block\apphtml5store\Manageredit',
	'\fecshop\app\apphtml5\modules\Checkout\block\onepage\Placeorder' => 'apphtml5\local\local_modules\Checkout\block\onepage\Placeorder',
	'\fecshop\app\appfront\modules\Customer\block\account\Index' => 'appfront\local\local_modules\Customer\block\account\Index',
	'\fecshop\app\appfront\modules\Payment\block\paypal\standard\Start' => 'appfront\local\local_modules\Payment\block\paypal\standard\Start',
	'\fecshop\app\appfront\modules\Payment\block\paypal\standard\Placeorder' => 'appfront\local\local_modules\Payment\block\paypal\standard\Placeorder',
];
return [
    'modules'  => $modules,
    'services' => $services,
    'components' => $components,
    'params' => $params,
    'yiiClassMap' => $yiiClassMap,
    'fecRewriteMap' => $fecRewriteMap,
];
