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
    'returnexchange' => [
    	'class' => 'common\local\local_services\Returnexchange',
		'childService' => [
            'item' => [
                'class' => 'common\local\local_services\returnexchange\Item',
            ],
        ],
    ],    
];
