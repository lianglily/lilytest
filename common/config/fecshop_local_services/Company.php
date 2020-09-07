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
    'company' => [
		'class' => 'certmanage\services\Company',
		'childService' => [
			'info' => [
				'class' => 'certmanage\services\company\Info',
			],
		],
	],
];