<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appadmin\local\local_modules\Catalog\block\productupload;

use fecshop\app\appadmin\interfaces\base\AppadminbaseBlockInterface;
use fecshop\app\appadmin\modules\AppadminbaseBlock;
use Yii;

/**
 * block cms\article.
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Manager 
{
    
    public $_fileFullDir;
    /**
     * init param function ,execute in construct.
     */
    public function init()
    {
        /*
         * service component, data provider
         */
        //$this->_service = Yii::$service->product->favorite;
        parent::init();
    }

    public function getLastData()
    {
        return [
        ];
    }
    
    protected function genTier($tiers){
    	
    	$tiers=explode("\n",$tiers);
    	
    	$demo=array();
    	$i=0;
    	if($tiers){
	    	foreach ($tiers as $key => $val){
	    		$tiers[$key] = explode(",",$val);
	    		foreach ($tiers[$key] as $key1 => $val1){
	    			$tiers[$key][$key1] = explode(":",$val1);
	    			$demo[$i][$tiers[$key][$key1][0]]=trim($tiers[$key][$key1][1]);
	    		}
	    		$i++;
	    	}
    	}
    	return json_encode($demo);
    }
    protected function genAttr($attrs){
    	$attrs=explode("\n",$attrs);
    	
    	$demo=array();
    	if($attrs){
	    	foreach ($attrs as $key => $val){
	    		$attrs[$key]=explode(":",$val);
	    		$demo[$attrs[$key][0]]=trim($attrs[$key][1]);
	    	}
    	}
    	return json_encode($demo);
    }
    public function uploadProduct()
    {
    	
        $fileFullDir = Yii::getAlias('@appadmin/runtime/upload/');
        if ($this->saveUploadExcelFile($fileFullDir)) {
            //echo $this->_fileFullDir;
            
            $arr = \fec\helpers\CExcel::getExcelContent($this->_fileFullDir);
            
            $i = 0;
            if (is_array($arr) && !empty($arr)) {
                foreach ($arr as $one) {
                	
                    $i++;
                    if ($i > 0) {
                    	$one['O']=$this->genTier($one['O']);
                    	$one['X']=$this->genAttr($one['X']);
                    	$one['H']=$one['H']?$one['H']:'/'.$one['D'];
                    	
                        $saveStatus = $this->saveProduct($one);
                        if (!$saveStatus) {
                        	$errorMessage = Yii::$service->helper->errors->get(',');
                            echo  json_encode([
                                'statusCode' => '300',
                                'message'    => $one['D'].' upload fail.'.$errorMessage,
                            ]);
                            exit;
                        }
                    }
                }
            }
            echo  json_encode([
                'statusCode' => '200',
                'message'    => Yii::$service->page->translate->__('Save Success'),
            ]);
            exit;
        }
        
        
    }
    
    public function saveProduct($one)
    {
        // 从excel中获取数据。
        $product_name = $one['A'];
        $language_code = $one['B'];
        $spu = $one['C'];
        $sku = $one['D'];
        $category = $one['E'];
        $weight = $one['F'];
        $status = $one['G'];
        $url_key = $one['H'];
        $qty = $one['I'];
        $is_in_stock = $one['J'];
        $remark = $one['K'];
        $cost_price = $one['L'];
        $price = $one['M'];
        $special_price = $one['N'];
        $tier_price = $one['O'];
        $meta_title = $one['P'];
        $meta_keywords = $one['Q'];
        $meta_description = $one['R'];
        
        $short_description = $one['S'];
        $description = $one['T'];
        $main_image = $one['U'];
        $gallery_image = $one['V'];
        $group_attr_name = $one['W'];
        $group_attrs = $one['X'];
        $unit = $one['Y']?array(array('unit_code'=>$one['Y'],'unit_rate'=>1,'unit_base'=>1)):'';
        $brand = $one['Z'];
        $supplier = $one['AA'];
		$sap_unit = $one['AB'];
        
        $nameLang = Yii::$service->fecshoplang->getLangAttrName('name',$language_code);
        $titleLang = Yii::$service->fecshoplang->getLangAttrName('meta_title',$language_code);
        $metaKeywordsLang = Yii::$service->fecshoplang->getLangAttrName('meta_keywords',$language_code);
        $metaDescriptionLang = Yii::$service->fecshoplang->getLangAttrName('meta_description',$language_code);
        $shortDescriptionLang = Yii::$service->fecshoplang->getLangAttrName('short_description',$language_code);
        $descriptionLang = Yii::$service->fecshoplang->getLangAttrName('description',$language_code);
        
        $productMode = Yii::$service->product->getBySku($sku);
        $productPrimaryKey = Yii::$service->product->getPrimaryKey();
        $product_id = '';
        if ($productMode && isset($productMode['sku']) && $productMode['sku']) {
            $product_id = $productMode[$productPrimaryKey];
        }
        
        $productArr['name'][$nameLang] = $product_name;
        $productArr['spu'] = $spu;
        $productArr['sku'] = $sku;
        $productArr['category'] = explode(',',trim($category));
        $productArr['weight'] = (float)$weight;
        $productArr['status'] = (int)$status;
        $productArr['url_key'] = $url_key;
        $productArr['qty'] = (int)$qty;
        $productArr['is_in_stock'] = (int)$is_in_stock;
        $productArr['remark'] = $remark;
        $productArr['cost_price'] = (float)$cost_price;
        $productArr['price'] =  (float)$price;
        $productArr['special_price'] =  (float)$special_price;
        $productArr['tier_price'] = json_decode($tier_price,true);
        $productArr['meta_title'][$titleLang] = $meta_title;
        $productArr['meta_keywords'][$metaKeywordsLang] = $meta_keywords;
        $productArr['meta_description'][$metaDescriptionLang] = $meta_description;
        $productArr['short_description'][$shortDescriptionLang] = $short_description;
        $productArr['description'][$descriptionLang] = $description;
        $productArr['unit']=$unit?serialize($unit):'';
		$productArr['sap_unit']=$sap_unit;
        
        
        $productArr['image']['main'] = [
            'image' => '/'.$main_image,
            'label' => '',
            'sort_order' => '',
            'is_thumbnails' => '1',
            'is_detail' => '1',
        ];
        if ($gallery_image) {
            $gallery_image_arr = explode(',', $gallery_image);
            if (is_array($gallery_image_arr)) {
                foreach ($gallery_image_arr as $img) {
                    $productArr['image']['gallery'][] = [
                        'image' => '/'.$img,
                        'label' => '',
                        'sort_order' => '',
                        'is_thumbnails' => '1',
                        'is_detail' => '1',
                    ];
                }
            }
        }
        
        $productArr['attr_group'] = $group_attr_name;
        
        if ($group_attrs) {
            $group_attr_info = json_decode($group_attrs, true);
            if (is_array($group_attr_info)) {
                foreach ($group_attr_info as $key => $v) {
                    $productArr[$key] = $v;
                }
            }
        }
        $productArr['brand']=$brand;
        $productArr['supplier']=$supplier;
        
        return Yii::$service->product->excelSave($productArr);
    }
    
    # 1.保存前台上传的文件。
	public function saveUploadExcelFile($fileFullDir){
        
        $name = $_FILES["file"]["name"];
        $fileFullDir .= 'product_'.time().'_'.rand(1000,9999);
        if(strstr($name,'.xlsx')){
            $fileFullDir .='.xlsx';
        } else if (strstr($name,'.xls')){
            $fileFullDir .='.xls';
        }  
        $this->_fileFullDir  = $fileFullDir;    
        
        $result = @move_uploaded_file($_FILES["file"]["tmp_name"],$fileFullDir);
        
		return $result;
	}
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
