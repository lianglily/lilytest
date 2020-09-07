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
class ReportController extends AppfrontController
{
    public $enableCsrfValidation = true;
    public $noCsrfActions = ['add'];

    public function beforeAction($action)
    {
        if(in_array($action->id, $this->noCsrfActions)) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
    	Yii::$service->page->theme->layoutFile = 'productsimple_view.php';
    	$this->blockNamespace='appfront\local\local_modules\Checkout\block';
        if (Yii::$service->store->isAppServerMobile()) {
            $urlPath = 'checkout/cart';
            Yii::$service->store->redirectAppServerMobile($urlPath);
        }
        $data = $this->getBlock()->getLastData();
		
        return $this->render($this->action->id, $data);
    }
    
}
