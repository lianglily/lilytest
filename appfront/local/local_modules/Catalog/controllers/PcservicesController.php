<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Catalog\controllers;

use fecshop\app\appfront\modules\AppfrontController;
use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class PcservicesController extends AppfrontController
{
    public function actionIndex()
    {
		Yii::$service->page->breadcrumbs->addItems(['name' => Yii::$service->page->translate->__('pcservices')]);
        return $this->render($this->action->id,['name'=> Yii::$service->page->translate->__('pcservices')]);
    }
    
}
