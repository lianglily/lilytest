<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 *
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
return [
    'cert' => [
		'class' => 'certmanage\services\Cert',
		'childService' => [
			'file' => [
				'class' => 'certmanage\services\cert\File',
			],
		],
	],
];