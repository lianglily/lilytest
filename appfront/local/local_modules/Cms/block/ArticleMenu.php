<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Cms\block;

use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class ArticleMenu
{
	
    public function getLastData()
    {
        $leftMenu = \Yii::$app->getModule('cms')->params['articleMenu'];
        $leftMenuArr = [];
        if (is_array($leftMenu) && !empty($leftMenu)) {
            $current_url_key = $_SERVER['PHP_SELF'];
            
            $arr = explode('/', $current_url_key);
            if (count($arr) >= 3) {
                $current_url_key_sub = $arr[2];
            }else if(count($arr) >= 2){
            	$current_url_key_sub = $arr[1];
            } else {
                $current_url_key_sub = $arr[0];
            }
			
            foreach ($leftMenu as $key => $name) {
            	$leftMenuArr[] = [
                    'name'    => $key,
                    'type'   => 0,
                ];
            	foreach ($name as $menu_name => $menu_url_key){
	                $currentClass = '';
	                $url = Yii::$service->url->getUrl($menu_url_key);
	                if (strstr($menu_url_key, $current_url_key_sub)) {
	                    //echo "$menu_url_key,$current_url_key_sub <br>";
	                    $currentClass = 'class="current"';
	                }
	                $leftMenuArr[] = [
	                    'name'    => $menu_name,
	                    'url'    => $url,
	                    'current'=> $currentClass,
	                    'type'   => 1,
	                ];
            	}
            }
        }
        //var_dump($leftMenuArr);
        return [
            'leftMenuArr' => $leftMenuArr,
        ];
    }
}
