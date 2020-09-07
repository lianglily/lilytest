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
	    'class' => '\fecshop\app\apphtml5\modules\Customer\Module',
        'controllerMap' => [
        	'ajax' => [
        		'class' => '\fecusergroup\app\apphtml5\modules\Customer\controllers\AjaxController',
        	],
        ],
    ],
];
