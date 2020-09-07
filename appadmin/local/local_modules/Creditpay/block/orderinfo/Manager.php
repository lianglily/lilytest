<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appadmin\local\local_modules\Creditpay\block\orderinfo;

use fec\helpers\CUrl;
use fec\helpers\CRequest;
use fecshop\app\appadmin\interfaces\base\AppadminbaseBlockInterface;
use fecshop\app\appadmin\modules\AppadminbaseBlock;
use Yii;

/**
 * block cms\article.
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Manager extends \fecshop\app\appadmin\modules\Sales\block\orderinfo\Manager
{
    protected $_exportExcelUrl;
	protected $_creditpayRefundUrl;
	protected $_exportExcelUrlSAP;
    /**
     * init param function ,execute in construct.
     */
    public function init()
    {
        /*
         * edit data url
         */
        $this->_editUrl = CUrl::getUrl('sales/orderinfo/manageredit');
        /*
         * delete data url
         */
        $this->_deleteUrl = CUrl::getUrl('sales/orderinfo/managerdelete');
        
        $this->_exportExcelUrl = CUrl::getUrl('sales/orderinfo/managerexport');
        
        $this->_exportExcelUrlSAP = CUrl::getUrl('creditpay/orderinfo/managerexportsap');
        

		$this->_creditpayRefundUrl = CUrl::getUrl('creditpay/orderinfo/managercreditpayrefund');
        /*
         * service component, data provider
         */
        $this->_service = Yii::$service->order;
        parent::init();
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
            'pagerForm'   => $pagerForm,
            'searchBar'    => $searchBar,
            'editBar'        => $editBar,
            'thead'          => $thead,
            'tbody'          => $tbody,
            'toolBar'        => $toolBar,
        ];
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
        $wherOption=true;
		if(isset(CRequest::param()['where'])){
			$wherOption=CRequest::param()['where'];
			unset($where[0]);
		}
        $filter = [
            'numPerPage'    => $this->_param['numPerPage'],
            'pageNum'        => $this->_param['pageNum'],
            'orderBy'        => [$this->_param['orderField'] => (($this->_param['orderDirection'] == 'asc') ? SORT_ASC : SORT_DESC)],
            'where'            => $where,
            'asArray'        => $this->_asArray,
        ];
		
		
        $coll = $this->_service->coll($filter,$wherOption);
        $data = $coll['coll'];
        $this->_param['numCount'] = $coll['count'];

        return $this->getTableTbodyHtml($data);
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
                                $where[] = [$name => $val];
                            }elseif($this->_param[$name] == "empty"){
								$where[] = [$name => ''];
							} else {
                                $where[] = ['like', $name, $val];
                            }
                        }
                    } elseif ($columns_type == 'int') {
                        $where[] = [$name => (int) $this->_param[$name]];
                    } elseif ($columns_type == 'float') {
                        $where[] = [$name => (float) $this->_param[$name]];
                    } elseif ($columns_type == 'date') {
                        $where[] = [$name => $this->_param[$name]];
                    } else {
                        $where[] = [$name => $this->_param[$name]];
                    }
                } elseif ($type == 'inputdatefilter') {
                    $_gte = $this->_param[$name.'_gte'];
                    $_lt = $this->_param[$name.'_lt'];
                    if ($columns_type == 'int') {
                        $_gte = strtotime($_gte);
                        $_lt = strtotime($_lt);
                    }
                    if ($_gte) {
                        $where[] = ['>=', $name, $_gte];
                    }
                    if ($_lt) {
                        $where[] = ['<', $name, $_lt];
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
                        $where[] = ['>=', $name, $_gte];
                    }
                    if ($_lt) {
                        $where[] = ['<', $name, $_lt];
                    }
                } else {
                    $where[] = [$name => $this->_param[$name]];
                }
            }
        }
        //var_dump($where);
        return $where;
    }
    /**
     * get search bar Arr config.
     */
    public function getSearchArr()
    {
        $data = [
			[    // 字符串类型
                'type' => 'select',
                'title'  => Yii::$service->page->translate->__('Where Option'),
                'name' => 'where',
                'columns_type' => 'string',
				'value' => [
					1=>"And",
					0=>"Or"
				]
            ],
            [    // 字符串类型
                'type' => 'inputtext',
                'title'  => Yii::$service->page->translate->__('Increment Id'),
                'name' => 'increment_id',
                'columns_type' => 'string',
            ],
			[
				'type' => 'select',
                'name'    => 'payment_method',
                'title'           => Yii::$service->page->translate->__('Payment Method'),
				'columns_type' => 'string',  // int使用标准匹配， string使用模糊查询
                'value' => Yii::$service->payment->getPaymentLabels(),
                //'lang'		   => true,
            ],
            [    // selecit的Int 类型
                'type' => 'select',
                'title'  => Yii::$service->page->translate->__('Order Payment Status')
                ,
                'name' => 'order_status',
                'columns_type' => 'string',  // int使用标准匹配， string使用模糊查询
                'value' => Yii::$service->order->getSelectStatusArr(),
            ],
			[    // selecit的Int 类型
                'type' => 'select',
                'title'  => Yii::$service->page->translate->__('Order Status')
                ,
                'name' => 'order_process_status',
                'columns_type' => 'string',  // int使用标准匹配， string使用模糊查询
                'value' => Yii::$service->order->getSelectProcessStatusArr(),
            ],
            [    // 字符串类型
                'type' => 'inputtext',
                'title'  => Yii::$service->page->translate->__('Customer Email'),
                'name' => 'email',
                'columns_type' => 'string',
            ],
			[    // 字符串类型
                'type' => 'inputtext',
                'title'  => Yii::$service->page->translate->__('Shipping Email'),
                'name' => 'customer_email',
                'columns_type' => 'string',
            ],
            [    // 时间区间类型搜索
                'type' => 'inputdatefilter',
                'title'  => Yii::$service->page->translate->__('Created At'),
                'name' => 'created_at',
                'columns_type' => 'int',
                'value' => [
                    'gte' => Yii::$service->page->translate->__('Created Begin'),
                    'lt'    => Yii::$service->page->translate->__('Created End'),
                ],
            ],
			[    // 字符串类型
                'type' => 'select',
                'title'  => Yii::$service->page->translate->__('Payment Credentials'),
                'name' => 'credentials_payment',
                'columns_type' => 'string',
				'value' => [
					'empty'=>Yii::$service->page->translate->__('No Upload'),
					'jpg'=>Yii::$service->page->translate->__('Uploaded')
				]
            ],
        ];

        return $data;
    }

    /**
     * config function ,return table columns config.
     */
    public function getTableFieldArr()
    {
    	
        $table_th_bar = [
            [
                'orderField'   => 'increment_id',
                'label'          => Yii::$service->page->translate->__('Increment Id'),
                'width'         => '50',
                'align'          => 'left',
                //'lang'		  => true,
            ],
            [
                'orderField'   => 'created_at',
                'label'          => Yii::$service->page->translate->__('Created At'),
                'width'         => '50',
                'align'          => 'left',
                'convert'      => ['int' => 'date'],
                //'lang'        => true,
            ],
            [
                'orderField'   => 'order_status',
                'label'          => Yii::$service->page->translate->__('Order Payment Status'),
                'width'         => '50',
                'align'          => 'left',
				'display'        => Yii::$service->order->getSelectStatusArr()
                //'lang'        => true,
            ],
            [
                'orderField'    => 'payment_method',
                'label'           => Yii::$service->page->translate->__('Payment Method'),
                'width'          => '50',
                'align'           => 'left',
                'display'        => Yii::$service->payment->getPaymentLabels(),
                //'lang'		   => true,
            ],
			[
                'orderField'   => 'order_process_status',
                'label'          => Yii::$service->page->translate->__('Order Status'),
                'width'         => '50',
                'align'          => 'left',
				'display'        => Yii::$service->order->getSelectProcessStatusArr()
                //'lang'        => true,
            ],
            
            [
                'orderField'    => 'base_grand_total',
                'label'           => Yii::$service->page->translate->__('Base Grand Total'),
                'width'          => '50',
                'align'           => 'left',
                //'lang'		   => true,
            ],
            
            
           /* [
                'orderField'   => 'credit_refund_status',
                'label'          => Yii::$service->page->translate->__('Creditpay Refund'),
                'width'         => '50',
                'align'          => 'left',
				'display'        =>[
					Yii::$service->creditpay->refund->creditpay_refund_status_notyet[0]=> Yii::$service->page->translate->__('creditpay_refund_status_notyet'),
					Yii::$service->creditpay->refund->creditpay_refund_status_yet[0] => Yii::$service->page->translate->__('creditpay_refund_status_yet'),
					Yii::$service->creditpay->refund->creditpay_refund_status_someyet[0] => Yii::$service->page->translate->__('creditpay_refund_status_someyet'),
					Yii::$service->creditpay->refund->creditpay_refund_status_cancelyet[0] => Yii::$service->page->translate->__('creditpay_refund_status_cancelyet')
					]
				
                //'lang'		  => true,
            ],*/
			[
                'orderField'    => 'credentials_payment',
                'label'           => Yii::$service->page->translate->__('Payment Credentials'),
                'width'          => '50',
                'align'           => 'left',
                //'lang'		   => true,
            ],
            [
                'orderField'    => 'order_customer_email',
                'label'           => Yii::$service->page->translate->__('Customer Email'),
                'width'          => '50',
                'align'           => 'left',
                //'lang'		   => true,
            ],
			[
                'orderField'    => 'customer_email',
                'label'           => Yii::$service->page->translate->__('Shipping Email'),
                'width'          => '50',
                'align'           => 'left',
                //'lang'		   => true,
            ],
        ];
		
        return $table_th_bar;
    }

    /**
     * rewrite parent getTableTbodyHtml($data).
     */
    public function getTableTbodyHtml($data)
    {
        $fileds = $this->getTableFieldArr();
        $str = '';
        $csrfString = CRequest::getCsrfString();
        $user_ids = [];
        foreach ($data as $one) {
            $user_ids[] = $one['created_person'];
        }
        $users = Yii::$service->adminUser->getIdAndNameArrByIds($user_ids);
		$paymentConfig = Yii::$service->payment->paymentConfig['standard'];
        foreach ($data as $one) {
            $str .= '<tr target="sid_user" value="88" rel="'.$one[$this->_primaryKey].'">';
            $str .= '<td><input name="'.$this->_primaryKey.'s" value="'.$one[$this->_primaryKey].'" data-paymentmethod="'.$one['payment_method'].'" data-orderstatus="'.$one['order_status'].'" data-total="'.$one['base_grand_total'].'" data-refundstatus="'.$one['credit_refund_status'].'" data-incrementid="'.$one['increment_id'].'" data-email="'.$one['customer_email'].'" type="checkbox"></td>';
            foreach ($fileds as $field) {
                $orderField = $field['orderField'];
                $display = $field['display'];
                $val = $one[$orderField];
                if ($orderField == 'created_person') {
                    $val = isset($users[$val]) ? $users[$val] : $val;
                    $str .= '<td>'.$val.'</td>';
                    continue;
                }
				if ($orderField == 'credit_refund_status'&& !in_array($one['payment_method'] 
					,Yii::$service->creditpay->refund->creditpay_payment)) {
					$val = Yii::$service->page->translate->__('Invalid');
					$str .= '<td>'.$val.'</td>';
					continue;
				}
				if ($orderField == 'credentials_payment'&& $paymentConfig[$one['payment_method']]['credentials']) {
					if($one['credentials_payment']){
						$val = Yii::$service->url->getUrl('payment/credentialsupload/imageshow',['msg' => $one['credentials_payment']]);
						$str .= "<td><a src='{$val}' onclick='imgShow(this)' >".Yii::$service->page->translate->__('Open')."</a></td>";
						continue;
					}else{
						$val = Yii::$service->page->translate->__('No Upload');
						$str .= '<td>'.$val.'</td>';
						continue;
					}
				}
                if ($val) {
					
                    if (isset($field['display']) && !empty($field['display'])) {
                        $display = $field['display'];
                        $val = $display[$val] ? $display[$val] : $val;
                    }
                    if (isset($field['convert']) && !empty($field['convert'])) {
                        $convert = $field['convert'];
                        foreach ($convert as $origin =>$to) {
                            if (strstr($origin, 'mongodate')) {
                                if (isset($val->sec)) {
                                    $timestramp = $val->sec;
                                    if ($to == 'date') {
                                        $val = date('Y-m-d', $timestramp);
                                    } elseif ($to == 'datetime') {
                                        $val = date('Y-m-d H:i:s', $timestramp);
                                    } elseif ($to == 'int') {
                                        $val = $timestramp;
                                    }
                                }
                            } elseif (strstr($origin, 'date')) {
                                if ($to == 'date') {
                                    $val = date('Y-m-d', strtotime($val));
                                } elseif ($to == 'datetime') {
                                    $val = date('Y-m-d H:i:s', strtotime($val));
                                } elseif ($to == 'int') {
                                    $val = strtotime($val);
                                }
                            } elseif ($origin == 'int') {
                                if ($to == 'date') {
                                    $val = date('Y-m-d', $val);
                                } elseif ($to == 'datetime') {
                                    $val = date('Y-m-d H:i:s', $val);
                                } elseif ($to == 'int') {
                                    $val = $val;
                                }
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
                        //var_dump($val);
                        //var_dump($orderField);
                        $val = Yii::$service->fecshoplang->getDefaultLangAttrVal($val, $orderField);
                    }
                }
                $str .= '<td>'.$val.'</td>';
            }
            $str .= '<td>
						<a title="' . Yii::$service->page->translate->__('Edit') . '" target="dialog" class="btnEdit" mask="true" drawable="true" width="1200" height="680" href="'.$this->_editUrl.'?'.$this->_primaryKey.'='.$one[$this->_primaryKey].'" ><i class="fa fa-pencil"></i></a>
						<!-- <a title="' . Yii::$service->page->translate->__('Delete') . '" target="ajaxTodo" href="'.$this->_deleteUrl.'?'.$csrfString.'&'.$this->_primaryKey.'='.$one[$this->_primaryKey].'" class="btnDel"><i class="fa fa-trash-o"></i></a>
						-->
					</td>';
            $str .= '</tr>';
        }

        return $str;
    }
    
    
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
        target="dwzExport" targetType="navTab"  rel="'.$this->_primaryKey.'s"
        <li class="line">line</li>
        <li><a class="icon csvdownload"   href="'.$csvUrl.'" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
							<li><a class="icon creditpayRefund" href="javascript:void()"  postType="string"  target="_blank" title="' . Yii::$service->page->translate->__('Are you sure you want to export the selected order') . '?"><span>' . Yii::$service->page->translate->__('Creditpay Refund') . '</span></a></li>

        */
        return '<ul class="toolBar">
					<li class="line">line</li>
                    <li><a class="icon exportOrderExcel" href="javascript:void()"  postType="string"   title="' . Yii::$service->page->translate->__('Are you sure you want to export the selected order') . '?"><span>' . Yii::$service->page->translate->__('Export Excel') . '</span></a></li>
                    <li><a class="icon exportOrderExcelSAP" href="javascript:void()"  postType="string"   title="' . Yii::$service->page->translate->__('Are you sure you want to export the selected order') . '?"><span>' . Yii::$service->page->translate->__('Export Excel') . 'SAP</span></a></li>
				</ul>
                <script>
                    $(document).ready(function(){
						$(".creditpayRefund").click(function(){
							var user=[];
							var total=0;
                            var selectOrderIds = \'\';
                            $(\'.grid input:checkbox[name=order_ids]:checked\').each(function(k){
								//判断付款方式
								if($(this).data(\'paymentmethod\')!=\'creditpay_standard\'){
									var message = "' . Yii::$service->page->translate->__('Is not ') . '";
									alertMsg.error("order:"+ $(this).data(\'incrementid\')+ message);
									return;
								}
                                if(k == 0){
                                    selectOrderIds = $(this).val();
                                }else{
                                    selectOrderIds += \',\'+$(this).val();
                                }
								if(user.indexOf($(this).data(\'email\'))<0){
									user.push($(this).data(\'email\'));
								}
								total+=parseFloat($(this).data(\'total\'));
                            });
							
							if(user.length != 1){
								var message = "' . Yii::$service->page->translate->__('Is not ') . '";
								alertMsg.error( message);
								return;
							}
                            if (!selectOrderIds) {
                                var message = "' . Yii::$service->page->translate->__('Choose at least one order') . '";
                                alertMsg.error(message);
                            } else {

								alertMsg.confirm("确定为"+user[0]+"还款:"+total+"?", {okCall: function(){
									url = "'.$this->_creditpayRefundUrl.'" ;
									 $.ajax({
										async:true,
										url:url,
										type:"post",//请求的方式
										data:{"order_ids": selectOrderIds,"refund": total, "'.CRequest::getCsrfName().'": "'.CRequest::getCsrfValue() .'"},//请求的数据
										success:function (backdata) {//请求成功后返回的数据会封装在回调函数的第一个参数中
											//通过backdata来获取所需要的数据
											alertMsg.error(backdata.message);
										},error:function () {//响应不成功时返回的函数
											alertMsg.error("请求失败！")
										},dataType:"json"//设置返回的数据类型
									});
								},cancelCall : function() {}});

                            }
                        });
                        $(".exportOrderExcel").click(function(){
                            var selectOrderIds = \'\';
                            $(\'.grid input:checkbox[name=order_ids]:checked\').each(function(k){
                                if(k == 0){
                                    selectOrderIds = $(this).val();
                                }else{
                                    selectOrderIds += \',\'+$(this).val();
                                }
                            });
                            if (!selectOrderIds) {
                                var message = "' . Yii::$service->page->translate->__('Choose at least one order') . '";
                                alertMsg.error(message);
                            } else {
                                url = "'.$this->_exportExcelUrl.'" ;
                                doPost(url, {"order_ids": selectOrderIds, "'.CRequest::getCsrfName().'": "'.CRequest::getCsrfValue() .'"});
                            }
                        });
                        $(".exportOrderExcelSAP").click(function(){
                            var selectOrderIds = \'\';
                            $(\'.grid input:checkbox[name=order_ids]:checked\').each(function(k){
                                if(k == 0){
                                    selectOrderIds = $(this).val();
                                }else{
                                    selectOrderIds += \',\'+$(this).val();
                                }
                            });
                            if (!selectOrderIds) {
                                var message = "' . Yii::$service->page->translate->__('Choose at least one order') . '";
                                alertMsg.error(message);
                            } else {
                                url = "'.$this->_exportExcelUrlSAP.'" ;
                                doPost(url, {"order_ids": selectOrderIds, "'.CRequest::getCsrfName().'": "'.CRequest::getCsrfValue() .'"});
                            }
                        });
                    });
                </script> 
        ';
    }
    
}
