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
    'customer' => [
		# 子服务
		'childService' => [
			'newsletter' => [
				'class' => 'common\local\local_services\customer\Newsletter',
				'childService' => [
					'newslettermysqldb' => [
						'class' => 'common\local\local_services\customer\newsletter\NewsletterMysqldb',
						
					],
				]
			],
			'group' => [
				'class' => 'fecusergroup\services\customer\Group',
			],
		]
	],
];