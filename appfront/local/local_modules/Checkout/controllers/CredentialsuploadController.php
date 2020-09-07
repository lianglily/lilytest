<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Checkout\controllers;

use fecshop\app\appfront\modules\AppfrontController;
use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class CredentialsuploadController extends AppfrontController
{
    public $enableCsrfValidation = false;

    // cms/staticblock/imageupload
    public function actionImageupload()
    {
        //$imgUrl = 'http://fecshop.appadmin.fancyecommerce.com/assets/9e150533/dwz_jui-master/themes/default/images/logo.png';
        Yii::$service->apply->imageFloder="media/credentials";
        $increment_id=Yii::$app->request->get('order_id');
        Yii::$service->apply->prefix=$increment_id.'-'.Yii::$app->user->identity->id.'-';
        $myOrder = Yii::$service->order->getByIncrementId($increment_id);
        if($myOrder && $myOrder['customer_id'] == Yii::$app->user->identity->id){
	        foreach ($_FILES as $FILE) {
	        	
	            list($imgSavedRelativePath, $imgUrl, $imgPath) = Yii::$service->apply->saveUploadImg($FILE);
	        }
	        //保存凭据

            $myOrder->credentials_payment = $imgSavedRelativePath;
            $res=$myOrder->save();
	        if($res){
	        	exit(json_encode(['err' => 0, 'msg' => $imgUrl]));
	        }
        }
        exit(json_encode(['err' => 1, 'msg' => 'Order No Exist']));
    }
    
    public function actionImageshow(){
    	//判断用户id
    	if (Yii::$app->user->isGuest) {
            exit('error role');
        }
        $imgpath=$msg=Yii::$app->request->get('msg');
        $msg=explode('-',$msg);
        if(!isset($msg[1])||$msg[1]!=Yii::$app->user->identity->id){
        	exit('error role');
        }
        $img = file_get_contents(Yii::$service->apply->getImgUrl('media/credentials/'.$imgpath),true);
        
        //\Yii::$app->response->sendStreamAsFile($img);
		header("Content-Type: image/jpeg;text/html; charset=utf-8");
		echo $img;
		exit;
    }

    public function actionFlashupload()
    {
    }

    public function actionLinkupload()
    {
    }

    public function actionMediaupload()
    {
    }
}
