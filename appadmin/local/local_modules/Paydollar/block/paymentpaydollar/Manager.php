<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appadmin\local\local_modules\Paydollar\block\paymentpaydollar;

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
    public $_key = 'payment_paydollar';
    public $_type;
    protected $_attrArr = [
        'paydollar_account',
        'paydollar_signature',
        'paydollar_env',
		'paydollar_mpsmode',
		'paydollar_paytype',
		'paydollar_oricountry',
		'paydollar_destcountry',
		'paydollar_paymethod',
    ];
    
    public function init()
    {
        
         // 需要配置
        $this->_saveUrl = CUrl::getUrl('paydollar/paymentpaydollar/managersave');
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
        ];
    }
    public function setService()
    {
        $this->_service = Yii::$service->storeBaseConfig;
    }
    public function getEditArr()
    {
        $deleteStatus = Yii::$service->customer->getStatusDeleted();
        $activeStatus = Yii::$service->customer->getStatusActive();
        
        $allLangs = Yii::$service->fecshoplang->getAllLangName();
        $allLangArr = [];
        foreach ($allLangs as $k) {
            $allLangArr[$k] = $k;
        }
        $currencys = Yii::$service->page->currency->getCurrencys();
        $currencyArr = [];
        foreach ($currencys as $code => $info) {
            $currencyArr[$code] = $code;
        }
        
        return [
        
        
            // 需要配置
            
            [
                'label'  => Yii::$service->page->translate->__('Paydollar Env'),
                'name' => 'paydollar_env',
                'display' => [
                    'type' => 'select',
                    'data' => [
                        Yii::$service->payment->env_sanbox =>  Yii::$service->page->translate->__('Sanbox Env'),
                        Yii::$service->payment->env_product =>  Yii::$service->page->translate->__('Product Env'),
                    ],
                ],
                'require' => 1,
            ],
            
            [
                'label'  => Yii::$service->page->translate->__('Paydollar Pay Method'),
                'name' => 'paydollar_paymethod',
                'display' => [
                    'type' => 'select',
                    'data' => [
                        'ALL' =>  Yii::$service->page->translate->__('All the available payment method'),
                        'CC'  =>  Yii::$service->page->translate->__('Credit Card Payment'),
						'VISA'=>  Yii::$service->page->translate->__('Visa Payment'),
						'Master' => Yii::$service->page->translate->__('MasterCard Payment'),
						'JCB' => Yii::$service->page->translate->__('JCB'),
						'AMEX' => Yii::$service->page->translate->__('AMEX'),
						'Diners' => Yii::$service->page->translate->__('Diners'),
						'PPS' => Yii::$service->page->translate->__('PPS'),
						'PAYPAL' => Yii::$service->page->translate->__('PAYPAL'),
						'CHINAPAY' => Yii::$service->page->translate->__('CHINAPAY'),
						'ALIPAY' => Yii::$service->page->translate->__('ALIPAY'),
						'TENPAY' => Yii::$service->page->translate->__('TENPAY'),
						'99BILL' => Yii::$service->page->translate->__('99BILL'),
						'MEPS' => Yii::$service->page->translate->__('MEPS'),
						'SCB' => Yii::$service->page->translate->__('SCB'),
						'BPM' => Yii::$service->page->translate->__('BPM'),
						'KTB' => Yii::$service->page->translate->__('KTB'),
						'UOB' => Yii::$service->page->translate->__('UOB'),
						'KRUNGSRIONLINE' => Yii::$service->page->translate->__('KRUNGSRIONLINE'),
						'TMB' => Yii::$service->page->translate->__('TMB'),
						'IBANKING' => Yii::$service->page->translate->__('IBANKING'),
						'BancNet' => Yii::$service->page->translate->__('BancNet'),
						'GCash' => Yii::$service->page->translate->__('GCash'),
						'SMARTMONEY' => Yii::$service->page->translate->__('SMARTMONEY'),
						'PAYCASH' => Yii::$service->page->translate->__('PAYCASH'),
                    ],
                ],
				'require' => 1,
            ],
            
            [
                'label'  => Yii::$service->page->translate->__('Paydollar Account'),
                'name' => 'paydollar_account',
                'display' => [
                    'type' => 'inputString',
                ],
				'require' => 1,
            ],
            
            [
                'label'  => Yii::$service->page->translate->__('Paydollar Signature'),
                'name' => 'paydollar_signature',
                'display' => [
                    'type' => 'inputString',
                ],
            ],
            
			[
                'label'  => Yii::$service->page->translate->__('Paydollar mpsMode'),
                'name' => 'paydollar_mpsmode',
                'display' => [
                    'type' => 'select',
                    'data' => [
                        'NIL' =>  Yii::$service->page->translate->__('NIL'),
						'SCP' =>  Yii::$service->page->translate->__('SCP'),
						'DCC' =>  Yii::$service->page->translate->__('DCC'),
						'MCP' =>  Yii::$service->page->translate->__('MCP'),
                    ],
                ],
				'require' => 1,
            ],

			[
                'label'  => Yii::$service->page->translate->__('Paydollar Pay Type'),
                'name' => 'paydollar_paytype',
                'display' => [
                    'type' => 'select',
                    'data' => [
                        'N' =>  Yii::$service->page->translate->__('Normal Payment (Sales)'),
                        'H' =>  Yii::$service->page->translate->__('Hold Payment (Authorize only)'),
                    ],
                ],
				'require' => 1,
            ],
            
			[
                'label'  => Yii::$service->page->translate->__('Paydollar oricountry'),
                'name' => 'paydollar_oricountry',
                'display' => [
                    'type' => 'select',
                    'data' => [
                        344 =>  Yii::$service->page->translate->__('HK'),
                        840 =>  Yii::$service->page->translate->__('US'),
                    ],
                ],
            ],
			
			[
                'label'  => Yii::$service->page->translate->__('Paydollar destcountry'),
                'name' => 'paydollar_destcountry',
                'display' => [
                    'type' => 'select',
                    'data' => [
                        344 =>  Yii::$service->page->translate->__('HK'),
                        840 =>  Yii::$service->page->translate->__('US'),
                    ],
                ],
            ],
			
			

        ];
    }
    
    public function getArrParam(){
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