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
    'favorite' => [
        'class' => 'common\local\local_services\Favorite',
	],
	'childService' => [
		'favoritemysqldb' => [
			'class' => 'common\local\local_services\favorite\FavoriteMysqldb',
		],
		'favoritemongodb' => [
			'class' => 'common\local\local_services\favorite\FavoriteMongodb',
		],
	],
];