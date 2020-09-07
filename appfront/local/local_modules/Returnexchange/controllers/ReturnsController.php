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
class ReturnsController extends AppfrontController
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
    	
    	Yii::$service->page->theme->layoutFile = 'return.php';
        if (Yii::$app->user->isGuest) {
            return Yii::$service->url->redirectByUrlKey('customer/account/login');
        }
       $data = $this->getBlock()->getLastData();

       return $this->render($this->action->id, $data);
    }
    
    public function actionView()
    {
    	
    	Yii::$service->page->theme->layoutFile = 'return.php';
        if (Yii::$app->user->isGuest) {
            return Yii::$service->url->redirectByUrlKey('customer/account/login');
        }
        $data = $this->getBlock()->getLastData();

        return $this->render($this->action->id, $data);
    }
    
}
