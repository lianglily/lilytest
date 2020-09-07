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
use Yii;

/**
 * block cms\article.
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Manageredit
{
    public $_saveUrl;

    public function init()
    {
        parent::init();
    }

    // 传递给前端的数据 显示编辑form
    public function getLastData()
    {
        $order_id = Yii::$app->request->get('order_id');
        //$order = Yii::$service->order->getByPrimaryKey($order_id);
        $order_info = Yii::$service->order->getOrderInfoById($order_id);
		
        $order_info = $this->getViewOrderInfo($order_info);
		
        return [
            'order' => $order_info,
            //'editBar' 	=> $this->getEditBar(),
            //'textareas'	=> $this->_textareas,
            //'lang_attr'	=> $this->_lang_attr,
			'lang_attr'	=> $this->_lang_attr,
            'saveUrl' 	    => Yii::$service->url->getUrl('sales/orderinfo/managereditsave'),
			'creditpayRefundUrl' =>Yii::$service->url->getUrl('creditpay/orderinfo/managercreditpayrefund'),
        ];
    }
    
    public function getViewOrderInfo($order_info){
        // 订单状态部分
        $orderStatusArr = Yii::$service->order->getSelectStatusArr();
        //var_dump($orderStatusArr);exit;
        $order_info['order_payment_status_options'] = $this->getOptions($orderStatusArr,$order_info['order_status']);
		
		// 订单状态部分
        $orderStatusArr = Yii::$service->order->getSelectProcessStatusArr();
   
        $order_info['order_status_options'] = $this->getOptions($orderStatusArr,$order_info['order_process_status']);
		
		// 订单状态部分
        //$orderStatusArr = Yii::$service->order->getSelectShippingStatusArr();
        //var_dump($orderStatusArr);exit;
        //$order_info['order_shipping_status_options'] = $this->getOptions($orderStatusArr,$order_info['order_shipping_status']);
		
    
        // 货币部分
        $currencys = Yii::$service->page->currency->getCurrencys();
        $currencyArr = [];
        if(is_array($currencys)){
            foreach( $currencys as $code => $v){
                $currencyArr[$code] = $code;
            }
        }
        $order_info['order_currency_code_options'] = $this->getOptions($currencyArr,$order_info['order_currency_code']);
        // 支付类型
        $checkTypeArr = Yii::$service->order->getCheckoutTypeArr();
        $order_info['checkout_method_options'] = $this->getOptions($checkTypeArr,$order_info['checkout_method']);
        // 游客下单
        $customerOrderArr = [ 
            1 => Yii::$service->page->translate->__('Yes'),
            2 => Yii::$service->page->translate->__('No'),
        ];
        $order_info['customer_is_guest_options'] = $this->getOptions($customerOrderArr,$order_info['customer_is_guest']);
        // 省
        //$order_info['customer_address_country_options'] = Yii::$service->helper->country->getCountryOptionsHtml($order_info['customer_address_country']);
        // 市
       // $order_info['customer_address_state_options'] = Yii::$service->helper->country->getStateOptionsByContryCode($order_info['customer_address_country'],$order_info['customer_address_state']);
        // 支付方式label 货运方式label
        $order_info['shipping_method_label'] = Yii::$service->shipping->getShippingLabelByMethod($order_info['shipping_method']);
        $order_info['payment_method_label'] = Yii::$service->payment->getPaymentLabelByMethod($order_info['payment_method']);
        
        return $order_info;
    }
    
    public function getOptions($orderStatusArr,$order_status){
        $str = '';
        if (is_array($orderStatusArr)) {
            foreach ($orderStatusArr as $k => $v) {
                if ($order_status == $k ) {
                    $str .= '<option selected="selected" value="'.$k.'">'.$v.'</option>';
                } else {
                    $str .= '<option value="'.$k.'">'.$v.'</option>';
                }
            }
        }
        
        return $str;
    }
    
    public function save(){
        $editForm = Yii::$app->request->post('editForm');
        $order_id = $editForm['order_id'];
        $orderModel = Yii::$service->order->getByPrimaryKey($order_id);
		
        if (is_array($editForm) && $orderModel['order_id']) {
			if(isset($editForm['order_admin_record'])){
				$order_admin_record=$editForm['order_admin_record'];
				unset($editForm['order_admin_record']);
				$order_admin_record['order_process_status']=isset($editForm['order_process_status'])?$editForm['order_process_status']:$orderModel['order_process_status'];
				//$order_admin_record['order_shipping_status']=$orderModel['order_shipping_status'];
				$order_admin_record['order_status']=isset($editForm['order_status'])?$editForm['order_status']:$orderModel['order_status'];
				$order_admin_record['time']=time();
				$order_admin_record['id']=Yii::$app->user->identity->id;
				$order_admin_record['type']=2;
				$records=array();
				if($orderModel['order_admin_record']){
					$records=json_decode($orderModel['order_admin_record'],true);
					
				}
				
				$records[time()]=$order_admin_record;
				$editForm['order_admin_record']=json_encode($records);
			}
			//由占有库存到释放库存的状态
			if($orderModel['order_status']==Yii::$service->order->payment_status_pending ||$orderModel['order_status']== Yii::$service->order->payment_status_processing || $orderModel['order_status']== Yii::$service->order->payment_status_confirmed){
				if($editForm['order_status']==Yii::$service->order->payment_status_canceled || $editForm['order_status']==Yii::$service->order->payment_status_suspected_fraud || $editForm['order_status']==Yii::$service->order->payment_status_failed){
					$order_primary_key      = Yii::$service->order->getPrimaryKey();
					$product_items          = Yii::$service->order->item->getByOrderId($orderModel[$order_primary_key], true);
					Yii::$service->product->stock->returnQty($product_items);
				}
			}
			
            foreach ($editForm as $k => $v) {
                if ($orderModel->hasAttribute($k)) {
					if($k == 'shipping_date'){
						$v=strtotime($v);
					}
                    $orderModel[$k] = $v;
                }
            } 
			
            $a= $orderModel->save();
			
            
        }
        echo  json_encode([
            'statusCode' => '200',
            'message' => Yii::$service->page->translate->__('Save Success'),
        ]);
        exit;
    }
    public function exportExcelSAP(){
		$order_type="ZWEB";
		$order_storage="S001";
		$order_sales_organization="1538";
		$order_sales_factory="1538";
		
        $order_ids = Yii::$app->request->post('order_ids');
        $order_arr = explode(',', $order_ids);
		
        $colHeaders = $excelArr[] = [
            Yii::$service->page->translate->__('系统订单'),
            Yii::$service->page->translate->__('下单日期'),
            Yii::$service->page->translate->__('发货日期') ,
            Yii::$service->page->translate->__('单据类型'),
            Yii::$service->page->translate->__('销售办事处'),
            Yii::$service->page->translate->__('平台单号'),
            Yii::$service->page->translate->__('商品编码'),
            Yii::$service->page->translate->__('数量'), 
            Yii::$service->page->translate->__('行项目文本'),
            Yii::$service->page->translate->__('库存地点') ,
            Yii::$service->page->translate->__('装运条件'),
            Yii::$service->page->translate->__('客户联系人'),
            Yii::$service->page->translate->__('单位'),
            Yii::$service->page->translate->__('单抬头文本'),
            Yii::$service->page->translate->__('单价'),
            Yii::$service->page->translate->__('总金额'),
            Yii::$service->page->translate->__('货币') ,
            Yii::$service->page->translate->__('付款条件'),
            Yii::$service->page->translate->__('物料编码'),
            Yii::$service->page->translate->__('规格型号'),
            Yii::$service->page->translate->__('物料描述'),
            Yii::$service->page->translate->__('求交货日期'),
            Yii::$service->page->translate->__('行项目类别'),
            Yii::$service->page->translate->__('销售组织'),
            Yii::$service->page->translate->__('分销渠道'),
            Yii::$service->page->translate->__('产品组'),
            Yii::$service->page->translate->__('销售组'),
            Yii::$service->page->translate->__('客户编号') ,
            Yii::$service->page->translate->__('送达方'),
            Yii::$service->page->translate->__('工厂'),
            Yii::$service->page->translate->__('订单原因'),
            Yii::$service->page->translate->__('行项目'),
            Yii::$service->page->translate->__('价格单位'),
			Yii::$service->page->translate->__('标识'),
            Yii::$service->page->translate->__('一次性客户名称'),
            Yii::$service->page->translate->__('地址2'),
            Yii::$service->page->translate->__('地址3'),
            Yii::$service->page->translate->__('联系人'),
            Yii::$service->page->translate->__('电话'),
            Yii::$service->page->translate->__('买家留言'),
			Yii::$service->page->translate->__('公司名称CN'),
			Yii::$service->page->translate->__('公司名称EN'),
        ];
        if (!empty($order_arr)) {
            $orderFilter = [
               'numPerPage' 	=> 1000,
               'pageNum'		=> 1,
               'where'			=> [
                   ['in', 'order_id', $order_arr],
                ],
                'asArray' => true,
            ];
            $orderData = Yii::$service->order->coll($orderFilter);
            $orderColl = $orderData['coll'];
            // 订单数据
            $orderCollArr = [];
            if (!empty($orderColl) && is_array($orderColl)) {
                foreach ($orderColl as $order) {
                    $orderCollArr[$order['order_id']] = $order;
                }
            }
			
            // 查找订单产品
            $orderFilter = [
               'numPerPage' 	=> 1000,
               'pageNum'		=> 1,
               'orderBy'	    => ['order_id' => SORT_DESC ],
               'where'			=> [
                   ['in', 'order_id', $order_arr],
                ],
                'asArray' => true,
            ];
            $orderItemData = Yii::$service->order->item->coll($orderFilter);
            $orderItemColl = $orderItemData['coll'];
			
            $areas=Yii::$service->shipping->area;
            if (!empty($orderItemColl) && is_array($orderItemColl)) {
            	$i=1;
				
				//生成csv文件
					$filename=date('Y-m-d-H-i-s').".csv";
					$local_file='./ftpupload/'.$filename;
					$stream = fopen($local_file,'a+'); 
					if(!$stream){
						Yii::$service->email->send([
							'to' => 'lilyliang@cn.samsonpaper.com',
							'subject' => 'order upload sap',
							'htmlBody' => $local_file."打不开",
							'senderName'=> 'test',
					   ]);
						echo json_encode([
						   'code' 	=> 2,
						   'message'		=> $local_file."打不开"
						],true);
						
						exit;
					}
					
					if (!empty($colHeaders)) {
						fputcsv($stream, $colHeaders);  
					}
				$sapCodes = Yii::$service->payment->getPaymentSapIDs();		
                foreach ($orderItemColl as $orderItem) {
                    $order_id = $orderItem['order_id'];
                    if (isset($orderCollArr[$order_id])) {
                        $order = $orderCollArr[$order_id];
                        $countryid=is_numeric($order['customer_address_country'])?$order['customer_address_country']-1:-1;
                        if(isset($areas[$countryid])){
        	
				        	if($areas[$countryid]['translate']){
				        		$order['customer_address_country_name'] = Yii::$service->page->translate->__($areas[$countryid]['translate']);
				        	}else{
				        		$order['customer_address_country_name'] = $areas[$countryid]['name'];
				        	}
				        	$stateid=is_numeric($order['customer_address_state'])?$order['customer_address_state']-1:-1;
				        	
				        	if(isset($areas[$countryid]['cityList'][$stateid])){
				        		if($areas[$countryid]['cityList'][$stateid]['translate']){
				            		$order['customer_address_state_name'] = Yii::$service->page->translate->__($areas[$countryid]['cityList'][$stateid]['translate']);
				            	}else{
				            		$order['customer_address_state_name'] = $areas[$countryid]['cityList'][$stateid]['name'];
				            	}
				        	}
				        	$cityid=is_numeric($order['customer_address_city'])?$order['customer_address_city']-1:-1;
				        	if(isset($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid])){
				        		if($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['translate']){
				            		$order['customer_address_city_name'] = Yii::$service->page->translate->__($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['translate']);
				            	}else{
				            		$order['customer_address_city_name'] = $areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['name'];
				            	}
				            	$weekday=$areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['weekday'];
				        	}
				        }else{
				        
							$order['customer_address_state_name']  = Yii::$service->helper->country->getStateByContryCode($order['customer_address_country'], $order['customer_address_state']);
				        	$order['customer_address_country_name']= Yii::$service->helper->country->getCountryNameByKey($order['customer_address_country']);
				        
				        	$order['customer_address_city_name']=$order['customer_address_city'];
				        }
				        $shipping_data="{$order['customer_firstname']} {$order['customer_lastname']} {$order['customer_telephone']} {$order['customer_address_country_name']} {$order['customer_address_state_name']} {$order['customer_address_city_name']} {$order['customer_address_street1']} {$order['customer_address_street2']}";
						$order_data="{$order['order_customer_firstname']} {$order['customer_lastname']} {$order['order_customer_email']}";
						$shipping_fee='';
				        if(!$order['sap_id']){
				        	$order['sap_id']=70000;
				        }
				        if(!$order['companycn_name']){
				        	$order['companycn_name']=$order_data;
				        }
				        if($order['shipping_total']>0){
				        	$shipping_fee=$order['shipping_total'];
				        	$orderCollArr[$order_id]['shipping_total']=0;
							$excelArr[]=[
								'',date('Ymd', $order['created_at']),date('Ymd', $order['updated_at']),$order_type,'',$order['increment_id'],
								'DELIVERY',1,'ZTEST',$order_storage,'01',$order['customer_telephone'],'EA',
								$shipping_data,$shipping_fee,'0','HKD',$sapCodes[$order['payment_method']],'DELIVERY','','',date('Ymd', $order['shipping_date']),
								'ZAN',$order_sales_organization,'00','00','',$order['sap_id'],$order['sap_id'],$order_sales_factory,$order_data,$i*10,1,'',$order['companycn_name'],"{$order['customer_address_country_name']}{$order['customer_address_city_name']}{$order['customer_address_street1']}","{$order['customer_address_street2']}",
									"{$order['customer_firstname']} {$order['customer_lastname']}",$order['customer_telephone'],$order['order_remark'],$order['companycn'],$order['companyen']
								];
				        	fputcsv($stream, [
								'',date('Ymd', $order['created_at']),date('Ymd', $order['updated_at']),$order_type,'',$order['increment_id'],
								'DELIVERY',1,'ZTEST',$order_storage,'01',$order['customer_telephone'],'EA',
								$shipping_data,$shipping_fee,'0','HKD',$sapCodes[$order['payment_method']],'DELIVERY','','',date('Ymd', $order['shipping_date']),
								'ZAN',$order_sales_organization,'00','00','',$order['sap_id'],$order['sap_id'],$order_sales_factory,$order_data,$i*10,1,'',$order['companycn_name'],"{$order['customer_address_country_name']}{$order['customer_address_city_name']}{$order['customer_address_street1']}","{$order['customer_address_street2']}",
									"{$order['customer_firstname']} {$order['customer_lastname']}",$order['customer_telephone'],$order['order_remark'],$order['companycn'],$order['companyen']
								]);
								$i++;
				        }
				        $excelArr[]=[
								'',date('Ymd', $order['created_at']),date('Ymd', $order['updated_at']),$order_type,'',$order['increment_id'],
								$orderItem['sku'],$orderItem['qty'],'ZTEST',$order_storage,'01',$order['customer_telephone'],$orderItem['sap_unit'],
								$shipping_data,$orderItem['base_price'],'0','HKD',$sapCodes[$order['payment_method']],$orderItem['sku'],'','',date('Ymd', $order['shipping_date']),
								'ZAN',$order_sales_organization,'00','00','',$order['sap_id'],$order['sap_id'],$order_sales_factory,$order_data,$i*10,1,'',$order['companycn_name'],"{$order['customer_address_country_name']}{$order['customer_address_city_name']}{$order['customer_address_street1']}","{$order['customer_address_street2']}",
									"{$order['customer_lastname']} {$order['customer_firstname']}",$order['customer_telephone'],$order['order_remark'],$order['companycn'],$order['companyen']
							];
                        fputcsv($stream, [
								'',date('Ymd', $order['created_at']),date('Ymd', $order['updated_at']),$order_type,'',$order['increment_id'],
								$orderItem['sku'],$orderItem['qty'],'ZTEST',$order_storage,'01',$order['customer_telephone'],$orderItem['sap_unit'],
								$shipping_data,$orderItem['base_price'],'0','HKD',$sapCodes[$order['payment_method']],$orderItem['sku'],'','',date('Ymd', $order['shipping_date']),
								'ZAN',$order_sales_organization,'00','00','',$order['sap_id'],$order['sap_id'],$order_sales_factory,$order_data,$i*10,1,'',$order['companycn_name'],"{$order['customer_address_country_name']}{$order['customer_address_city_name']}{$order['customer_address_street1']}","{$order['customer_address_street2']}",
									"{$order['customer_lastname']} {$order['customer_firstname']}",$order['customer_telephone'],$order['order_remark'],$order['companycn'],$order['companyen']
							]);
                    }
                    $i++;
                }
				
				@fclose($stream);
				
				//ftp上传
					$result =Yii::$service->ftp->connect();
					if ( ! $result){
						Yii::$service->email->send([
							'to' => 'lilyliang@cn.samsonpaper.com',
							'subject' => 'order upload sap',
							'htmlBody' => Yii::$service->ftp->get_error_msg(),
							'senderName'=> 'test',
					   ]);
						echo json_encode([
						   'code' 	=> 2,
						   'message'		=> Yii::$service->ftp->get_error_msg()
						],true);
						
						exit;
					}
					
					//上传文件
					if (Yii::$service->ftp->upload($local_file,'SAP Burotech Import/'.$filename)){
						Yii::$service->email->send([
							'to' => 'lilyliang@cn.samsonpaper.com',
							'subject' => 'order upload sap',
							'htmlBody' => '上传成功',
							'senderName'=> 'test',
					   ]);
						\fec\helpers\CExcel::downloadExcelFileByArray($excelArr);
						
						exit;
					}else{
						Yii::$service->email->send([
							'to' => 'lilyliang@cn.samsonpaper.com',
							'subject' => 'order upload sap',
							'htmlBody' => '上传失败',
							'senderName'=> 'test',
					   ]);
						echo json_encode([
						   'code' 	=> 2,
						   'message'		=> '上传失败'
						],true);
						
						exit;
					}
					
            }
        }
        echo json_encode([
						   'code' 	=> 2,
						   'message'		=> "没有订单"
						],true);
						
						exit;
        //\fec\helpers\CExcel::downloadExcelFileByArray($excelArr);
        
    }
    public function exportExcelSAPAuto(){
        
        //$order_arr = explode(',', $order_ids);
        $colHeaders = $excelArr[] = [
            Yii::$service->page->translate->__('系统订单'),
            Yii::$service->page->translate->__('下单日期'),
            Yii::$service->page->translate->__('发货日期') ,
            Yii::$service->page->translate->__('单据类型'),
            Yii::$service->page->translate->__('销售办事处'),
            Yii::$service->page->translate->__('平台单号'),
            Yii::$service->page->translate->__('商品编码'),
            Yii::$service->page->translate->__('数量'), 
            Yii::$service->page->translate->__('行项目文本'),
            Yii::$service->page->translate->__('库存地点') ,
            Yii::$service->page->translate->__('装运条件'),
            Yii::$service->page->translate->__('客户联系人'),
            Yii::$service->page->translate->__('单位'),
            Yii::$service->page->translate->__('单抬头文本'),
            Yii::$service->page->translate->__('单价'),
            Yii::$service->page->translate->__('总金额'),
            Yii::$service->page->translate->__('货币') ,
            Yii::$service->page->translate->__('付款条件'),
            Yii::$service->page->translate->__('物料编码'),
            Yii::$service->page->translate->__('规格型号'),
            Yii::$service->page->translate->__('物料描述'),
            Yii::$service->page->translate->__('求交货日期'),
            Yii::$service->page->translate->__('行项目类别'),
            Yii::$service->page->translate->__('销售组织'),
            Yii::$service->page->translate->__('分销渠道'),
            Yii::$service->page->translate->__('产品组'),
            Yii::$service->page->translate->__('销售组'),
            Yii::$service->page->translate->__('客户编号') ,
            Yii::$service->page->translate->__('送达方'),
            Yii::$service->page->translate->__('工厂'),
            Yii::$service->page->translate->__('订单原因'),
            Yii::$service->page->translate->__('行项目'),
            Yii::$service->page->translate->__('价格单位'),
            Yii::$service->page->translate->__('一次性客户名称'),
            Yii::$service->page->translate->__('地址2'),
            Yii::$service->page->translate->__('地址3'),
            Yii::$service->page->translate->__('联系人'),
            Yii::$service->page->translate->__('电话'),
            
        ];
    	
            $orderFilter = [
               //'numPerPage' 	=> 1000,
               //'pageNum'		=> 1,
               'where'			=> [
                   ['in', 'order_status', array(Yii::$service->order->payment_status_processing)],
				   ['in', 'order_process_status', array(Yii::$service->order->status_processing,Yii::$service->order->status_completed)],
				   ['>=','created_at',strtotime(date('Y-m-d'))]
                ],
                'asArray' => true,
            ];
			
            $orderData = Yii::$service->order->coll($orderFilter);
			
            $orderColl = $orderData['coll'];
            // 订单数据
            $orderCollArr = [];
            if (!empty($orderColl) && is_array($orderColl)) {
                foreach ($orderColl as $order) {
                    $orderCollArr[$order['order_id']] = $order;
					$order_arr[]=$order['order_id'];
                }
            }
            
            // 查找订单产品
            $orderFilter = [
               //'numPerPage' 	=> 1000,
               //'pageNum'		=> 1,
               'orderBy'	    => ['order_id' => SORT_DESC ],
               'where'			=> [
                   ['in', 'order_id', $order_arr],
                ],
                'asArray' => true,
            ];
            $orderItemData = Yii::$service->order->item->coll($orderFilter);
            $orderItemColl = $orderItemData['coll'];
            $areas=Yii::$service->shipping->area;
            if (!empty($orderItemColl) && is_array($orderItemColl)) {
            	$i=1;
            	//生成csv文件
				$filename=date('Y-m-d-H-i-s').".csv";
				$stream = fopen($filename,'a+'); 
				if(!$stream){
					echo json_encode([
					   'code' 	=> 2,
					   'message'		=> $filename."打不开"
					],true);
					Yii::$service->email->send([
						'to' => 'lilyliang@cn.samsonpaper.com',
						'subject' => 'order upload sap',
						'htmlBody' => $filename."打不开",
						'senderName'=> 'test',
				   ]);
					exit;
				}
				if (!empty($colHeaders)) {
					fputcsv($stream, $colHeaders);  
				}
                foreach ($orderItemColl as $orderItem) {
                    $order_id = $orderItem['order_id'];
                    if (isset($orderCollArr[$order_id])) {
                        $order = $orderCollArr[$order_id];
                        $countryid=is_numeric($order['customer_address_country'])?$order['customer_address_country']-1:-1;
                        if(isset($areas[$countryid])){
        	
				        	if($areas[$countryid]['translate']){
				        		$order['customer_address_country_name'] = Yii::$service->page->translate->__($areas[$countryid]['translate']);
				        	}else{
				        		$order['customer_address_country_name'] = $areas[$countryid]['name'];
				        	}
				        	$stateid=is_numeric($order['customer_address_state'])?$order['customer_address_state']-1:-1;
				        	
				        	if(isset($areas[$countryid]['cityList'][$stateid])){
				        		if($areas[$countryid]['cityList'][$stateid]['translate']){
				            		$order['customer_address_state_name'] = Yii::$service->page->translate->__($areas[$countryid]['cityList'][$stateid]['translate']);
				            	}else{
				            		$order['customer_address_state_name'] = $areas[$countryid]['cityList'][$stateid]['name'];
				            	}
				        	}
				        	$cityid=is_numeric($order['customer_address_city'])?$order['customer_address_city']-1:-1;
				        	if(isset($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid])){
				        		if($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['translate']){
				            		$order['customer_address_city_name'] = Yii::$service->page->translate->__($areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['translate']);
				            	}else{
				            		$order['customer_address_city_name'] = $areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['name'];
				            	}
				            	$weekday=$areas[$countryid]['cityList'][$stateid]['areaList'][$cityid]['weekday'];
				        	}
				        }else{
				        
							$order['customer_address_state_name']  = Yii::$service->helper->country->getStateByContryCode($order['customer_address_country'], $order['customer_address_state']);
				        	$order['customer_address_country_name']= Yii::$service->helper->country->getCountryNameByKey($order['customer_address_country']);
				        
				        	$order['customer_address_city_name']=$order['customer_address_city'];
				        }
				        $shipping_data="{$order['customer_firstname']} {$order['customer_lastname']} {$order['customer_telephone']} {$order['customer_address_country_name']} {$order['customer_address_state_name']} {$order['customer_address_city_name']} {$order['customer_address_street1']} {$order['customer_address_street2']}";
				        $order_data="{$order['order_customer_firstname']} {$order['customer_lastname']} {$order['order_customer_email']}";
				        $shipping_fee='';
				        if(!$order['sap_id']){
				        	$order['sap_id']=70000;
				        }
				        if(!$order['companycn_name']){
				        	$order['companycn_name']=$order_data;
				        }
						
						
				        if($order['shipping_total']>0){
				        	$shipping_fee=$order['shipping_total'];
				        	$orderCollArr[$order_id]['shipping_total']=0;
				        	fputcsv($stream, [
                        	'',date('Ymd', $order['created_at']),date('Ymd', $order['updated_at']),'ZWEB','',$order['increment_id'],
                        	'DELIVERY',$orderItem['qty'],'ZTEST','S001','01',$order['customer_telephone'],'EA',
                        	$shipping_data,$shipping_fee,'0','HKD','M1','DELIVERY','','',date('Ymd', $order['shipping_date']),
                        	'ZAN','1538','00','00','',$order['sap_id'],$order['sap_id'],'1538',$order_data,$i*10,1,$order['companycn_name'],"{$order['customer_address_country_name']} {$order['customer_address_state_name']} {$order['customer_address_city_name']} ","{$order['customer_address_street1']} {$order['customer_address_street2']}",
                        	    "{$order['customer_firstname']} {$order['customer_lastname']}",$order['customer_telephone']
							]);
							$i++;
				        }
				        
                        fputcsv($stream, [
                        	'',date('Ymd', $order['created_at']),date('Ymd', $order['updated_at']),'ZWEB','',$order['increment_id'],
                        	$orderItem['sku'],$orderItem['qty'],'ZTEST','S001','01',$order['customer_telephone'],$orderItem['unit'],
                        	$shipping_data,$orderItem['base_price'],'0','HKD','M1',$orderItem['sku'],'','',date('Ymd', $order['shipping_date']),
                        	'ZAN','1538','00','00','',$order['sap_id'],$order['sap_id'],'1538',$order_data,$i*10,1,$order['companycn_name'],"{$order['customer_address_country_name']} {$order['customer_address_state_name']} {$order['customer_address_city_name']} ","{$order['customer_address_street1']} {$order['customer_address_street2']}",
                        	    "{$order['customer_lastname']} {$order['customer_firstname']}",$order['customer_telephone']
                        ]);
                    }
                    $i++;
                }
            }
        
		@fclose($stream); 
		
		//ftp上传
		$result =Yii::$service->ftp->connect();
		if ( ! $result){
			echo json_encode([
			   'code' 	=> 2,
			   'message'		=> Yii::$service->ftp->get_error_msg()
			],true);
			Yii::$service->email->send([
				'to' => 'lilyliang@cn.samsonpaper.com',
				'subject' => 'order upload sap',
				'htmlBody' => Yii::$service->ftp->get_error_msg(),
				'senderName'=> 'test',
           ]);
			exit;
		}
		//上传文件
		if (Yii::$service->ftp->upload($filename,'import.csv')){
			echo json_encode([
			   'code' 	=> 2,
			   'message'		=> '上传成功'
			],true);
			Yii::$service->email->send([
				'to' => 'lilyliang@cn.samsonpaper.com',
				'subject' => 'order upload sap',
				'htmlBody' => '上传成功',
				'senderName'=> 'test',
           ]);
			exit;
		}else{
			echo json_encode([
			   'code' 	=> 2,
			   'message'		=> '上传失败'
			],true);
			Yii::$service->email->send([
				'to' => 'lilyliang@cn.samsonpaper.com',
				'subject' => 'order upload sap',
				'htmlBody' => '上传失败',
				'senderName'=> 'test',
           ]);
			exit;
		}
        // \fec\helpers\CExcel::downloadExcelFileByArray($excelArr);
        
    }
    public function exportExcel(){
        $order_ids = Yii::$app->request->post('order_ids');
		
        $order_arr = explode(',', $order_ids);
        $excelArr[] = [
            Yii::$service->page->translate->__('Order Id'),
            Yii::$service->page->translate->__('Increment Id'),
            Yii::$service->page->translate->__('Order Status') ,
            Yii::$service->page->translate->__('Store'),
            Yii::$service->page->translate->__('Created At'),
            Yii::$service->page->translate->__('Update At'),
            Yii::$service->page->translate->__('Base Grand Total'),
            Yii::$service->page->translate->__('Customer Id'), 
            Yii::$service->page->translate->__('Order Email'),
            Yii::$service->page->translate->__('First Name') ,
            Yii::$service->page->translate->__('Last Name'),
            Yii::$service->page->translate->__('Is Guest'),
            Yii::$service->page->translate->__('Coupon Code'),
            Yii::$service->page->translate->__('Payment Method'),
            Yii::$service->page->translate->__('Shipping Method'),
            Yii::$service->page->translate->__('Base Shipping Total'),
            Yii::$service->page->translate->__('Telephone') ,
            Yii::$service->page->translate->__('Country'),
            Yii::$service->page->translate->__('State'),
            Yii::$service->page->translate->__('City'),
            Yii::$service->page->translate->__('Zip'),
            Yii::$service->page->translate->__('Street1'),
            Yii::$service->page->translate->__('Street2'),
            Yii::$service->page->translate->__('Remark'),
            Yii::$service->page->translate->__('Product Id'),
            Yii::$service->page->translate->__('Sku'),
            Yii::$service->page->translate->__('Product Name'),
            Yii::$service->page->translate->__('Custom Option Sku') ,
            Yii::$service->page->translate->__('Weight'),
            Yii::$service->page->translate->__('Qty'),
            Yii::$service->page->translate->__('Product Unit Price(base price)'),
        ];
        if (!empty($order_arr)) {
            $orderFilter = [
               'numPerPage' 	=> 1000,
               'pageNum'		=> 1,
               'where'			=> [
                   ['in', 'order_id', $order_arr],
                ],
                'asArray' => true,
            ];
            $orderData = Yii::$service->order->coll($orderFilter);
			
            $orderColl = $orderData['coll'];
            // 订单数据
            $orderCollArr = [];
            if (!empty($orderColl) && is_array($orderColl)) {
                foreach ($orderColl as $order) {
                    $orderCollArr[$order['order_id']] = $order;
                }
            }
            // 查找订单产品
            $orderFilter = [
               'numPerPage' 	=> 1000,
               'pageNum'		=> 1,
               'orderBy'	    => ['order_id' => SORT_DESC ],
               'where'			=> [
                   ['in', 'order_id', $order_arr],
                ],
                'asArray' => true,
            ];
            $orderItemData = Yii::$service->order->item->coll($orderFilter);
            $orderItemColl = $orderItemData['coll'];
            if (!empty($orderItemColl) && is_array($orderItemColl)) {
                foreach ($orderItemColl as $orderItem) {
                    $order_id = $orderItem['order_id'];
                    if (isset($orderCollArr[$order_id])) {
                        $order = $orderCollArr[$order_id];
                        $excelArr[] = [
                            $order['order_id'], $order['increment_id'], $order['order_status'], 
                            $order['store'], date('Y-m-d H:i:s', $order['created_at']), date('Y-m-d H:i:s', $order['updated_at']), 
                            $order['base_grand_total'], $order['customer_id'], $order['customer_email'], 
                            $order['customer_firstname'], $order['customer_lastname'], $order['customer_is_guest'] == 1 ? '是' : '否', 
                            $order['coupon_code'], $order['payment_method'], $order['shipping_method'], 
                            $order['base_shipping_total'], $order['customer_telephone'], $order['customer_address_country'], 
                            $order['customer_address_state'], $order['customer_address_city'], $order['customer_address_zip'], 
                            $order['customer_address_street1'], $order['customer_address_street2'], $order['order_remark'], 
                            
                            $orderItem['product_id'], $orderItem['sku'], $orderItem['name'], 
                            $orderItem['custom_option_sku'], $orderItem['weight'], 
                            $orderItem['qty'], $orderItem['base_price'],
                        ];
                    }
                }
            }
        }
        
        \fec\helpers\CExcel::downloadExcelFileByArray($excelArr);
    }
   public function creditpayRefund(){
        $order_ids = Yii::$app->request->post('order_ids');
		$refund = Yii::$app->request->post('refund');
        $order_arr = explode(',', $order_ids);
        
        if (!empty($order_arr)) {
            $orderFilter = [
               //'numPerPage' 	=> 1000,
               //'pageNum'		=> 1,
               'where'			=> [
                   ['in', 'order_id', $order_arr],
                ],
                'asArray' => true,
            ];
            $orderData = Yii::$service->order->coll($orderFilter);
            $orderColl = $orderData['coll'];
            // 订单数据
			//是否为creditpay
			//是否为一人
			//计算总额，是否相等
			//判断是否已还款，还款状态
			
			
            $orderCollArr = [];
			$user = [];
			$total =0;
			$order_ids=[];
            if (!empty($orderColl) && is_array($orderColl)) {
                foreach ($orderColl as $order) {
					
                    $orderCollArr[$order['order_id']] = $order;
					array_push($user,$order['customer_id']);
					$total+=$order['base_grand_total'];

					if(!in_array($order['payment_method'],Yii::$service->creditpay->refund->creditpay_payment)){
						echo json_encode([
						   'code' 	=> 2,
						   'message'		=> "order:".$order['increment_id']."订单中中有不符订单，无法付款"
						],true);
						exit;
					}
					if(!in_array($order['credit_refund_status'],Yii::$service->creditpay->refund->creditpay_refund_status_notyet)){
						echo json_encode([
						   'code' 	=> 2,
						   'message'		=> "order:".$order['increment_id']."订单中中有不符订单，无法付款"
						],true);
						exit;
					}
					$order_ids[]=$order['increment_id'];
                }
				$user=array_unique($user);
				if(count($user)==1 && $total == $refund){
					//进行还款
					
					Yii::$service->creditpay->refund->setRefund(implode(',',$order_arr),$total,$user[0],$order_ids);
					
					echo json_encode([
						   'code' 	=> 1,
						   'message'		=> implode(',',$order_arr)."共还款".$total
						],true);
						exit;
				}
            }
			echo json_encode([
						   'code' 	=> 2,
						   'message'		=> "未知原因".$total .$refund
						],true);
						exit;
            die();
        }
       // \fec\helpers\CExcel::downloadExcelFileByArray($excelArr);
    }
}
