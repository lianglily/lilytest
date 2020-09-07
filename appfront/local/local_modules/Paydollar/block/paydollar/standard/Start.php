<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Paydollar\block\paydollar\standard;

use Yii;
use yii\base\InvalidConfigException;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Start
{
    public function startPayment(){
		$data=array();
		// 得到购物车的信息，通过购物车信息填写。
        $orderInfo      = Yii::$service->order->getCurrentOrderInfo();
        //var_dump($orderInfo);
        $currency       = $orderInfo['order_currency_code'];
		
        $grand_total    = Yii::$service->helper->format->number_format($orderInfo['grand_total']);
        //$subtotal       = Yii::$service->helper->format->number_format($orderInfo['subtotal']);
        //$shipping_total = Yii::$service->helper->format->number_format($orderInfo['shipping_total']);
        //$discount_amount= $orderInfo['subtotal_with_discount'] ? $orderInfo['subtotal_with_discount'] : 0;
        $subtotal = $grand_total;

		$env = Yii::$app->store->get('payment_paydollar', 'paydollar_env');

		//paydollar 服务器地址
		if ($env == Yii::$service->payment->env_sanbox) {
			$data['action'] = Yii::$service->paydollar->payment->payserverurls['env'];
		} else {
			$data['action'] = Yii::$service->paydollar->payment->payserverurls['sanbox'];
		}

		$data['mpsMode'] = Yii::$app->store->get('payment_paydollar', 'paydollar_mpsmode');

		$currCode=$data['currCode'] =  Yii::$service->paydollar->payment->getCurrencyIso($currency);
		
		$amount=$data['amount'] = $subtotal;

		$data['lang'] =Yii::$service->paydollar->payment->_getPayLang(Yii::$service->store->currentLang);
		
		$merchantId=$data ['merchantId']= Yii::$app->store->get('payment_paydollar', 'paydollar_account');
		
		$orderRef=$data ['orderRef']=Yii::$service->order->getSessionIncrementId();

		$payType=$data ['payType'] =Yii::$app->store->get('payment_paydollar', 'paydollar_paytype');
		
		$data ['payMethod']=Yii::$app->store->get('payment_paydollar', 'paydollar_paymethod');
			/*array('ALL','CC','VISA','Master','JCB','AMEX','Diners','PPS','PAYPAL','CHINAPAY','ALIPAY','TENPAY','99BILL','MEPS','SCB','BPM','KTB','UOB','KRUNGSRIONLINE','TMB','IBANKING','BancNet','GCash','SMARTMONEY','PAYCASH');*/
		
		$data ['failUrl']=Yii::$service->paydollar->payment->getIpnUrl();

		$data ['successUrl']=Yii::$service->paydollar->payment->getSuccessUrl();

		$data ['cancelUrl']=Yii::$service->paydollar->payment->getCancelUrl();

		$data ['remark']="";

		$data ['redirect']=Yii::$service->url->homeUrl();

		$data ['oriCountry']=Yii::$app->store->get('payment_paydollar', 'paydollar_oricountry');

		$data ['destCountry']=Yii::$app->store->get('payment_paydollar', 'paydollar_destcountry');

		$secureHashSecret=$data ['secureHashSecret']=Yii::$app->store->get('payment_paydollar', 'paydollar_signature');
		if($secureHashSecret){
			$paydollarSecureFile = Yii::getAlias(Yii::$service->paydollar->payment->secureFile);
	        if (!is_file($paydollarSecureFile)) {
	            throw new InvalidConfigException('padollar secure file:['.$paydollarSecureFile.'] is not exist');
	        }
			
			require_once($paydollarSecureFile);
			$paydollarSecure = new \SHAPaydollarSecure();
			$secureHash = $paydollarSecure->generatePaymentSecureHash ( $merchantId, $orderRef, $currCode, $amount, $payType, $secureHashSecret );
			$data ['secureHash'] = $secureHash;
		}else{
			$data ['secureHash'] = '';
		}
		
        return $data;



	}
    public function startPayment1()
    {
        $methodName_ = 'SetExpressCheckout';
        $nvpStr_ = Yii::$service->paydollar->payment->getStandardTokenNvpStr();
        //echo $nvpStr_;exit;
        // 通过接口，得到token信息
        $checkoutReturn = Yii::$service->paydollar->payment->PPHttpPost5($methodName_, $nvpStr_);
		
        //var_dump($checkoutReturn);exit;
        if (strtolower($checkoutReturn['ACK']) == 'success') {
            $token = $checkoutReturn['TOKEN'];
            $increment_id = Yii::$service->order->getSessionIncrementId();
            # 将token写入到订单中
            Yii::$service->order->updateTokenByIncrementId($increment_id,$token);
            $redirectUrl = Yii::$service->payment->paypal->getStandardCheckoutUrl($token);
            Yii::$service->url->redirect($redirectUrl);
            return;
        } elseif (strtolower($checkoutReturn['ACK']) == 'failure') {
            echo $checkoutReturn['L_LONGMESSAGE0'];
        } else {
            var_dump($checkoutReturn);
        }
    }
}
