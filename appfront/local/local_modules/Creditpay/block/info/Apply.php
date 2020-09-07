<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Creditpay\block\info;

use Yii;
use yii\base\InvalidValueException;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Apply
{

    public function getLastData()
    {
    	//$a=Yii::$service->email->send(array());
    	
        $this->breadcrumbs(Yii::$service->page->translate->__('Account Creditpay'));
		
		//获取creditpay自定义字段
		$info=Yii::$service->creditpay->attr->getActiveAllColl();
		if(Yii::$app->user->identity->credit_status!=-1){
			$demo=Yii::$service->creditpay->customer->getByCustomerId(Yii::$app->user->identity->id);
		}else{
			$info['Name_CN']['value']=Yii::$app->user->identity->companycn;
			$info['Name_EN']['value']=Yii::$app->user->identity->companyen;
			$address=Yii::$service->customer->address->getDefaultAddress();
			
			$info['Shipping_Address']['value']="{$address->country}##{$address->state}##{$address->city}##{$address->street1}##{$address->street2}";
			$demo['info']=json_encode($info);
			
		}
		
        return ['info'=>$info,'fields'=>$this->getFieldArr(),'data'=>$demo];
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
	
	/**
     * config function ,return table columns config.
     */
    public function getFieldArr()
    {
        $table_th_bar = [
        
            'name' => 			[
                'orderField'    => 'name',
                'label'           => Yii::$service->page->translate->__('Attr Name'),
                'width'          => '110',
                'align'           => 'left',
				'translate'			  =>true,
            ],
            
            'db_type' =>		[
                'orderField'    => 'db_type',
                'label'           => Yii::$service->page->translate->__('Db Type'),
                'width'          => '110',
                'align'           => 'center',
            ],
            
            'display_type' => 	[
                'orderField'    => 'display_type',
                'label'           => Yii::$service->page->translate->__('Display Type'),
                'width'          => '110',
                'align'           => 'center',
            ],
			'show_as_img' => 	[
                'orderField'    => 'show_as_img',
                'label'           => Yii::$service->page->translate->__('Show As Img'),
                'width'          => '50',
                'align'           => 'center',
                'display'        => [
                    1 => Yii::$service->page->translate->__('Yes'),
                    2 => Yii::$service->page->translate->__('No'),
                ],
            ],
            'is_require' =>		[
                'orderField'    => 'is_require',
                'label'           => Yii::$service->page->translate->__('Is Required'),
                'width'          => '50',
                'align'           => 'center',
                'display'        => [
                    1 => Yii::$service->page->translate->__('Yes'),
                    2 => Yii::$service->page->translate->__('No'),
                ],
            ],
            'default' =>		[
                'orderField'    => 'default',
                'label'           => Yii::$service->page->translate->__('Default Value'),
                'width'          => '110',
                'align'           => 'center',
            ],
        ];

        return $table_th_bar;
    }
	public function applySave()
    {
    	$result=[];
    	$param = Yii::$app->request->post();
    	
    	if (empty($param) || !is_array($param)) {
    		$result['status']='fail';
			$result['content']='post error';
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
						$param[$key]['value']=	$saveImgInfo[0];
						$param[$key]['display_type']='attachment';
					}
					
				}catch(InvalidValueException $e){
					$result['status']='fail';
					$result['content']=$e->getMessage();
					return $result;
				}
			}
		}
		foreach($param as $key => $val){
			if(!isset($param[$key]['value'])||!isset($param[$key]['display_type'])){
				unset($param[$key]);
			}
		}
		
		$transaction = Yii::$app->db->beginTransaction ();
		try {
			$demo=Yii::$service->creditpay->customer->getByCustomerId(Yii::$app->user->identity->id);
			$demo['customer_id']=Yii::$app->user->identity->id;
			$demo['info']=json_encode($param,JSON_UNESCAPED_UNICODE);
			Yii::$service->creditpay->customer->save($demo);
			
			$identity = Yii::$app->user->identity;
			$identity->credit_status = Yii::$service->creditpay->creditpay_status_processing;
			$identity->save();
		
			$transaction->commit ();
			$result['status']='success';
			Yii::$service->email->order->sendApplyEmail($param,Yii::$app->user->identity->email);
			return $result;
		} catch ( Exception $e ) {
			$transaction->rollback ();
			$result['status']='fail';
			$result['content']=$e->getMessage();
			return $result;
		}
			
		$result['status']='fail';
		$result['content']='未知错误';
			
       return $result;
        
    }
    # 1.保存前台上传的文件。
	public function saveUploadExcelFile($fileFullDir,$name){
        
        $name = $_FILES[$name]["name"];
        $fileFullDir .= 'creditpay_'.Yii::$app->user->identity->id.'_'.time().'_'.rand(1000,9999);
        
        $fileFullDir .='.'.substr(strrchr($name, '.'), 1);
         
        $this->_fileFullDir  = $fileFullDir;    
        $result = @move_uploaded_file($_FILES["file"]["tmp_name"],$fileFullDir);
        
		return $result;
	}
}