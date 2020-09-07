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
    'cart' => [
    	//'class' => 'common\local\local_services\Cart',
    	'childService' => [
            'quoteItem' => [
	                'class' => 'common\local\local_services\cart\QuoteItem',
            ],
        ],
        
    ],    
];
