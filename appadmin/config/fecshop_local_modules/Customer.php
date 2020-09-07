<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
return [
    'customer' => [
	    'controllerMap' => [
			'account' => 'fecusergroup\app\appadmin\modules\Customer\controllers\AccountController',
            'group'    => 'fecusergroup\app\appadmin\modules\Customer\controllers\GroupController',
			'price' => 'fecusergroup\app\appadmin\modules\Customer\controllers\PriceController',
        	'newslettermanageredit' => [
        		'class' => 'appadmin\local\local_modules\Customer\controllers\NewslettermanagereditController',
        	],
        ],
    ],
];

