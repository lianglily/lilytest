#!/usr/bin/env php
<?php
/**
 * Yii console bootstrap file.
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
error_reporting(E_ALL & ~E_NOTICE & ~E_COMPILE_WARNING ); //除去 E_NOTICE E_COMPILE_WARNING 之外的所有错误信息
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
defined('FEC_APP') or define('FEC_APP', 'console');

require(__DIR__ . '/vendor/autoload.php');
#require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/vendor/fancyecommerce/fecshop/yii/Yii.php');
$fecmall_common_main_local_config = require(__DIR__ . '/common/config/main-local.php');
require(__DIR__ . '/common/config/bootstrap.php');
require(__DIR__ . '/console/config/bootstrap.php');
$config = yii\helpers\ArrayHelper::merge(

    require(__DIR__ . '/common/config/main.php'),
    $fecmall_common_main_local_config,
    require(__DIR__ . '/console/config/main.php'),
    require(__DIR__ . '/console/config/main-local.php'),
	
	# fecshop 公用配置
	require(__DIR__ . '/vendor/fancyecommerce/fecshop/config/fecshop.php'),
	# fecshop 入口配置
	require(__DIR__ . '/vendor/fancyecommerce/fecshop/app/console/config/console.php'),

	# 第三方 公用配置
    require(__DIR__ . '/common/config/fecshop_third.php'),
    # 第三方 入口配置
    require(__DIR__ . '/console/config/fecshop_third.php'),
    
	# 本地 公用配置
	require(__DIR__ . '/common/config/fecshop_local.php'),
	# 本地 入口配置
	require(__DIR__ . '/console/config/fecshop_local.php')
	
);

/**
 * 添加fecshop的服务 ，Yii::$service  ,  将services的配置添加到这个对象。
 * 使用方法：Yii::$service->cms->article;
 * 上面的例子就是获取cms服务的子服务article。
 */
new fecshop\services\Application($config);
$application = new yii\console\Application($config);

$exitCode = $application->run();
exit($exitCode);

