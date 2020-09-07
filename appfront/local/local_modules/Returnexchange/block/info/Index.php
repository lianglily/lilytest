<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Returnexchange\block\info;

use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Index
{
    protected $numPerPage = 10;
    protected $pageNum;
    protected $orderBy;
    protected $_page = 'p';

    /**
     * 初始化类变量.
     */
    public function initParam()
    {
        $this->pageNum = (int) Yii::$app->request->get('p');
        $this->pageNum = ($this->pageNum >= 1) ? $this->pageNum : 1;
        $this->orderBy = ['time' => SORT_DESC];
    }

    public function getLastData($order_id)
    {
        $data=Yii::$service->returnexchange->getProductItemByOrderId($order_id);
        if($data&&!empty($data)){
        	$identity = Yii::$app->user->identity;
            $customer_id = $identity->id;
            if ($data[0]['customer_id'] == $customer_id) {
                return $data;
            }
        }
        return [];
        
    }
    public function getSalesExchange($items){
    	$data=Yii::$service->returnexchange->getProductItemByItemsAndCustomer($items,Yii::$app->user->identity->id);
    
        if($data&&!empty($data)){
        	return $data;
        }
        return [];
    }
    public function getSalesReturn($items){
    	$data=Yii::$service->returnexchange->getProductItemByItemsAndCustomer($items,Yii::$app->user->identity->id);
    	
        if($data&&!empty($data)){
        	
        	return $data;
        }
        return [];
    }
    public function getReturns($return_id){
    	$data=Yii::$service->returnexchange->getReturnProductItemByReturnId($return_id,Yii::$app->user->identity->id);
    	
        if($data&&!empty($data)){
        	
        	return $data;
        }
        return [];
    }
    public function saveSalesReturn(){
    	
    	$param=[];
    	$editForm=Yii::$app->request->post('editForm');
    	if(empty($editForm) || !is_array($editForm)){
    		$result['status']='fail';
    		$result['code']=1;
			$result['content']=Yii::$service->page->translate->__("Error Msg");
			return $result;
    	}
    	//判断该订单是否存在
    	$items=$editForm['items'];
    	
    	$data=Yii::$service->returnexchange->getProductItemByItemsAndCustomer($items,Yii::$app->user->identity->id);
    	if(count($data)!=count($items)){
    		$result['status']='fail';
    		$result['status']='2';
			$result['content']=Yii::$service->page->translate->__("Invalid Item");
			return $result;
    	}
    	if($_FILES && is_array($_FILES) && !empty($_FILES)){
			//文件上传，得到url
			foreach($_FILES as $key => $val){
				if(!isset($val['name'])||empty($val['name'])||empty($val['tmp_name'])){
					break;
				}
				try{
					
					$saveImgInfo = Yii::$service->apply->attachment->saveProductUploadImg($val);
					if (is_array($saveImgInfo) && !empty($saveImgInfo)) {
						$img=	$saveImgInfo[0];
					}
					
				}catch(InvalidValueException $e){
					$result['status']='fail';
		    		$result['code']=3;
					$result['content']=Yii::$service->page->translate->__("Upload Error");
					return $result;
				}
			}
		}
		
    	$items_data=[];
    	foreach ($data as $val){
    		$item_id=$val['item_id'];
    		$items_data[$item_id]=$val;
    	}
		$param=[];
		$set_order=[];
		foreach ($editForm['items'] as $key => $val){
			//判断订单状态，订单商品状态，订单商品个数
			if(!isset($items_data[$val])){
				$result['status']='fail';
	    		$result['code']=4;
				$result['content']=Yii::$service->page->translate->__("Invalid Item");
				$result['data']=$val;
				return $result;
			}
			if(in_array($items_data[$val]['order_status'],Yii::$service->returnexchange->getReturnInvaildPaymentStatusArr())||!isset($items_data[$val]['order_process_status'])){
				$result['status']='fail';
	    		$result['code']=5;
				$result['content']=Yii::$service->page->translate->__("Invalid Order Status");
				$result['data']=$items_data[$val];
				return $result;
			}
			if($editForm['qty'][$key]>$items_data[$val]['qty']){
				$result['status']='fail';
	    		$result['code']=6;
				$result['content']=Yii::$service->page->translate->__("Invalid Qty");
				$result['data']=$items_data[$val];
				return $result;
			}
			if(isset(Yii::$service->returnexchange->getReturnTypeArr()[$items_data[$val]['retuan_status']])){
				$result['status']='fail';
	    		$result['code']=7;
				$result['content']=Yii::$service->page->translate->__("Invalid Return Process Status");
				$result['data']=$items_data[$val];
				return $result;
			}
			if(!in_array($items_data[$val]['order_id'],$set_order)){
				array_push($set_order,$items_data[$val]['order_id']);
			}
					
			$param[$val]['product_id']=$val;
			$param[$val]['order_id']=$items_data[$val]['order_id'];
			$param[$val]['type']=$editForm['type'];
			$param[$val]['desc']=isset($editForm['desc'])?$editForm['desc']:'';
			$param[$val]['sku']=$items_data[$val]['sku'];
			$param[$val]['price']=$items_data[$val]['price'];
			$param[$val]['base_price']=$items_data[$val]['base_price'];
			$param[$val]['order_currency_code']=$items_data[$val]['order_currency_code'];
			$param[$val]['order_to_base_rate']=$items_data[$val]['order_to_base_rate'];
			$param[$val]['base_subtotal']=$items_data[$val]['base_subtotal'];
			$param[$val]['base_subtotal_with_discount']=$items_data[$val]['base_subtotal_with_discount'];
			$param[$val]['created_at']=time();
			
			
			$param[$val]['qty']=$editForm['qty'][$key];
			
		}
		
		$set_order=[];
	    $set_order['reason']=isset($editForm['reason'])?$editForm['reason']:'';
		$set_order['return_process_status']=isset($editForm['return_process_status'])?$editForm['return_process_status']:'';
		$set_order['type']=isset($editForm['type'])?$editForm['type']:'';
		$set_order['repayment_method']=isset($editForm['repayment_method'])?$editForm['repayment_method']:'';
		$set_order['repayment_info']=isset($editForm['repayment_info'])?$editForm['repayment_info']:'';
		$set_order['shipping']=isset($editForm['shipping'])?$editForm['shipping']:'';
		
		$set_order['tracking_number']=isset($editForm['tracking_number'])?$editForm['tracking_number']:'';
		$set_order['img']=isset($img)?$img:'';
		
		if(Yii::$service->returnexchange->saveReturn($param,$set_order,$editForm['type'])){
			$result['status']='success';
    		$result['code']=0;
			
			return $result;
		}else{
			$result['status']='fail';
    		$result['code']=8;
			$result['content']=Yii::$service->page->translate->__("Save Return Error");
			return $result;
		}
		
    }
    
    // 面包屑导航
    protected function breadcrumbs($name)
    {
        if (Yii::$app->controller->module->params['customer_order_breadcrumbs']) {
            Yii::$service->page->breadcrumbs->addItems(['name' => $name]);
        } else {
            Yii::$service->page->breadcrumbs->active = false;
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