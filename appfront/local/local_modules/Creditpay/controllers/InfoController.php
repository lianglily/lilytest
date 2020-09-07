<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Creditpay\controllers;

use fecshop\app\appfront\modules\AppfrontController;
use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class InfoController extends AppfrontController
{
    //protected $_registerSuccessRedirectUrlKey = 'customer/account';

    public function init()
    {
        parent::init();
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$service->url->redirectByUrlKey('customer/account/login');
        }
        $data = $this->getBlock()->getLastData();

        return $this->render($this->action->id, $data);
    }

    public function actionView()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$service->url->redirectByUrlKey('customer/account/login');
        }
        
        $data = $this->getBlock()->getLastData();

        return $this->render($this->action->id, $data);
    }
	public function actionApply()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$service->url->redirectByUrlKey('customer/account/login');
        }
        $data = $this->getBlock()->getLastData();

        return $this->render($this->action->id, $data);
    }
	public function actionApplysave()
    {
    	$result=[];
    	
        if (Yii::$app->user->isGuest) {
        	$result['code']="fail1";
        	$result['content']=Yii::$service->page->translate->__("please login first");
        	$result['url']=Yii::$service->url->getUrl('customer/account/login');
            echo json_encode($result);
            die();
        }
        if (Yii::$app->user->identity->credit_status!=-1) {
        	$result['code']="submitted";
        	$result['content']=Yii::$service->page->translate->__("Sorry,You have submitted the application!");
        	$result['url']=Yii::$service->url->getUrl('customer/account/index');
            echo json_encode($result);
            die();
        }
        $data = $this->getBlock('apply')->applysave();
		if(isset($data['status'])){
			$result=$data;
		}else{
			$result['code']="fail";
        	$result['content']=Yii::$service->page->translate->__("An unknown error");
		}
        echo json_encode($result);
        die();
    }
}
