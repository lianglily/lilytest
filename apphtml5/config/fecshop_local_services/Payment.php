<?php
/**
 * FecShop file.
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
return [
    'payment' => [
        'childService' => [
            'alipay' => [
                'devide'             => 'wap' ,  // 填写pc或者wap，pc代表pc机浏览器支付类型，wap代表手机浏览器支付类型 
            ],
        ],
        'paymentConfig' => [        // 支付方式配置
            'standard' => [            // 标准支付类型：在购物车页面进入下单页面，填写支付信息，然后跳转到第三方支付网站的支付类型。
                
                'wxpay_jsapi' => [
                    'label'=> '微信JsApi支付（只能微信内使用）',
                    // 跳转开始URL
                    'start_url'             => '@homeUrl/payment/wxpayjsapi/start',
                    // 支付完成后，跳转的地址。
                    'return_url'            => '@homeUrl/payment/wxpayjsapi/review',
                    // 微信发送消息，接收的地址。
                    'ipn_url'               => '@homeUrl/payment/wxpayjsapi/ipn',
                    'success_redirect_url'  => '@homeUrl/payment/success',
                ], 
                
                'wxpay_h5' => [
                    'label'=> '微信H5支付（可以手机浏览器使用）',
                    // 跳转开始URL
                    'start_url'             => '@homeUrl/payment/wxpayh5/start',
                    // 支付完成后，跳转的地址。
                    'return_url'            => '@homeUrl/payment/wxpayh5/review',
                    // 微信发送消息，接收的地址。
                    'ipn_url'               => '@homeUrl/payment/wxpayh5/ipn',
                    'success_redirect_url'  => '@homeUrl/payment/success',
                ], 
                
                'paydollar_standard' => [
                    // 订单生成后，跳转到支付开始页面的url
                    'start_url'            => '@homeUrl/paydollar/paydollar/standard/start',
                    'label'=> 'PayDollar Payments',
                    // 跳转到paypal确认后，跳转到fecshop的url
                    'return_url' => '@homeUrl/paydollar/paydollar/standard/review',
                    // 取消支付后，返回fecshop的url
                    'cancel_url' => '@homeUrl/paydollar/paydollar/standard/cancel',
                    // 支付成功后，fecshop跳转的url
                    'success_redirect_url'    => '@homeUrl/payment/success',
                    // paypal发送IPN，fecshop用于接收IPN消息的地址。
                    'ipn_url' => '@homeUrl/paydollar/paydollar/standard/ipn',
                ],
                
				'creditpay_standard' => [
                    'label'                => 'Credit Pay',
                    //'image' => ['images/mastercard.png','common'] ,# 支付页面显示的图片。
                    'supplement'               => 'Off-line Money Payments', // 补充信息
                    'style'                    => '<style></style>',  // 补充css，您可以在这里填写一些css
                    'start_url'                => '@homeUrl/creditpay/creditpay/start',    // 点击按钮后，跳转的url，在这个url里面写支付跳转前的提交信息。
                    'success_redirect_url'     => '@homeUrl/payment/success',            // 在支付平台支付成功后，返回的页面
                ],
            ],
            
        ],
    ],
];
