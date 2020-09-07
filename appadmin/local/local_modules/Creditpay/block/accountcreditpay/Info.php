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
use fec\helpers\CRequest;

/**
 * block cms\article.
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Apply extends \fecshop\app\appadmin\modules\Customer\block\account\Index
{
	public $table_th_bar;
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
        $this->_service = Yii::$service->creditpay->customer;
        
    }
	/**
     * list table body.
     */
    public function getTableTbody()
    {
        $searchArr = $this->getSearchArr();
		
        if (is_array($searchArr) && !empty($searchArr)) {
            $where = $this->initDataWhere($searchArr);
        }
        $filter = [
            'numPerPage'    => $this->_param['numPerPage'],
            'pageNum'        => $this->_param['pageNum'],
            'orderBy'        => [$this->_param['orderField'] => (($this->_param['orderDirection'] == 'asc') ? SORT_ASC : SORT_DESC)],
            'where'            => $where,
            'asArray'        => $this->_asArray,
        ];
		
        $coll = $this->_service->collAll($filter);
		
        $data = $coll['coll'];
		$tablehead=[];
		$demo=$data[0];
		foreach ($demo as $key =>$val){
			$tableheaddemo=[];
			if($key=='info'){
				
				$demo['info']=json_decode($demo['info'],true);
				
				foreach($demo['info'] as $key1 => $val1){
					$tableheaddemo=[];
					$tableheaddemo['orderField']=$key1;
					$tableheaddemo['label']=Yii::$service->page->translate->__($key1);
					$tableheaddemo['width']='50';
					$tableheaddemo['align']='center';
					array_push($tablehead,$tableheaddemo);
				}
			}else{
				$tableheaddemo['orderField']=$key;
				$tableheaddemo['label']=Yii::$service->page->translate->__($key);
				$tableheaddemo['width']='50';
				$tableheaddemo['align']='center';
				array_push($tablehead,$tableheaddemo);
			}
		}
		foreach($coll['coll'] as $key=>$val){
			$tablebodydemo=[];
			if(isset($val['info'])){
				$val['info']=json_decode($val['info'],true);
				foreach($val['info'] as $key1 => $val1){
					$coll['coll'][$key][$key1]=$val1;
				}
			}
		}
		$data =$coll['coll'];
		
        $this->_param['numCount'] = $coll['count'];
		$this->table_th_bar=$tablehead;
		
        return $this->getTableTbodyHtml($data);
    }
	
    public function getLastData()
    {
		

        // hidden section ,that storage page info
        $pagerForm = $this->getPagerForm();
        // search section
        $searchBar = $this->getSearchBar();
        // edit button, delete button,
        $editBar = $this->getEditBar();
        
        // table body
        $tbody = $this->getTableTbody();
		// table head
        $thead = $this->getTableThead();
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
                'name' => 'b.status',
                'columns_type' =>'int',  // int使用标准匹配， string使用模糊查询
                'value'=> [                    // select 类型的值
                    $activeStatus => Yii::$service->page->translate->__('Enable'),
                    $deleteStatus => Yii::$service->page->translate->__('Disable'),
                ],
            ],
            [    // selecit的Int 类型
                'type' => 'select',
                'title'  => Yii::$service->page->translate->__('Credit Status'),
                'name' => 'b.credit_status',
                'columns_type' =>'int',  // int使用标准匹配， string使用模糊查询
                'value'=> Yii::$service->creditpay->getCreditpayCustomerSelectStatusArr(),
            ],
            [    // 字符串类型
                'type'  => 'inputtext',
                'title'   => Yii::$service->page->translate->__('Email'),
                'name' => 'b.email',
                'columns_type' => 'string',
            ],
            [    // 时间区间类型搜索
                'type'   => 'inputdatefilter',
                 'title'  => Yii::$service->page->translate->__('Created At'),
                'name' => 'a.updated_at',
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
		
        /*$deleteStatus = Yii::$service->customer->getStatusDeleted();
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
                'orderField'    => 'updated_at',
                'label'           => Yii::$service->page->translate->__('Updated At'),
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
        ];*/

        return $this->table_th_bar;
    }
    
    /**
     * get edit html bar, it contains  add ,eidt ,delete  button.
     */
    //public function getEditBar()
    //{
    //    return '';
    //}
	/**
     * get edit html bar, it contains  add ,eidt ,delete  button.
     */
    public function getEditBar()
    {
        /*
        if(!strstr($this->_currentParamUrl,"?")){
            $csvUrl = $this->_currentParamUrl."?type=export";
        }else{
            $csvUrl = $this->_currentParamUrl."&type=export";
        }
        <li class="line">line</li>
        <li><a class="icon csvdownload"   href="'.$csvUrl.'" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
        */
        return '';
    }
	public function getTableTbodyHtml($data)
    {
        $fields = $this->getTableFieldArr();
        $str = '';
        $csrfString = CRequest::getCsrfString();
        foreach ($data as $one) {
            $str .= '<tr target="sid_user" rel="'.$one[$this->_primaryKey].'">';
            $str .= '<td><input name="'.$this->_primaryKey.'s" value="'.$one[$this->_primaryKey].'" type="checkbox"></td>';
            foreach ($fields as $field) {
                $orderField = $field['orderField'];
                $display = $field['display'];
                $translate = $field['translate'];
                $val = $one[$orderField];
                $display_title = '';
                if ($val) {
                    if (isset($field['display']) && !empty($field['display'])) {
                        $display = $field['display'];
                        $val = $display[$val] ? $display[$val] : $val;
                        $display_title = $val;
                    }
                    if (isset($field['convert']) && !empty($field['convert'])) {
                        $convert = $field['convert'];
                        foreach ($convert as $origin =>$to) {
                            if (strstr($origin, 'mongodate')) {
                                if (isset($val->sec)) {
                                    $timestamp = $val->sec;
                                    if ($to == 'date') {
                                        $val = date('Y-m-d', $timestamp);
                                    } elseif ($to == 'datetime') {
                                        $val = date('Y-m-d H:i:s', $timestamp);
                                    } elseif ($to == 'int') {
                                        $val = $timestamp;
                                    }
                                    $display_title = $val;
                                }
                            } elseif (strstr($origin, 'date')) {
                                if ($to == 'date') {
                                    $val = date('Y-m-d', strtotime($val));
                                } elseif ($to == 'datetime') {
                                    $val = date('Y-m-d H:i:s', strtotime($val));
                                } elseif ($to == 'int') {
                                    $val = strtotime($val);
                                }
                                $display_title = $val;
                            } elseif ($origin == 'int') {
                                if ($to == 'date') {
                                    $val = date('Y-m-d', $val);
                                } elseif ($to == 'datetime') {
                                    $val = date('Y-m-d H:i:s', $val);
                                } elseif ($to == 'int') {
                                    $val = $val;
                                }
                                $display_title = $val;
                            } elseif ($origin == 'string') {
                                if ($to == 'img') {
                                    $t_width = isset($field['img_width']) ? $field['img_width'] : '100';
                                    $t_height = isset($field['img_height']) ? $field['img_height'] : '100';
                                    $val = '<img style="width:'.$t_width.'px;height:'.$t_height.'px" src="'.$val.'" />';
                                }
                            }
                        }
                    }
                    if (isset($field['lang']) && !empty($field['lang'])) {
                        $val = Yii::$service->fecshoplang->getDefaultLangAttrVal($val, $orderField);
                    }
                }
                if ($translate) {
                    $val = Yii::$service->page->translate->__($val);
                }
                $str .= '<td><span title="'.$display_title.'">'.$val.'</span></td>';
            }
            $str .= '<td>
						<a title="' . Yii::$service->page->translate->__('Edit') . '" target="dialog" class="btnEdit" mask="true" drawable="true" width="1200" height="680" href="'.$this->_editUrl.'?'.$this->_primaryKey.'='.$one['customer_id'].'" ><i class="fa fa-pencil"></i></a>
						<a title="' . Yii::$service->page->translate->__('Delete') . '" target="ajaxTodo" href="'.$this->_deleteUrl.'?'.$this->_primaryKey.'='.$one[$this->_primaryKey].'" class="btnDel"  csrfName="' .CRequest::getCsrfName(). '" csrfVal="' .CRequest::getCsrfValue(). '"  ><i class="fa fa-trash-o"></i></a>
					</td>';
            $str .= '</tr>';
        }

        return $str;
    }
}
