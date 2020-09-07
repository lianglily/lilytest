<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Returnexchange\block\returns;

use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class View
{
    public function getLastData()
    {
        $order_id = Yii::$app->request->get('return_id');
        if($order_id){
        	$order_info = $this->getCustomerReturnInfo($order_id);
        }else{
        	$order_id = Yii::$app->request->get('return_unique_id');
        	$order_info = $this->getCustomerReturnInfoByUniqueId($order_id);
        }
        $this->breadcrumbs(Yii::$service->page->translate->__('Customer Return Info'));
        return $order_info;
    }
    
    // 面包屑导航
    protected function breadcrumbs($name)
    {
        if (Yii::$app->controller->module->params['customer_order_info_breadcrumbs']) {
            Yii::$service->page->breadcrumbs->addItems(['name' => $name]);
        } else {
            Yii::$service->page->breadcrumbs->active = false;
        }
    }
    
    public function getCustomerReturnInfo($order_id)
    {
        if ($order_id) {
            $order_info = Yii::$service->returnexchange->getReturnInfoById($order_id);
            if (isset($order_info['customer_id']) && !empty($order_info['customer_id'])) {
                $identity = Yii::$app->user->identity;
                $customer_id = $identity->id;
                if ($order_info['customer_id'] == $customer_id) {
                    return $order_info;
                }
            }
        }

        return [];
    }
    public function getCustomerReturnInfoByUniqueId($order_id)
    {
        if ($order_id) {
            $order_info = Yii::$service->returnexchange->getReturnInfoByUniqueId($order_id);
            if (isset($order_info['customer_id']) && !empty($order_info['customer_id'])) {
                $identity = Yii::$app->user->identity;
                $customer_id = $identity->id;
                if ($order_info['customer_id'] == $customer_id) {
                    return $order_info;
                }
            }
        }

        return [];
    }
}
