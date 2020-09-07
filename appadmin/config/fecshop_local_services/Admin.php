<?php
/**
 * FecShop file.
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
return [
    'admin' => [
        // 子服务
        'childService' => [
            'urlKey' => [
                'urlKeyTags' => [
                    'blog_article' 								=> 'Blog-Article',
					'customer_group' => 'Customer-Group',
					'cert_file' => 'Cert-File',
					'company_info' => 'Company-Info',
                ],
            ],

            'menu' => [
                /*'menuConfig' => [
                    'blog' => [
                        'label' => 'Blog',
                        'child' => [
                            'article' => [
                                'label' => 'Article',
                                'child' => [
                                    'article_manager' => [
                                        'label' => 'Manager Article',
                                        'url_key' => '/blog/article/manager',
                                    ],
                                ],
                            ],
                        ],
                    ],

                ],
				*/
				'menuConfig' => [
					'sales' => [
					'label' => 'Mall Manager',
					'child' => [
						'customer' => [
								'label' => 'Customer',
								'child' => [
									'creditpay' => [
										'label' => 'Manager Creditpay',
										'url_key' => '/creditpay/accountcreditpay/apply',
									],
									'group' => [
										'label' => 'Manager Account Group',
										'url_key' => '/customer/group/manager',
									],
									'price' => [
										'label' => 'Manager Product Price',
										'url_key' => '/customer/price/index',
									],
								],
							],
						'return' => [
								'label' => 'Return',
								'child' => [
									'returnexchange' => [
										'label' => 'Return Manage',
										'url_key' => '/returnexchange/returnexchange/manager',
									],
									
								],
							],
						],	
					],	
					'catalog' => [
						'child' => [
							'product_manager' => [
								'label' => 'Manager Product',
								'child' => [
									// 三级类
									'file' => [
										'label' => 'Manager Cert File',
                                        'url_key' => '/cert/file/manager',
									],
									'company' => [
										'label' => 'Manager Company Info',
										'url_key' => '/company/info/manager',
									],
								]	
							],
						]
					],
                    'config' => [
                        'label' => 'Website Config',
                        'child' => [
              
                             'payment_config' => [
                                'label' => 'Payment Param Config',
                                'child' => [
                                    'payment_paydollar' => [
                                        'label' => 'PayDollar Config',
                                        'url_key' => '/paydollar/paymentpaydollar/manager',
                                    ],
									'payment_paycredit' => [
                                        'label' => 'PayCredit Config',
                                        'url_key' => '/creditpay/paymentcreditpay/manager',
                                    ],
                                    'payment_banktransfer' => [
                                        'label' => 'Bank Transfer Config',
                                        'url_key' => '/payment/paymentbanktransfer/manager',
                                    ],
									'payment_FPS' => [
                                        'label' => 'FPS Config',
                                        'url_key' => '/payment/paymentfps/manager',
                                    ],
                                ],
                            ],
                        ],
                    ],

                ],
            ],
            
        ],
    ],
];