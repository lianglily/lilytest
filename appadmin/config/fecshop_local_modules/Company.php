<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
return [
    'company' => [ // company 模块
		'class' => '\certmanage\app\appadmin\modules\Company\Module',
		'controllerMap' => [
			'info' => 'certmanage\app\appadmin\modules\Company\controllers\InfoController',
		],
	],
];

