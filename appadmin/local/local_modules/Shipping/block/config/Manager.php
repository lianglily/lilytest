<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appadmin\local\local_modules\Shipping\block\config;

use fec\helpers\CUrl;
use fec\helpers\CRequest;
use fecshop\app\appadmin\interfaces\base\AppadminbaseBlockEditInterface;
use fecshop\app\appadmin\modules\AppadminbaseBlockEdit;
use Yii;

/**
 * block cms\staticblock.
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Manager extends AppadminbaseBlockEdit implements AppadminbaseBlockEditInterface
{
    public $_saveUrl;
    // 需要配置
    public $_key = 'shippings_info';
    public $_type;
    protected $_attrArr = [
        'default_shipping',
        'value',
		'label',
		'name'
    ];
    
    public function init()
    {
        // 需要配置
        $this->_saveUrl = CUrl::getUrl('shipping/config/managersave');
        $this->_editFormData = 'editFormData';
        $this->setService();
        $this->_param = CRequest::param();
        $this->_one = $this->_service->getByKey([
            'key' => $this->_key,
        ]);
        if ($this->_one['value']) {
            $this->_one['value'] = unserialize($this->_one['value']);
        }
		
    }
    
    
    
    // 传递给前端的数据 显示编辑form
    public function getLastData()
    {
        $id = ''; 
        if (isset($this->_one['id'])) {
           $id = $this->_one['id'];
        } 
        
        return [
            'id'            =>   $id, 
            'editBar'      => $this->getEditBar(),
            'textareas'   => $this->_textareas,
            'lang_attr'   => $this->_lang_attr,
            'saveUrl'     => $this->_saveUrl,
			'values'	  => $this->_one['value']['values'],
        ];
    }
    public function setService()
    {
        $this->_service = Yii::$service->storeBaseConfig;
    }
    public function getEditArr()
    {
        // language
        $langArr = []; 
        $mutilLangs = Yii::$app->store->get('mutil_lang');
        if (is_array($mutilLangs)) {
            foreach ($mutilLangs as $lang) {
                $langArr[$lang['lang_code']] = $lang['lang_name'];
            }
        }
        // currency
        $currencyArr = []; 
        $currencys = Yii::$app->store->get('currency');
        if (is_array($currencys)) {
            foreach ($currencys as $currency) {
                $currencyArr[$currency['currency_code']] = $currency['currency_code'];
            }
        }
      
        return [
            // 需要配置
            [
                'label' => Yii::$service->page->translate->__('Shipping Method'),
                'name'  => 'default_shipping',
                'display' => [
                    'type' => 'select',
                    'data' => [
                        Yii::$app->store->enable => 'Enable',
                        Yii::$app->store->disable => 'Disable',
                    ],
                ],
                'remark' => '货运方式'
            ],
			[
                'label'  => Yii::$service->page->translate->__('Label'),
                'name' => 'label',
                'display' => [
                    'type' => 'inputString',
                    'lang' => true,
                ],
                'remark' => '',
            ],
			[
                'label'  => Yii::$service->page->translate->__('Name'),
                'name' => 'name',
                'display' => [
                    'type' => 'inputString',
                    'lang' => true,
                ],
                'remark' => '',
            ],
        ];
    }
    public function getEditParam($values)
    {
		
        $arr = [];
        $valueArr = explode('||', $values);
		
        foreach ($valueArr as $one) {
            if ($one) {
                list($formula, $weight_min, $weight_max) = explode('##', $one);
				//if ($formula && $weight_min && $weight_max ) {
                    array_push($arr, [
                        'formula' => $formula,
                        'weight' => [
							'min'=>$weight_min,
							'max'=>$weight_max,
							]
                    ]);
                //}
            }
            
        }
        
        return $arr;
    }
    public function getTotalEditParam($values)
    {
		
        $arr = [];
        $valueArr = explode('||', $values);
		
        foreach ($valueArr as $one) {
            if ($one) {
                list($formula, $weight_min, $weight_max) = explode('##', $one);
                //echo "$formula && $weight_min && $weight_max ";
				//if ($formula && $weight_min && $weight_max ) {
					
                    array_push($arr, [
                        'formula' => $formula,
                        'total' => [
							'min'=>$weight_min,
							'max'=>$weight_max,
							]
                    ]);
               // }
            }
            
        }
        
        return $arr;
    }
    public function getArrParam(){
		/*
		array(4) { ["_id"]=> string(0) "" ["values"]=> string(6) "2##3##" ["value"]=> array(3) { ["default_shipping"]=> string(1) "1" ["label"]=> array(9) { ["label_en"]=> string(4) "test" ["label_zh"]=> string(0) "" ["label_fr"]=> string(0) "" ["label_de"]=> string(0) "" ["label_es"]=> string(0) "" ["label_pt"]=> string(0) "" ["label_ru"]=> string(0) "" ["label_it"]=> string(0) "" ["label_tw"]=> string(0) "" } ["name"]=> array(9) { ["name_en"]=> string(4) "test" ["name_zh"]=> string(0) "" ["name_fr"]=> string(0) "" ["name_de"]=> string(0) "" ["name_es"]=> string(0) "" ["name_pt"]=> string(0) "" ["name_ru"]=> string(0) "" ["name_it"]=> string(0) "" ["name_tw"]=> string(0) "" } } ["key"]=> string(13) "shipping_info" }
		*/
        $request_param = CRequest::param();
        $this->_param = $request_param[$this->_editFormData];
        
        $param = [];
        $attrVals = [];
        foreach($this->_param as $attr => $val) {
            if (in_array($attr, $this->_attrArr)) {
                $attrVals[$attr] = $val;
            } else {
                $param[$attr] = $val;
            }
        }
        
        $param['value'] = $attrVals;
        $param['value']['values']=[];
        if(isset($param['values'])&&!empty($param['values'])){
        	array_push($param['value']['values'],$this->getEditParam($param['values']));
        }
        if(isset($param['total_values'])&&!empty($param['total_values'])){
        	array_push($param['value']['values'],$this->getTotalEditParam($param['total_values']));
        }
        
		//$param['value']['values']=(isset()&&!empty())?$this->getEditParam($param['values']):;
        $param['key'] = $this->_key;
        
        return $param;
    }
    
    /**
     * save article data,  get rewrite url and save to article url key.
     */
    public function save()
    {
        /*
         * if attribute is date or date time , db storage format is int ,by frontend pass param is int ,
         * you must convert string datetime to time , use strtotime function.
         */
        // 设置 bdmin_user_id 为 当前的user_id
        $this->_service->saveConfig($this->getArrParam());
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
    
    
    
    public function getVal($name, $column){
        if (is_object($this->_one) && property_exists($this->_one, $name) && $this->_one[$name]) {
            
            return $this->_one[$name];
        }
        $content = $this->_one['value'];
        if (is_array($content) && !empty($content) && isset($content[$name])) {
            
            return $content[$name];
        }
        
        return '';
    }
}