<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
return [
    'cert' => [ // cert 模块
		'class' => '\certmanage\app\appadmin\modules\Cert\Module',
		'controllerMap' => [
			'file' => 'certmanage\app\appadmin\modules\Cert\controllers\FileController',
		],
	],
];

