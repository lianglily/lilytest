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
    'creditpay' => [
        'class' => 'common\local\local_services\Creditpay',
		# 子服务
		'childService' => [
			'refund' => [
				'class' => 'common\local\local_services\creditpay\Refund',
				'creditpay_payment' => ['creditpay_standard'],
				'creditpay_refund_status_notyet' => [0],
				'creditpay_refund_status_yet' => [1],
				'creditpay_refund_status_someyet' => [2],
				'creditpay_refund_status_cancelyet' => [3],
			],
			'customer' => [
				'class' => 'common\local\local_services\creditpay\Customer',
			],
			'attr' => [
				'class' =>'common\local\local_services\creditpay\Attr',
				'childService' => [
					'attrmysqldb' => [
						'class' => 'common\local\local_services\creditpay\attr\AttrMysqldb',
					],
					'attrmongodb' => [
						'class' => 'common\local\local_services\creditpay\attr\AttrMongodb',
					],
				],
			],
		]
	],
];