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
    'shipping' => [
    	'class' => 'common\local\local_services\Shipping',
        // Shipping的运费，是表格的形式录入，shippingCsvDir是存放运费表格的文件路径。
        'shippingCsvDir' => '@common/config/shipping',
        'volumeWeightCoefficient' => 5000,
        'shippingConfig' => [
            'free_shipping'=> [  // 免运费
                'label'=> 'Commercial District Free shipping(Over HK$500)',
                'name' => 'HKBRAM',
                'formula' => '100',  // 这里填写公式，该值代表免邮。
                // 国家限制，当国家限制不满足，则该物流不可用 （如果没有国家限制可以去掉）
                'country' => [  // 这里填写(允许|不允许)使用的国家简码，如果您没有这方面的约束，请去掉，去掉后代表没有任何约束
                    'type' => 'not_allow',  // allow代表只允许下面的国家使用该shipping，not_allow代表不允许下面国家使用该shipping countryCode,regionCode,cityCode
                    'countrycode' => [
                        4
                    ],
                    'regioncode' => [
                        1
                    ]
                ],
                // 重量限制，当重量超出这个范围，该物流将不可用 （如果没有重量限制可以去掉）
                'total' => [
                    'min' => 0,
                    'max' => 500,
                ],
            ],
            'free_shipping_1'=> [  // 免运费
                'label'=> 'Commercial District Free shipping(Over HK$500)',
                'name' => 'HKBRAM',
                'formula' => '0',  // 这里填写公式，该值代表免邮。
                // 国家限制，当国家限制不满足，则该物流不可用 （如果没有国家限制可以去掉）
                'country' => [  // 这里填写(允许|不允许)使用的国家简码，如果您没有这方面的约束，请去掉，去掉后代表没有任何约束
                    'type' => 'not_allow',  // allow代表只允许下面的国家使用该shipping，not_allow代表不允许下面国家使用该shipping countryCode,regionCode,cityCode
                    'countrycode' => [
                        4
                    ],
                    'regioncode' => [
                        1
                    ]
                ],
                // 重量限制，当重量超出这个范围，该物流将不可用 （如果没有重量限制可以去掉）
                'total' => [
                    'min' => 500,
                ],
            ],
            'free_shippings'=> [  // 免运费
                'label'=> 'Remote Area Free shipping(Over HK$800)',
                'name' => 'HKBRAM',
                'formula' => '200',  // 这里填写公式，该值代表免邮。
                // 国家限制，当国家限制不满足，则该物流不可用 （如果没有国家限制可以去掉）
                'country' => [  // 这里填写(允许|不允许)使用的国家简码，如果您没有这方面的约束，请去掉，去掉后代表没有任何约束
                    'type' => 'allow',  // allow代表只允许下面的国家使用该shipping，not_allow代表不允许下面国家使用该shipping countryCode,regionCode,cityCode
                    'countrycode' => [
                        4
                    ],
                    'regioncode' => [
                        1
                    ]
                ],
                // 重量限制，当重量超出这个范围，该物流将不可用 （如果没有重量限制可以去掉）
                'total' => [
                    'min' => 0,
                    'max' => 800,
                ],
            ],
            'free_shippings_1'=> [  // 免运费
                'label'=> 'Remote Area Free shipping(Over HK$800)',
                'name' => 'HKBRAM',
                'formula' => '0',  // 这里填写公式，该值代表免邮。
                // 国家限制，当国家限制不满足，则该物流不可用 （如果没有国家限制可以去掉）
                'country' => [  // 这里填写(允许|不允许)使用的国家简码，如果您没有这方面的约束，请去掉，去掉后代表没有任何约束
                    'type' => 'allow',  // allow代表只允许下面的国家使用该shipping，not_allow代表不允许下面国家使用该shipping countryCode,regionCode,cityCode
                    'countrycode' => [
                        4
                    ],
                    'regioncode' => [
                        1
                    ]
                ],
                // 重量限制，当重量超出这个范围，该物流将不可用 （如果没有重量限制可以去掉）
                'total' => [
                    'min' => 800,
                ],
            ],
            /*'free_shippings'=> [  // 免运费
                'label'=> 'Remote Area Free shipping(Over HK$800)',
                'name' => 'HKBRAM',
                'formula' => '200',  // 这里填写公式，该值代表免邮。
                // 国家限制，当国家限制不满足，则该物流不可用 （如果没有国家限制可以去掉）
                'country' => [  // 这里填写(允许|不允许)使用的国家简码，如果您没有这方面的约束，请去掉，去掉后代表没有任何约束
                    'type' => 'allow',  // allow代表只允许下面的国家使用该shipping，not_allow代表不允许下面国家使用该shipping countryCode,regionCode,cityCode
                    'countrycode' => [
                        1
                    ],
                    'regioncode' => [
                        4
                    ]
                ],
                // 重量限制，当重量超出这个范围，该物流将不可用 （如果没有重量限制可以去掉）
                'total' => [
                    'min' => 0,
                    'max' => 800,
                ],
            ],
            'free_shippings_1'=> [  // 免运费
                'label'=> 'Remote Area Free shipping(Over HK$800)',
                'name' => 'HKBRAM',
                'formula' => '0',  // 这里填写公式，该值代表免邮。
                // 国家限制，当国家限制不满足，则该物流不可用 （如果没有国家限制可以去掉）
                'country' => [  // 这里填写(允许|不允许)使用的国家简码，如果您没有这方面的约束，请去掉，去掉后代表没有任何约束
                    'type' => 'allow',  // allow代表只允许下面的国家使用该shipping，not_allow代表不允许下面国家使用该shipping countryCode,regionCode,cityCode
                    'countrycode' => [
                        1
                    ],
                    'regioncode' => [
                        4
                    ]
                ],
                // 重量限制，当重量超出这个范围，该物流将不可用 （如果没有重量限制可以去掉）
                'total' => [
                    'min' => 800,
                ],
            ],*/
           /* 'middle_shipping'=> [  // xxx shipping
                'label'=> 'middle shipping( 6-15 work days)',
                'name' => 'HKBRAM',
                'formula' => '[weight] * 0.5',  // 这里填写公式
                // 对于国家和重量限制，如果没有，则不用填写，如果有，参考上面的样式填写
            ],
            'fast_shipping'=> [
                'label'=> 'Free Commercial District Over HK$500',
                'name' => 'HKDHL',
                'formula' => 'csv', // 请将文件名字的命名写入，譬如： fast_shipping.csv
                'csv_content' => '', // 这个由shipping动态从文件中获取内容
                // 对于国家和重量限制，如果没有，则不用填写，如果有，参考上面的样式填写
            ],
            'fast_shipping_1'=> [
                'label'=> 'Free Commercial District Over HK$800',
                'name' => 'HKDHL',
                'formula' => 'csv', // 请将文件名字的命名写入，譬如： fast_shipping.csv
                'csv_content' => '', // 这个由shipping动态从文件中获取内容
                // 对于国家和重量限制，如果没有，则不用填写，如果有，参考上面的样式填写
            ],*/
        ],
        'area' => json_decode('[
  {
    "name": "港島",
    "translate": "港島",
    "id": 1,
    "cityList": [
      {
        "name": "東區",
        "translate": "東區",
        "id": 1,
        "areaList": [
          {
            "name": "北角",
            "translate": "北角",
            "id": 1,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "天后",
            "translate": "天后",
            "id": 2,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "鰂魚涌",
            "translate": "鰂魚涌",
            "id": 3,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "太古",
            "translate": "太古",
            "id": 4,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "西灣河",
            "translate": "西灣河",
            "id": 5,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "筲簊灣",
            "translate": "筲簊灣",
            "id": 6,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "小西灣",
            "translate": "小西灣",
            "id": 7,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "杏花邨",
            "translate": "杏花邨",
            "id": 8,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "柴灣",
            "translate": "柴灣",
            "id": 9,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          }
        ]
      },
      {
        "name": "中西區",
        "translate": "中西區",
        "id": 2,
        "areaList": [
          {
            "name": "堅尼地城",
            "translate": "堅尼地城",
            "id": 1,
            "weekday": 48907,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "石塘咀",
            "translate": "石塘咀",
            "id": 2,
            "weekday": 48907,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "西營盤",
            "translate": "西營盤",
            "id": 3,
            "weekday": 48907,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "上環",
            "translate": "上環",
            "id": 4,
            "weekday": 48907,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "中環",
            "translate": "中環",
            "id": 5,
            "weekday": 48907,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "金鐘",
            "translate": "金鐘",
            "id": 6,
            "weekday": 48907,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "山頂",
            "translate": "山頂",
            "id": 7,
            "weekday": 48907,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "西環",
            "translate": "西環",
            "id": 8,
            "weekday": 48907,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "薄扶林",
            "translate": "薄扶林",
            "id": 9,
            "weekday": 48907,
            "times": "*",
            "weight": "*"
          }
        ]
      },
      {
        "name": "灣仔區",
        "translate": "灣仔區",
        "id": 3,
        "areaList": [
          {
            "name": "灣仔",
            "translate": "灣仔",
            "id": 1,
            "weekday": 48917,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "銅鑼灣",
            "translate": "銅鑼灣",
            "id": 2,
            "weekday": 48917,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "砲台山",
            "translate": "砲台山",
            "id": 3,
            "weekday": 48917,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "跑馬地",
            "translate": "跑馬地",
            "id": 4,
            "weekday": 48917,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "大坑",
            "translate": "大坑",
            "id": 5,
            "weekday": 48917,
            "times": "*",
            "weight": "*"
          }
        ]
      },
      {
        "name": "南區",
        "translate": "南區",
        "id": 4,
        "areaList": [
          {
            "name": "香港仔",
            "translate": "香港仔",
            "id": 1,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "黃竹坑",
            "translate": "黃竹坑",
            "id": 2,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "鴨利洲",
            "translate": "鴨利洲",
            "id": 3,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "數碼港",
            "translate": "數碼港",
            "id": 4,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "淺水灣",
            "translate": "淺水灣",
            "id": 5,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "赤柱",
            "translate": "赤柱",
            "id": 6,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          }
        ]
      }
    ]
  },
  {
    "name": "九龍",
    "translate": "九龍",
    "id": 2,
    "cityList": [
      {
        "name": "油尖旺",
        "translate": "油尖旺",
        "id": 1,
        "areaList": [
          {
            "name": "尖沙咀",
            "translate": "尖沙咀",
            "id": 1,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "油麻地",
            "translate": "油麻地",
            "id": 2,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "旺角",
            "translate": "旺角",
            "id": 3,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "旺角東",
            "translate": "旺角東",
            "id": 4,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "太子",
            "translate": "太子",
            "id": 5,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "大角咀",
            "translate": "大角咀",
            "id": 6,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "佐敦",
            "translate": "佐敦",
            "id": 7,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "柯士甸",
            "translate": "柯士甸",
            "id": 8,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "尖東",
            "translate": "尖東",
            "id": 9,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          }
        ]
      },
      {
        "name": "深水埗",
        "translate": "深水埗",
        "id": 2,
        "areaList": [
          {
            "name": "美孚",
            "translate": "美孚",
            "id": 1,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "荔枝角",
            "translate": "荔枝角",
            "id": 2,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "長沙灣",
            "translate": "長沙灣",
            "id": 3,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "深水埗",
            "translate": "深水埗",
            "id": 4,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "石硤尾",
            "translate": "石硤尾",
            "id": 5,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "昂船州",
            "translate": "昂船州",
            "id": 6,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "南昌",
            "translate": "南昌",
            "id": 7,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          }
        ]
      },
      {
        "name": "九龍城",
        "translate": "九龍城",
        "id": 3,
        "areaList": [
          {
            "name": "紅磡",
            "translate": "紅磡",
            "id": 1,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "土瓜灣",
            "translate": "土瓜灣",
            "id": 2,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "馬頭角",
            "translate": "馬頭角",
            "id": 3,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "馬頭圍",
            "translate": "馬頭圍",
            "id": 4,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "啟德",
            "translate": "啟德",
            "id": 5,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "九龍城",
            "translate": "九龍城",
            "id": 6,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "何文田",
            "translate": "何文田",
            "id": 7,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "九龍塘",
            "translate": "九龍塘",
            "id": 8,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "筆架山",
            "translate": "筆架山",
            "id": 9,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          }
        ]
      },
      {
        "name": "黃大仙",
        "translate": "黃大仙",
        "id": 4,
        "areaList": [
          {
            "name": "新蒲崗",
            "translate": "新蒲崗",
            "id": 1,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "黃大仙",
            "translate": "黃大仙",
            "id": 2,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "東頭",
            "translate": "東頭",
            "id": 3,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "橫頭磡",
            "translate": "橫頭磡",
            "id": 4,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "樂富",
            "translate": "樂富",
            "id": 5,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "鑽石山",
            "translate": "鑽石山",
            "id": 6,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "慈雲山",
            "translate": "慈雲山",
            "id": 7,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "牛池灣",
            "translate": "牛池灣",
            "id": 8,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          }
        ]
      },
      {
        "name": "觀塘",
        "translate": "觀塘",
        "id": 5,
        "areaList": [
          {
            "name": "彩虹",
            "translate": "彩虹",
            "id": 1,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "九龍灣",
            "translate": "九龍灣",
            "id": 2,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "牛頭角",
            "translate": "牛頭角",
            "id": 3,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "觀塘",
            "translate": "觀塘",
            "id": 4,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "秀茂坪",
            "translate": "秀茂坪",
            "id": 5,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "藍田",
            "translate": "藍田",
            "id": 6,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "油塘",
            "translate": "油塘",
            "id": 7,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "鯉魚門",
            "translate": "鯉魚門",
            "id": 8,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          }
        ]
      },
      {
        "name": "葵全青",
        "translate": "葵全青",
        "id": 6,
        "areaList": [
          {
            "name": "葵涌",
            "translate": "葵涌",
            "id": 1,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "青衣",
            "translate": "青衣",
            "id": 2,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "荃灣",
            "translate": "荃灣",
            "id": 3,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "大窩口",
            "translate": "大窩口",
            "id": 4,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "葵興",
            "translate": "葵興",
            "id": 5,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "葵芳",
            "translate": "葵芳",
            "id": 6,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "荔景",
            "translate": "荔景",
            "id": 7,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "荃灣西",
            "translate": "荃灣西",
            "id": 8,
            "weekday": 48927,
            "times": "*",
            "weight": "*"
          }
        ]
      }
    ]
  },
  {
    "name": "新界",
    "translate": "新界",
    "id": 3,
    "cityList": [
      {
        "name": "北區",
        "translate": "北區",
        "id": 1,
        "areaList": [
          {
            "name": "上水",
            "translate": "上水",
            "id": 1,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "粉嶺",
            "translate": "粉嶺",
            "id": 2,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "聯合墟",
            "translate": "聯合墟",
            "id": 3,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "石湖墟",
            "translate": "石湖墟",
            "id": 4,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "沙頭角",
            "translate": "沙頭角",
            "id": 5,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          }
        ]
      },
      {
        "name": "大埔",
        "translate": "大埔",
        "id": 2,
        "areaList": [
          {
            "name": "大埔墟",
            "translate": "大埔墟",
            "id": 1,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "大埔",
            "translate": "大埔",
            "id": 2,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "太和",
            "translate": "太和",
            "id": 3,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          }
        ]
      },
      {
        "name": "沙田",
        "translate": "沙田",
        "id": 3,
        "areaList": [
          {
            "name": "大學",
            "translate": "大學",
            "id": 1,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "沙田",
            "translate": "沙田",
            "id": 2,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "大圍",
            "translate": "大圍",
            "id": 3,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "火炭",
            "translate": "火炭",
            "id": 4,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "馬料水",
            "translate": "馬料水",
            "id": 5,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "烏溪沙",
            "translate": "烏溪沙",
            "id": 6,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "馬鞍山",
            "translate": "馬鞍山",
            "id": 7,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "第一城",
            "translate": "第一城",
            "id": 8,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "石門",
            "translate": "石門",
            "id": 9,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "沙田圍",
            "translate": "沙田圍",
            "id": 10,
            "weekday": 48905,
            "times": "*",
            "weight": "*"
          }
        ]
      },
      {
        "name": "屯門/元朗",
        "translate": "屯門/元朗",
        "id": 4,
        "areaList": [
          {
            "name": "屯門",
            "translate": "屯門",
            "id": 1,
            "weekday": 48898,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "元朗",
            "translate": "元朗",
            "id": 2,
            "weekday": 48898,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "天水圍",
            "translate": "天水圍",
            "id": 3,
            "weekday": 48898,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "錦上路",
            "translate": "錦上路",
            "id": 4,
            "weekday": 48898,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "洪水橋",
            "translate": "洪水橋",
            "id": 5,
            "weekday": 48898,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "流浮山",
            "translate": "流浮山",
            "id": 6,
            "weekday": 48898,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "落馬洲",
            "translate": "落馬洲",
            "id": 7,
            "weekday": 48898,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "朗屏",
            "translate": "朗屏",
            "id": 8,
            "weekday": 48898,
            "times": "*",
            "weight": "*"
          }
        ]
      },
      {
        "name": "西貢",
        "translate": "西貢",
        "id": 5,
        "areaList": [
          {
            "name": "調景嶺",
            "translate": "調景嶺",
            "id": 1,
            "weekday": 48912,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "將軍澳",
            "translate": "將軍澳",
            "id": 2,
            "weekday": 48912,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "坑口",
            "translate": "坑口",
            "id": 3,
            "weekday": 48912,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "寶琳",
            "translate": "寶琳",
            "id": 4,
            "weekday": 48912,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "清水灣",
            "translate": "清水灣",
            "id": 5,
            "weekday": 48912,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "西貢",
            "translate": "西貢",
            "id": 6,
            "weekday": 48912,
            "times": "*",
            "weight": "*"
          }
        ]
      }
    ]
  },
  {
    "name": "大嶼山",
    "translate": "大嶼山",
    "id": 4,
    "cityList": [
      {
        "name": "東涌",
        "translate": "東涌",
        "id": 1,
        "areaList": [
          {
            "name": "機場",
            "translate": "機場",
            "id": 1,
            "weekday": 16644,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "博覽館",
            "translate": "博覽館",
            "id": 2,
            "weekday": 16644,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "東涌",
            "translate": "東涌",
            "id": 3,
            "weekday": 16644,
            "times": "*",
            "weight": "*"
          },
          {
            "name": "欣澳",
            "translate": "欣澳",
            "id": 4,
            "weekday": 16644,
            "times": "*",
            "weight": "*"
          }
        ]
      }
    ]
  }
]',true)
        /** 该配置废弃，因为默认的shipping method，可能是不满足条件的。
         * 目前的default shipping method，从 可用物流数组 中取第一个作为 默认物流。
         * 该值必须在上面的配置 $shippingConfig中存在，如果不存在，则返回为空。
         */
        //'defaultShippingMethod' => [
        //    'enable'    => true, // 如果值为true，那么用户在cart生成的时候，就会填写上默认的货运方式。
        //    'shipping'  => 'fast_shipping',
        //],
    ],
];
