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
    'ftp' => [
        'class' => 'common\local\local_services\Ftp',
		'host'  => '192.168.42.232' ,//远程服务器地址
        'user'  => 'samsonpaper\samsonftp',//ftp用户名
	    'pass'  =>  'P@ssw0rd654321',//ftp密码
		'port'  => 21
	],
];