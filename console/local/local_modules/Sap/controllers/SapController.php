<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace console\local\local_modules\Sap\controllers;

use Yii;
use yii\console\Controller;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class SapController extends Controller
{
    /**
     * 每日订单上传
     */
    public function actionFtpuploadsap()
    {
		
		$order_type="ZWEB";
		$order_storage="S001";
		$order_sales_organization="1538";
		$order_sales_factory="1538";
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
    	
            $orderFilter = [
               //'numPerPage' 	=> 1000,
               //'pageNum'		=> 1,
               'where'			=> [
                   ['in', 'order_status', array(Yii::$service->order->payment_status_processing,Yii::$service->order->payment_status_confirmed,Yii::$service->order->payment_status_confirmed_part)],
				   ['in', 'order_process_status', array(Yii::$service->order->status_processing,Yii::$service->order->status_completed,Yii::$service->order->status_init)],
				   ['>=','created_at',strtotime(date('Y-m-d',strtotime("-2 day")))]
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
            if(isset($order_arr)&&!empty($order_arr)){
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
					$local_file=dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/appadmin/web/ftpupload/'.$filename;
					
					$stream = fopen($local_file,'w+'); 
					chmod($local_file, 0777);
					if(!$stream){
						Yii::$service->email->send([
							'to' => 'lilyliang@cn.samsonpaper.com',
							'subject' => 'order upload sap',
							'htmlBody' => $local_file."打不开",
							'senderName'=> 'test',
					   ]);
					   \Yii::info( $local_file."打不开",'fecshop_debug');
						return json_encode([
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
								fputcsv($stream, [
								'',date('Ymd', $order['created_at']),date('Ymd', $order['updated_at']),$order_type,'',$order['increment_id'],
								'DELIVERY',1,'ZTEST',$order_storage,'01',$order['customer_telephone'],'EA',
								$shipping_data,$shipping_fee,'0','HKD',$sapCodes[$order['payment_method']],'DELIVERY','','',date('Ymd', $order['shipping_date']),
								'ZAN',$order_sales_organization,'00','00','',$order['sap_id'],$order['sap_id'],$order_sales_factory,$order_data,$i*10,1,'',$order['companycn_name'],"{$order['customer_address_country_name']}{$order['customer_address_city_name']}{$order['customer_address_street1']}","{$order['customer_address_street2']}",
									"{$order['customer_firstname']} {$order['customer_lastname']}",$order['customer_telephone'],$order['order_remark'],$order['companycn'],$order['companyen']
								]);
								$i++;
							}
							
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
					   \Yii::info( Yii::$service->ftp->get_error_msg(),'fecshop_debug');
						echo json_encode([
						   'code' 	=> 2,
						   'message'		=> Yii::$service->ftp->get_error_msg()
						],true);
						
						exit;
					}
					//上传文件
					if (Yii::$service->ftp->upload($local_file,'SAP Burotech Import/'.$filename)){
						/*Yii::$service->email->send([
							'to' => 'lilyliang@cn.samsonpaper.com',
							'subject' => 'order upload sap',
							'htmlBody' => '上传成功',
							'senderName'=> 'test',
					   ]);*/
					   \Yii::info("上传成功",'fecshop_debug');
						echo json_encode([
						   'code' 	=> 2,
						   'message'		=> '上传成功'
						],true);
						
						exit;
					}else{
						Yii::$service->email->send([
							'to' => 'lilyliang@cn.samsonpaper.com',
							'subject' => 'order upload sap',
							'htmlBody' => '上传失败',
							'senderName'=> 'test',
					   ]);
					   \Yii::info("上传失败",'fecshop_debug');
						echo json_encode([
						   'code' 	=> 2,
						   'message'		=> '上传失败'
						],true);
						
						exit;
					}
				}
			}
			\Yii::info("没有订单",'fecshop_debug');
			/*Yii::$service->email->send([
				'to' => 'lilyliang@cn.samsonpaper.com',
				'subject' => 'order upload sap',
				'htmlBody' => '没有订单',
				'senderName'=> 'test',
		   ]);*/
			echo json_encode([
						   'code' 	=> 2,
						   'message'		=> '没有订单'
						],true);
						
						exit;
    }
    
    
}
