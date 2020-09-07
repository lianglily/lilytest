<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appadmin\local\local_modules\Creditpay\block\accountcreditpay;

use fec\helpers\CRequest;
use fec\helpers\CUrl;
use fecshop\app\appadmin\interfaces\base\AppadminbaseBlockEditInterface;
use fecshop\app\appadmin\modules\AppadminbaseBlockEdit;
use Yii;

/**
 * block cms\article.
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Manageredit extends \fecshop\app\appadmin\modules\Customer\block\account\Manageredit
{
    public $_saveUrl;
    protected $numPerPage = 10;
    protected $pageNum;
    protected $orderBy;
    protected $_page = 'p';

    public function init()
    {
        $this->_saveUrl = CUrl::getUrl('creditpay/accountcreditpay/managereditsave');
        parent::init();
    }
    
    /**
     * 初始化类变量.
     */
    public function initParam()
    {
    	
        $this->pageNum = (int) Yii::$app->request->get('p');
        $this->pageNum = ($this->pageNum >= 1) ? $this->pageNum : 1;
        $this->orderBy = ['time' => SORT_DESC];
    }

    // 传递给前端的数据 显示编辑form
    public function getLastData()
    {
    	$return_arr = [];
    	if ($id = CRequest::param($this->_primaryKey)) {
            
    		$this->initParam();
    	    
    		$filter = [
                //'numPerPage'    => $this->numPerPage,
                //'pageNum'        => $this->pageNum,
                'orderBy'        => $this->orderBy,
                'where'            => [
                    ['customer_id' => $id],
                ],
                'asArray' => true,
            ];

            $customer_order_list = Yii::$service->creditpay->refund->coll($filter);
            
            $return_arr['order_list'] = $customer_order_list['coll'];
            //$count = $customer_order_list['count'];
            //$pageToolBar = $this->getProductPage($count);
            //$return_arr['pageToolBar'] = $pageToolBar;
            
    	}
            
        return [
            'editBar'      => $this->getEditBar(),
            'textareas'   => $this->_textareas,
            'lang_attr'   => $this->_lang_attr,
            'saveUrl'     => $this->_saveUrl,
            'return_arr'  => $return_arr,
        ];
    }

    public function setService()
    {
        $this->_service = Yii::$service->customer;
    }

    public function getEditArr()
    {
        $deleteStatus = Yii::$service->customer->getStatusDeleted();
        $activeStatus = Yii::$service->customer->getStatusActive();
		$disactiveStatus = 2;
        return [
            [
                'label'  => Yii::$service->page->translate->__('First Name'),
                'name' => 'firstname',
                'display' => [
                    'type' => 'inputString',

                ],
                'require' => 0,
            ],
            [
                'label'  => Yii::$service->page->translate->__('Last Name'),
                'name' => 'lastname',
                'display' => [
                    'type' => 'inputString',
                ],
                'require' => 0,
            ],
            [
                'label'  => Yii::$service->page->translate->__('Email'),
                'name' => 'email',
                'display' => [
                    'type' => 'inputString',
                ],
                'require' => 1,
            ],
            [
                'label'  => Yii::$service->page->translate->__('Password'),
                'name' => 'password',
                'display' => [
                    'type' => 'inputPassword',
                ],
                'require' => 0,
            ],
            [
                'label'  => Yii::$service->page->translate->__('Status'),
                'name' => 'status',
                'display' => [
                    'type' => 'select',
                    'data' => [
                        $activeStatus    => Yii::$service->page->translate->__('Enable'),
                        $deleteStatus    => Yii::$service->page->translate->__('Disable'),
                    ],
                ],
                'require' => 1,
                'default' => 1,
            ],
			[
                'name'    => 'credit_status',
                'label'           => Yii::$service->page->translate->__('Credit Status'),
                'display' => [
                    'type' => 'select',
                    'data' => Yii::$service->creditpay->getCreditpayCustomerSelectStatusArr(),
                ],
            ],
			[
                'name'    => 'credit_total',
                'label'           => Yii::$service->page->translate->__('Credit Total'),
                'display' => [
                    'type' => 'inputString',
                ],
            ],
			[
                'name'    => 'credit_used',
                'label'           => Yii::$service->page->translate->__('Credit Used'),
               'display' => [
                    'type' => 'inputString',
                ],
            ],
            [
                'label'  => Yii::$service->page->translate->__('SAP ID'),
                'name' => 'sap_id',
                'display' => [
                    'type' => 'inputString',

                ],
                'require' => 0,
            ],
        ];
    }

    /**
     * save article data,  get rewrite url and save to article url key.
     */
    public function save()
    {
        $request_param = CRequest::param();
        $this->_param = $request_param[$this->_editFormData];
        /*
         * if attribute is date or date time , db storage format is int ,by frontend pass param is int ,
         * you must convert string datetime to time , use strtotime function.
         */
        $this->_service->save($this->_param);
        $errors = Yii::$service->helper->errors->get();
        if (!$errors) {
            echo  json_encode([
                'statusCode' => '200',
                'message'    => Yii::$service->page->translate->__('Save Success'),
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

    // 批量删除
    public function delete()
    {
        $ids = '';
        if ($id = CRequest::param($this->_primaryKey)) {
            $ids = $id;
        } elseif ($ids = CRequest::param($this->_primaryKey.'s')) {
            $ids = explode(',', $ids);
        }
        $this->_service->remove($ids);
        $errors = Yii::$service->helper->errors->get();
        if (!$errors) {
            echo  json_encode([
                'statusCode' => '200',
                'message'    => Yii::$service->page->translate->__('Remove Success'),
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
    protected function getProductPage($countTotal)
    {
        if ($countTotal <= $this->numPerPage) {
            return '';
        }
        $config = [
            'class'        => 'fecshop\app\appfront\widgets\Page',
            'view'        => 'widgets/page.php',
            'pageNum'        => $this->pageNum,
            'numPerPage'    => $this->numPerPage,
            'countTotal'    => $countTotal,
            'page'            => $this->_page,
        ];

        return Yii::$service->page->widget->renderContent('category_product_page', $config);
    }
}
