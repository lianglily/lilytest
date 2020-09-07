<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Returnexchange\controllers;

use fecshop\app\appfront\modules\AppfrontController;
use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class InfoController extends AppfrontController
{
    //protected $_registerSuccessRedirectUrlKey = 'customer/account';
    public $enableCsrfValidation = true;
    public $enableCookieValidation = true;
    public function init()
    {
    	
    	parent::init();
    	
    	
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$service->url->redirectByUrlKey('customer/account/login');
        }
        $order_id = Yii::$app->request->get('order_id');
        //获取一个产品对应的订单信息
		$data=$this->getBlock()->getLastData($order_id);
		
        return $this->render($this->action->id,['products'=>$data]);
    }
    public function actionReturns()
    {
    	
    	Yii::$service->page->theme->layoutFile = 'return.php';
        if (Yii::$app->user->isGuest) {
            return Yii::$service->url->redirectByUrlKey('customer/account/login');
        }
        $return_id = Yii::$app->request->get('return_id');
        if(!$return_id){
        	return false;
        }
        
        //获取一个售后订单信息
		$data=$this->getBlock('index')->getReturns($return_id);
		if($data){
			$currency_symbol              = Yii::$service->page->currency->getSymbol($data[0]['order_currency_code']);
		}
        
        return $this->render($this->action->id,['products'=>$data,'currency_symbol'=>$currency_symbol]);
    }
    public function actionSalesreturn()
    {
    	
    	Yii::$service->page->theme->layoutFile = 'productsimple_view.php';
        if (Yii::$app->user->isGuest) {
            return Yii::$service->url->redirectByUrlKey('customer/account/login');
        }
        $items = Yii::$app->request->get('items');
        if(!$items){
        	return false;
        }
        $items=explode(',',$items);
        //获取一个产品对应的订单信息
		$data=$this->getBlock('index')->getSalesReturn($items);
		if($data){
			$currency_symbol              = Yii::$service->page->currency->getSymbol($data[0]['order_currency_code']);
			foreach ($data as $val){
				if($val['retuan_status']!=1||!empty($val['return_unique_id'])){
					return $this->render('view',['products'=>$data,'currency_symbol'=>$currency_symbol]);	
				}
			}
			
		}
        
        return $this->render($this->action->id,['products'=>$data,'currency_symbol'=>$currency_symbol]);
    }
    public function actionSavesalesreturn()
    {
    	
    	
        //获取一个产品对应的订单信息
		$data=$this->getBlock('index')->saveSalesReturn();
		
        echo json_encode($data);
        die();
    }
	public function actionSalesexchange()
    {
    	
        if (Yii::$app->user->isGuest) {
            return Yii::$service->url->redirectByUrlKey('customer/account/login');
        }
         $items = Yii::$app->request->get('items');
        //获取一个产品对应的订单信息
		$data=$this->getBlock('index')->getSalesExchange($items);
        return $this->render($this->action->id,['products'=>$data]);
    }
}
