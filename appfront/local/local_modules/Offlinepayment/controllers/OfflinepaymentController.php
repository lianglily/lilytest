<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Offlinepayment\controllers;

use fecshop\app\appfront\modules\AppfrontController;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class OfflinepaymentController extends AppfrontController
{
    public function actionSuccess()
    {
    	
        $data = $this->getBlock()->getLastData();

        return $this->render($this->action->id, $data);
    }
}
