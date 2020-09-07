<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appadmin\local\local_modules\Customer\block\newslettermanageredit;

use fec\helpers\CUrl;
use fec\helpers\CRequest;
use fecshop\app\appadmin\interfaces\base\AppadminbaseBlockEditInterface;
use fecshop\app\appadmin\modules\AppadminbaseBlockEdit;
use Yii;

/**
 * block cms\article.
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Index 
{
    protected $_primaryKey='id';

    // 批量取消邮箱订阅
    public function getLastData()
    {
        $ids = '';
        if ($id = CRequest::param($this->_primaryKey)) {
            $ids = $id;
        } elseif ($ids = CRequest::param($this->_primaryKey.'s')) {
            $ids = explode(',', $ids);
        }
		$status=CRequest::param('status')?CRequest::param('status'):10;
        Yii::$service->customer->newsletter->deSubscribe($ids,$status);
        $errors = Yii::$service->helper->errors->get();
        if (!$errors) {
            echo  json_encode([
                'statusCode' => '200',
                'message'    => Yii::$service->page->translate->__('Edit Success'),
            ]);
            exit;
        } else {
            echo  json_encode([
                'statusCode' => '300',
                'message'    => $errors,
            ]);
            exit;
        }
    }
	public function exportExcel(){
        $ids = Yii::$app->request->post('ids');
        $order_arr = explode(',', $ids);
        $excelArr[] = [
            Yii::$service->page->translate->__('Email'),
            Yii::$service->page->translate->__('Status'),
           ];
        if (!empty($order_arr)) {
            $orderFilter = [
               'numPerPage' 	=> 1000,
               'pageNum'		=> 1,
               'where'			=> [
                   ['in', 'id', $order_arr],
                ],
                'asArray' => true,
            ];
            $orderData = Yii::$service->customer->newsletter->coll($orderFilter);
			
            $orderColl = $orderData['coll'];
            
            if (!empty($orderColl) && is_array($orderColl)) {
				$statusArr=['1'=>Yii::$service->page->translate->__('Enable'),'10'=>Yii::$service->page->translate->__('Disable')];
                foreach ($orderColl as $orderItem) {
                    
                        $excelArr[] = [
                            $orderItem['email'],$statusArr[$orderItem['status']]
                        ];
                }
            }
        }
        
        \fec\helpers\CExcel::downloadExcelFileByArray($excelArr);
    }
    
}
