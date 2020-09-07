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
    'apply' => [
        'class' => 'common\local\local_services\Apply',
        'commonBaseDir' => '@appimage/common',
		# 子服务
		'childService' => [
			'attachment' => [
				'class' => 'common\local\local_services\apply\Attachment',
			],
		]
	],
];