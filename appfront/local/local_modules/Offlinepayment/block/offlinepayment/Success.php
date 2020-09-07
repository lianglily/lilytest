<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Offlinepayment\block\offlinepayment;

use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Success
{
    public function getLastData()
    {
        $increment_id = Yii::$service->order->getSessionIncrementId();
        if (!$increment_id) {
            Yii::$service->url->redirectHome();
        }
		//Yii::$service->order->processing($increment_id,Yii::$app->user->identity->id);
        //$order = Yii::$service->order->getInfoByIncrementId($increment_id);
        // 清空购物车。这里针对的是未登录用户进行购物车清空。
        if (Yii::$app->user->isGuest) {
            Yii::$service->cart->clearCartProductAndCoupon();
        }
        // 清空session中存储的当前订单编号。
        Yii::$service->order->removeSessionIncrementId();

        return [
            'increment_id' => $increment_id,
            //'order'            => $order,
        ];
    }
}