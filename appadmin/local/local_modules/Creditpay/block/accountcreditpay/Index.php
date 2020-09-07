<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appadmin\local\local_modules\Creditpay\block\accountcreditpay;

use fec\helpers\CUrl;
use fecshop\app\appadmin\interfaces\base\AppadminbaseBlockInterface;
use fecshop\app\appadmin\modules\AppadminbaseBlock;
use Yii;

/**
 * block cms\article.
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Index extends \fecshop\app\appadmin\modules\Customer\block\account\Index
{
    /**
     * init param function ,execute in construct.
     */
    public function init()
    {
		parent::init();
        /*
         * edit data url
         */
        $this->_editUrl = CUrl::getUrl('creditpay/accountcreditpay/manageredit');
        /*
         * delete data url
         */
        $this->_deleteUrl = CUrl::getUrl('creditpay/accountcreditpay/managerdelete');
        /*
         * service component, data provider
         */
        $this->_service = Yii::$service->customer;
        
    }

    public function getLastData()
    {

        // hidden section ,that storage page info
        $pagerForm = $this->getPagerForm();
        // search section
        $searchBar = $this->getSearchBar();
        // edit button, delete button,
        $editBar = $this->getEditBar();
        // table head
        $thead = $this->getTableThead();
        // table body
        $tbody = $this->getTableTbody();
        // paging section
        $toolBar = $this->getToolBar($this->_param['numCount'], $this->_param['pageNum'], $this->_param['numPerPage']);
		
        return [
            'pagerForm'    => $pagerForm,
            'searchBar'     => $searchBar,
            'editBar'         => $editBar,
            'thead'           => $thead,
            'tbody'           => $tbody,
            'toolBar'         => $toolBar,
        ];
    }

    /**
     * get search bar Arr config.
     */
    public function getSearchArr()
    {
        $deleteStatus = Yii::$service->customer->getStatusDeleted();
        $activeStatus = Yii::$service->customer->getStatusActive();

        $data = [
            [    // selecit的Int 类型
                'type' => 'select',
                'title'  => Yii::$service->page->translate->__('Status'),
                'name' => 'status',
                'columns_type' =>'int',  // int使用标准匹配， string使用模糊查询
                'value'=> [                    // select 类型的值
                    $activeStatus => Yii::$service->page->translate->__('Enable'),
                    $deleteStatus => Yii::$service->page->translate->__('Disable'),
                ],
            ],
            [    // selecit的Int 类型
                'type' => 'select',
                'title'  => Yii::$service->page->translate->__('Credit Status'),
                'name' => 'credit_status',
                'columns_type' =>'int',  // int使用标准匹配， string使用模糊查询
                'value'=> Yii::$service->creditpay->getCreditpayCustomerSelectStatusArr(),
            ],
            [    // 字符串类型
                'type'  => 'inputtext',
                'title'   => Yii::$service->page->translate->__('Email'),
                'name' => 'email',
                'columns_type' => 'string',
            ],
            [    // 字符串类型
                'type' => 'inputtext',
                'title'  => Yii::$service->page->translate->__('Password Reset Token'),
                'name' => 'password_reset_token',
                'columns_type' => 'string',
            ],
            [    // 时间区间类型搜索
                'type'   => 'inputdatefilter',
                 'title'  => Yii::$service->page->translate->__('Created At'),
                'name' => 'created_at',
                'columns_type' => 'int',
                'value' => [
                    'gte' => Yii::$service->page->translate->__('Created Begin'),
                    'lt'    => Yii::$service->page->translate->__('Created End'),
                ],
            ],
        ];

        return $data;
    }

    /**
     * config function ,return table columns config.
     */
    public function getTableFieldArr()
    {
		
        $deleteStatus = Yii::$service->customer->getStatusDeleted();
        $activeStatus = Yii::$service->customer->getStatusActive();
		$disactiveStatus = 2;
		
        $table_th_bar = [
            [
                'orderField'    => $this->_primaryKey,
                'label'           => Yii::$service->page->translate->__('Id'),
                'width'          => '50',
                'align'           => 'center',
            ],
            [
                'orderField'    => 'companycn',
                'label'           => Yii::$service->page->translate->__('Company CN'),
                'width'          => '50',
                'align'           => 'center',
            ],
            [
                'orderField'    => 'companyen',
                'label'           => Yii::$service->page->translate->__('Company EN'),
                'width'          => '50',
                'align'           => 'center',
            ],
            [
                'orderField'    => 'firstname',
                'label'           => Yii::$service->page->translate->__('First Name'),
                'width'          => '50',
                'align'           => 'left',
            ],
            [
                'orderField'    => 'lastname',
                'label'           => Yii::$service->page->translate->__('Last Name'),
                'width'          => '50',
                'align'           => 'left',
            ],
            [
                'orderField'    => 'email',
                'label'           => Yii::$service->page->translate->__('Email'),
                'width'          => '50',
                'align'           => 'left',
            ],
            [
                'orderField'    => 'favorite_product_count',
                'label'           => Yii::$service->page->translate->__('Favorite Product Count'),
                'width'          => '60',
                'align'           => 'left',
            ],
            [
                'orderField'    => 'status',
                'label'           => Yii::$service->page->translate->__('Status'),
                'width'          => '50',
                'align'           => 'center',
                'display'        => [
                    $activeStatus => Yii::$service->page->translate->__('Enable'),
                    $deleteStatus => Yii::$service->page->translate->__('Disable'),
                ],
            ],
            [
                'orderField'    => 'created_at',
                'label'           => Yii::$service->page->translate->__('Created At'),
                'width'          => '110',
                'align'           => 'center',
                'convert'       => ['int' => 'datetime'],
            ],
           
			[
                'orderField'    => 'credit_status',
                'label'           => Yii::$service->page->translate->__('Credit Status'),
                'width'          => '80',
                'align'           => 'center',
                'display'        => Yii::$service->creditpay->getCreditpayCustomerSelectStatusArr(),
            ],
			[
                'orderField'    => 'credit_total',
                'label'           => Yii::$service->page->translate->__('Credit Total'),
                'width'          => '80',
                'align'           => 'center',
            ],
			[
                'orderField'    => 'credit_used',
                'label'           => Yii::$service->page->translate->__('Credit Used'),
                'width'          => '80',
                'align'           => 'center',
            ],
        ];

        return $table_th_bar;
    }
    
    /**
     * get edit html bar, it contains  add ,eidt ,delete  button.
     */
    //public function getEditBar()
    //{
    //    return '';
    //}
}
