<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Creditpay\controllers;

use fecshop\app\appfront\modules\Payment\PaymentController;
use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class CreditpayController extends PaymentController
{
    public $enableCsrfValidation = true;

    /**
     * 支付开始页面.
     */
    public function actionStart()
    {
    	
        $payment_method = isset($this->_order_model['payment_method']) ? $this->_order_model['payment_method'] : '';
        if ($payment_method) {
            $complateUrl = Yii::$service->payment->getStandardSuccessRedirectUrl($payment_method);
            if ($complateUrl) {
                // 登录用户，在支付前清空购物车。
                //if(!Yii::$app->user->isGuest){
                //	Yii::$service->cart->clearCartProductAndCoupon();
                //}
                
				//判断是否creditpay状态，且余额是否足够支付
				//if(Yii::$app->user->identity->credit_status==1 &&  Yii::$service->cart->getCartInfo()['base_grand_total'] <(Yii::$app->user->identity->credit_total - Yii::$app->user->identity->credit_used) ){
				if(Yii::$app->user->identity->credit_status==1 ){
					// 得到购物车的信息，通过购物车信息填写。
					$orderInfo      = Yii::$service->order->getCurrentOrderInfo();
					
					if ($orderInfo['order_status'] != Yii::$service->order->payment_status_pending) {
						Yii::$service->helper->errors->add('The order status is not in pending and you can not pay for item ,you can create a new order to pay');
						return $this->render('standard/ipn', array('message'=>'Pay failed!','increment_id'=>$orderInfo['increment_id'],'error'=>'The order status is not in pending and you can not pay for item ,you can create a new order to pay'));
					}
					
					// 清空购物车
					$innerTransaction = Yii::$app->db->beginTransaction();
					try {
						Yii::$service->creditpay->refund->cancelRefund( $orderInfo['base_grand_total'],Yii::$app->user->identity->id,$orderInfo['increment_id']);
						//Yii::$service->order->orderPaySuccess();
						Yii::$service->order->processing($orderInfo['increment_id'],Yii::$app->user->identity->id);
						$innerTransaction->commit();
						Yii::$service->cart->clearCartProductAndCoupon();
						Yii::$service->order->orderPaymentCompleteEvent($orderInfo['increment_id']);
						Yii::$service->url->redirect($complateUrl);
						exit;
					} catch (\Exception $e) {
						$innerTransaction->rollBack();
					}
					$error=array();
					if($error=Yii::$service->helper->errors->get()){
						return $this->render('standard/ipn', array('message'=>'Pay failed!','increment_id'=>$orderInfo['increment_id'],'error'=>$error[0]));
					}else{
						return $this->render('success', array('message'=>'Pay success!','increment_id'=>$orderInfo['increment_id']));
					}
				}
            }
        }

        $homeUrl = Yii::$service->url->homeUrl();
        Yii::$service->url->redirect($homeUrl);
    }
    
    /**废弃
     * 成功支付页面.
     */
    public function actionSuccess()
    {
        $data = [
            'increment_id' => $this->_increment_id,
        ];
        // 清理购物车中的产品。(游客用户的购物车在成功页面清空)
        if (Yii::$app->user->isGuest) {
            Yii::$service->cart->clearCartProductAndCoupon();
        }
        // 清理session中的当前的increment_id
        Yii::$service->order->removeSessionIncrementId();

        return $this->render('../../payment/checkmoney/success', $data);
    }

    /**
     * IPN消息推送地址
     * IPN过来后，不清除session中的 increment_id ，也不清除购物车
     * 仅仅是更改订单支付状态。
     */
    public function actionIpn()
    {
    }
    
    
}
