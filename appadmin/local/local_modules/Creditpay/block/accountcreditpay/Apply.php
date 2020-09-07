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
     * @param $searchArr|Array.
     * generate where Array by  $this->_param and $searchArr.
     * foreach $searchArr , check each one if it is exist in this->_param.
     */
    public function initDataWhere($searchArr)
    {
    	
        $where = [];
        foreach ($searchArr as $field) {
            $type = $field['type'];
            $name = $field['name'];
            $lang = $field['lang'];
		
            $columns_type = isset($field['columns_type']) ? $field['columns_type'] : '';
            $label=str_replace("##",".",$name);
            if ($this->_param[$name] || $this->_param[$name.'_gte'] || $this->_param[$name.'_lt']) {
                if ($type == 'inputtext' || $type == 'select' || $type == 'chosen_select') {
                    if ($columns_type == 'string') {
                        if ($lang) {
                            $langname = $name.'.'.\Yii::$service->fecshoplang->getDefaultLangAttrName($name);
                            $where[] = ['like', $langname, $this->_param[$name]];
                        } else {
                            $val = $this->_param[$name];
                            if($name == '_id'){
                                $val = new \MongoDB\BSON\ObjectId($val);
                                $where[] = [$label => $val];
                            } else {
                                $where[] = ['like', $label, $val];
                            }
                        }
                    } elseif ($columns_type == 'int') {
                        $where[] = [$label => (int) $this->_param[$name]];
                    } elseif ($columns_type == 'float') {
                        $where[] = [$label => (float) $this->_param[$name]];
                    } elseif ($columns_type == 'date') {
                        $where[] = [$label => $this->_param[$name]];
                    } else {
                        $where[] = [$label => $this->_param[$name]];
                    }
                } elseif ($type == 'inputdatefilter') {
                    $_gte = $this->_param[$name.'_gte'];
                    $_lt = $this->_param[$name.'_lt'];
                    if ($columns_type == 'int') {
                        $_gte = strtotime($_gte);
                        $_lt = strtotime($_lt);
                    }
                    if ($_gte) {
                        $where[] = ['>=', $label, $_gte];
                    }
                    if ($_lt) {
                        $where[] = ['<', $label, $_lt];
                    }
                } elseif ($type == 'inputfilter') {
                    $_gte = $this->_param[$name.'_gte'];
                    $_lt = $this->_param[$name.'_lt'];
                    if ($columns_type == 'int') {
                        $_gte = (int) $_gte;
                        $_lt = (int) $_lt;
                    } elseif ($columns_type == 'float') {
                        $_gte = (float) $_gte;
                        $_lt = (float) $_lt;
                    }
                    if ($_gte) {
                        $where[] = ['>=', $label, $_gte];
                    }
                    if ($_lt) {
                        $where[] = ['<', $label, $_lt];
                    }
                } else {
                    $where[] = [$label => $this->_param[$name]];
                }
            }
        }
        
        return $where;
    }
	/**
     * list table body.
     */
    public function getTableTbody()
    {
    	
        $searchArr = $this->getSearchArr();
		//var_dump($searchArr);
		
        if (is_array($searchArr) && !empty($searchArr)) {
            $where = $this->initDataWhere($searchArr);
            
        }
        
        if($this->_param['orderField']=='info'){
        	$this->_param['orderField']="a.info";
        }else if($this->_param['orderField']=='updated_at'){
        	$this->_param['orderField']="a.updated_at";
        }else if($this->_param['orderField']=='status'){
        	$this->_param['orderField']="b.status";
        }else if($this->_param['orderField']=='email'){
        	$this->_param['orderField']="b.email";
        }else if($this->_param['orderField']=='credit_status'){
        	$this->_param['orderField']="b.credit_status";
        }else if($this->_param['orderField']=='credit_used'){
        	$this->_param['orderField']="b.credit_used";
        }else if($this->_param['orderField']=='credit_total'){
        	$this->_param['orderField']="b.credit_total";
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
		if($demo){
		foreach ($demo as $key =>$val){
			$tableheaddemo=[];
			if($key=='info'){
				$tableheaddemo=[];
				$tableheaddemo['orderField']=$key;
				$tableheaddemo['label']=Yii::$service->page->translate->__($key);
				$tableheaddemo['width']='150';
				$tableheaddemo['align']='left';
				array_push($tablehead,$tableheaddemo);
				/*$demo['info']=json_decode($demo['info'],true);
				
				foreach($demo['info'] as $key1 => $val1){
					
					$tableheaddemo=[];
					$tableheaddemo['orderField']=$key1;
					$tableheaddemo['label']=Yii::$service->page->translate->__($key1);
					$tableheaddemo['width']='150';
					$tableheaddemo['align']='center';
					array_push($tablehead,$tableheaddemo);
				}*/
			}else{
				if($key=="customer_id"){
						continue;
					}
				$tableheaddemo['orderField']=$key;
				$tableheaddemo['label']=Yii::$service->page->translate->__($key);
				$tableheaddemo['width']='50';
				$tableheaddemo['align']='center';
				if($key=="status"){
					$tableheaddemo['display']=array(1 => Yii::$service->page->translate->__('Enable'),
                    10 => Yii::$service->page->translate->__('Disable'));
				}
				if($key=="credit_status"){
					$tableheaddemo['display']=array(Yii::$service->creditpay->getCreditpayCustomerSelectStatusArr());
				}
				if($key=="updated_at"){
					$tableheaddemo['convert']= ['int' => 'date'];
				}
				array_push($tablehead,$tableheaddemo);
			}
		}
		foreach($coll['coll'] as $key=>$val){
			$tablebodydemo=[];
			if(isset($val['info'])){
				
				$coll['coll'][$key]['info']="";
				
				$val['info']=json_decode($val['info'],true);
				foreach($val['info'] as $key1 => $val1){
					
					if( $val1['display_type']=='attachment'){
						$coll['coll'][$key][$key1]=Yii::$service->apply->attachment->getUrl($val1['value']);
					}else if($val1['display_type']=='address'){
						$addressarr=explode('##',$val1['value']);
						list($countryvalue,$statevalue,$cityvalue,$street1,$street2) = $addressarr;
						
						$areas=Yii::$service->shipping->area;
                        $weekday=0;
                        $countryid=is_numeric($countryvalue)?$countryvalue-1:-1;
 
                        if(isset($areas[$countryid])){
                        	
                        	if($areas[$countryid]['translate']){
                        		$country = Yii::$service->page->translate->__($areas[$countryid]['translate']);
                        	}else{
                        		$country = $areas[$countryid]['name'];
                        	}
                        	$stateid=is_numeric($statevalue)?$statevalue-1:-1;
                        	
                        	if(isset($areas[$countryid]['cityList'][$stateid])){
                        		if($areas[$countryid]['cityList'][$stateid]['translate']){
	                        		$state = Yii::$service->page->translate->__($areas[$countryid]['cityList'][$stateid]['translate']);
	                        	}else{
	                        		$state = $areas[$countryid]['cityList'][$stateid]['name'];
	                        	}
                        	}
                        	$cityid=is_numeric($cityvalue)?$cityvalue-1:-1;
                        	if(isset($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid])){
                        		if($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['translate']){
	                        		$city = Yii::$service->page->translate->__($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['translate']);
	                        	}else{
	                        		$city = $areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['name'];
	                        	}
	                        	$weekday=$areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['weekday'];
                        	}
                        }else{
                        
                        	$country = Yii::$service->helper->country->getCountryNameByKey($countryvalue);
                        	$state = Yii::$service->helper->country->getStateByContryCode($contryvalue,$statevalue);
							$city = $cityvalue;
                        }
						$coll['coll'][$key][$key1]="$country $state $city $street1 $steet2";
					}else if(is_array($val1['value'])){
						$coll['coll'][$key][$key1]=implode(',',$val1['value']);
					}else{
						
						$coll['coll'][$key][$key1]=$val1['value'];
					}
					if($coll['coll'][$key][$key1]){
						$coll['coll'][$key]['info'].="<div>".Yii::$service->page->translate->__($key1).":{$coll['coll'][$key][$key1]}</div>";
					}
				}
				
				/*$val['info']=json_decode($val['info'],true);
				foreach($val['info'] as $key1 => $val1){
					if( $val1['display_type']=='attachment'){
						$coll['coll'][$key][$key1]=Yii::$service->apply->attachment->getUrl($val1['value']);
					}else if($val1['display_type']=='address'){
						$addressarr=explode('##',$val1['value']);
						list($countryvalue,$statevalue,$cityvalue,$street1,$street2) = $addressarr;
						
						$areas=Yii::$service->shipping->area;
                        $weekday=0;
                        $countryid=is_numeric($countryvalue)?$countryvalue-1:-1;
 
                        if(isset($areas[$countryid])){
                        	
                        	if($areas[$countryid]['translate']){
                        		$country = Yii::$service->page->translate->__($areas[$countryid]['translate']);
                        	}else{
                        		$country = $areas[$countryid]['name'];
                        	}
                        	$stateid=is_numeric($statevalue)?$statevalue-1:-1;
                        	
                        	if(isset($areas[$countryid]['cityList'][$stateid])){
                        		if($areas[$countryid]['cityList'][$stateid]['translate']){
	                        		$state = Yii::$service->page->translate->__($areas[$countryid]['cityList'][$stateid]['translate']);
	                        	}else{
	                        		$state = $areas[$countryid]['cityList'][$stateid]['name'];
	                        	}
                        	}
                        	$cityid=is_numeric($cityvalue)?$cityvalue-1:-1;
                        	if(isset($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid])){
                        		if($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['translate']){
	                        		$city = Yii::$service->page->translate->__($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['translate']);
	                        	}else{
	                        		$city = $areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['name'];
	                        	}
	                        	$weekday=$areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['weekday'];
                        	}
                        }else{
                        
                        	$country = Yii::$service->helper->country->getCountryNameByKey($countryvalue);
                        	$state = Yii::$service->helper->country->getStateByContryCode($contryvalue,$statevalue);
							$city = $cityvalue;
                        }
						$coll['coll'][$key][$key1]="$country $state $city $street1 $steet2";
					}else if(is_array($val1['value'])){
						$coll['coll'][$key][$key1]=implode(',',$val1['value']);
					}else{
						
						$coll['coll'][$key][$key1]=$val1['value'];
					}
					
				}*/
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
        $thead = $tbody?$this->getTableThead():'';
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
                'name' => 'b##status',
                'columns_type' =>'int',  // int使用标准匹配， string使用模糊查询
                'value'=> [                    // select 类型的值
                    $activeStatus => Yii::$service->page->translate->__('Enable'),
                    $deleteStatus => Yii::$service->page->translate->__('Disable'),
                ],
            ],
            [    // selecit的Int 类型
                'type' => 'select',
                'title'  => Yii::$service->page->translate->__('Credit Status'),
                'name' => 'b##credit_status',
                'columns_type' =>'int',  // int使用标准匹配， string使用模糊查询
                'value'=> Yii::$service->creditpay->getCreditpayCustomerSelectStatusArr(),
            ],
            [    // 字符串类型
                'type'  => 'inputtext',
                'title'   => Yii::$service->page->translate->__('Email'),
                'name' => 'b##email',
                'columns_type' => 'string',
            ],
            [    // 字符串类型
                'type'  => 'inputtext',
                'title'   => Yii::$service->page->translate->__('Apply Info'),
                'name' => 'a##info',
                'columns_type' => 'string',
            ],
            [    // 时间区间类型搜索
                'type'   => 'inputdatefilter',
                 'title'  => Yii::$service->page->translate->__('Created At'),
                'name' => 'a##updated_at',
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
