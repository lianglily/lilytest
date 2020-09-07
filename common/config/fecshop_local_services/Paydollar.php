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
    'paydollar' => [
        'class' => 'common\local\local_services\Paydollar',
		# 子服务
		'childService' => [
			'payment' => [
				'class' => 'common\local\local_services\Paydollar\Payment',
				'standard_payment_method' => 'paydollar_standard',
				'secureFile'    => '@common/config/payment/paydollar/lib/SHAPaydollarSecure.php',
				'payserverurls'=>[
					'sanbox' => "https://www.paydollar.com/b2c2/eng/payment/payForm.jsp",
					'env' => 'https://test.paydollar.com/b2cDemo/eng/payment/payForm.jsp',
				],
				'mpsmodes'=>'NIL',
				'datafeed_ip'=>array('202.64.244.236','202.64.244.237','203.105.16.160','203.105.16.161','203.105.16.162','203.105.16.163','203.105.16.164','203.105.16.165','203.105.16.166','203.105.16.167','203.105.16.168','203.105.16.169','203.105.16.170','203.105.16.171','203.105.16.172','203.105.16.173','203.105.16.174','203.105.16.175','203.105.16.176','203.105.16.177','203.105.16.178','203.105.16.179','203.105.16.180','203.105.16.181','203.105.16.182','203.105.16.183','203.105.16.184','203.105.16.185','203.105.16.186','203.105.16.187','203.105.16.188','203.105.16.189','203.105.16.190','203.105.16.191'),

				/*[
					'NIL',
					'SCP',
					'DCC',
					'MCP'
				],*/
				'langs' =>'E-English',
				/*'E-English',
				'C-Traditional Chinese',			
				'X-Simplified Chinese',
				'K-Korean',
				'J-Japanese',
				'T-Thai',
				'F-French',
				'G-German',
				'R-Russian',
				'S-Spanish',
				'V-Vietnamese',*/
				// 跳转到paypal确认后，跳转到fecshop的url
				'return_url' => '@homeUrl/paydollar/paydollar/standard/review',
				// 取消支付后，返回fecshop的url
				'cancel_url' => '@homeUrl/paydollar/paydollar/standard/cancel',
				// 支付成功后，fecshop跳转的url
				'success_redirect_url'    => '@homeUrl/payment/success',
				// paypal发送IPN，fecshop用于接收IPN消息的地址。
				'ipn_url' => '@homeUrl/paydollar/paydollar/standard/ipn',
			],
		]
	],
];