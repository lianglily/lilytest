<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appadmin\local\local_modules\Catalog\block\categoryupload;

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
        parent::init();
    }

    public function getLastData()
    {
        return [
        ];
    }
    
    
    public function uploadCategory()
    {
		
        $fileFullDir = Yii::getAlias('@appadmin/runtime/upload/');
        if ($this->saveUploadExcelFile($fileFullDir)) {
            //echo $this->_fileFullDir;
         
            $arr = \fec\helpers\CExcel::getExcelContent($this->_fileFullDir);
            
			$arr_data=[];
			foreach($arr as $val){
				$arr_data[$val['A']]=$val['B'];
			}
			//var_dump($arr_data);
			unset($arr);
			$_productModelName = '\fecshop\models\mysqldb\Product';
			list($_productModelName, $_productModel) = \Yii::mapGet($_productModelName);
			$data=$_productModel->find()->asArray()->select(['id','sku'])->all();
			//var_dump($data);
			$result=[];
            foreach($data as $key => $val){
				$demo=array();
				$demo['product_id']=$val['id'];
				$demo['qty']=isset($arr_data[$val['sku']])?$arr_data[$val['sku']]:0;
				unset($data[$key]);
				$result[]=$demo;
			}
			//var_dump($result);

			$col = ['product_id','qty'];
			//$sql = Yii::$app->db->createCommand()->batchInsert('product_flat_qty', $col, $result)->getRawSql();
			$transaction=Yii::$app->db->beginTransaction();
			try{
				Yii::$app->db->createCommand()->truncateTable('product_flat_qty')->execute();
				Yii::$app->db->createCommand()->batchInsert('product_flat_qty', $col, $result)->execute();
				$transaction->commit();
				echo  json_encode([
					'statusCode' => '200',
					'message'    => Yii::$service->page->translate->__('Save Success'),
				]);
				exit;
			} catch(Exception $e){
				$transaction->rollBack();
				echo  json_encode([
					'statusCode' => '500',
					'message'    => Yii::$service->page->translate->__('Save Fail'),
				]);
				exit;
			}
			
            /*Yii::$service->store->currentLangCode='tw';
            Yii::$service->page->menu->displayHome=false;
        	$categoryArr = Yii::$service->page->menu->getMenuData();
        	$marster=array();
        	$second=array();
        	$third=array();
        	foreach($categoryArr as $val){
        		$marster_id=$val['_id'];
        		$marster_name=$val['name'];
        		$marster[$marster_name]=$marster_id;
        		if(isset($val['childMenu'])&&!empty($val['childMenu'])){
        			foreach ($val['childMenu'] as $val1){
	        			$second_id=$val1['_id'];
	        			$second_name=$val1['name'];
	        			$second[$marster_id][$second_name]=$second_id;
	        			if(isset($val1['childMenu'])&&!empty($val1['childMenu'])){
		        			foreach ($val1['childMenu'] as $val2){
			        			$third_id=$val2['_id'];
			        			$third_name=$val2['name'];
			        			$third[$marster_id][$second_id][$third_name]=$third_id;
		        			}
		        		}
        			}
        		}
        	}
        	
			 $i = 0;
			 $returnArr=array();
            if (is_array($arr) && !empty($arr)) {
                foreach ($arr as $one) {
                    $i++;
                    if ($i > 1) {
                    	
                    	$demo=explode(',',$one['A']);
                    	$str='';
                    	if(isset($demo[0])){
                    		$marster_id=isset($marster[$demo[0]])?$marster[$demo[0]]:'';
                    		$str.=$marster_id?$marster_id:'';
                    	}
                    	if(isset($demo[1])){
                    		$second_id=isset($second[$marster_id][$demo[1]])?$second[$marster_id][$demo[1]]:'';
                    		$str.=$second_id?','.$second_id:'';
                    	}
                    	if(isset($demo[2])){
                    		$third_id=isset($third[$marster_id][$second_id][$demo[2]])?$third[$marster_id][$second_id][$demo[2]]:'';
                    		$str.=$third_id?','.$third_id:'';
                    	}
                    	$returnArr[]=array($str);
                    }
                }
            }
            
            \fec\helpers\CExcel::downloadExcelFileByArray($returnArr);
            echo  json_encode([
                'statusCode' => '200',
                'message'    => Yii::$service->page->translate->__('Save Success'),
            ]);
            die();
            
            $i = 0;
            if (is_array($arr) && !empty($arr)) {
                foreach ($arr as $one) {
                    $i++;
                    if ($i > 1) {
                        $saveStatus = $this->saveCategory($one);
                        if (!$saveStatus) {
                            $errorMessage = Yii::$service->helper->errors->get(',');
                            echo  json_encode([
                                'statusCode' => '300',
                                'message'    => $errorMessage,
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
            exit;*/
        }
        
    }
    
    public function saveCategory($one)
    {
        // 从excel中获取数据。
        $category_id = $one['A'];
        $parent_id = $one['B'];
        $language_code = $one['C'];
        $category_name = $one['D'];
        $status = $one['E'];
        $menu_show = $one['F'];
        $url_key = $one['G'];
        $description = $one['H'];
        $title = $one['I'];
        $meta_keywords = $one['J'];
        $meta_description = $one['K'];
        $image = $one['L'];
        $thumbnail_image = $one['M'];
        
        
        $nameLang = Yii::$service->fecshoplang->getLangAttrName('name',$language_code);
        $titleLang = Yii::$service->fecshoplang->getLangAttrName('title',$language_code);
        $metaKeywordsLang = Yii::$service->fecshoplang->getLangAttrName('meta_keywords',$language_code);
        $metaDescriptionLang = Yii::$service->fecshoplang->getLangAttrName('meta_description',$language_code);
        $descriptionLang = Yii::$service->fecshoplang->getLangAttrName('description',$language_code);
        
        $categoryPrimaryKey = Yii::$service->category->getPrimaryKey();
        //$categoryMode = Yii::$service->category->getByPrimarykey($category_id);
        //$categoryPrimaryKey = Yii::$service->category->getPrimaryKey();
        //$category_id = '';
        //if ($categoryMode && isset($categoryMode[$categoryPrimaryKey]) && $categoryMode[$categoryPrimaryKey]) {
        //    $category_id = $categoryMode[$categoryPrimaryKey];
        //}
        
        $categoryArr[$categoryPrimaryKey] = $category_id;
        $categoryArr['parent_id'] = $parent_id;
        $categoryArr['name'][$nameLang] = $category_name;
        $categoryArr['status'] = (int)$status;
        $categoryArr['menu_show'] = (int)$menu_show;
        $categoryArr['url_key'] = $url_key;
        $categoryArr['description'][$descriptionLang] = $description;
        $categoryArr['title'][$titleLang] = $title;
        $categoryArr['meta_keywords'][$metaKeywordsLang] = $meta_keywords;
        $categoryArr['meta_description'][$metaDescriptionLang] = $meta_description;
        $categoryArr['image'] = $image;
        $categoryArr['thumbnail_image'] = $thumbnail_image;
        
        return Yii::$service->category->excelSave($categoryArr);
    }
    
    # 1.保存前台上传的文件。
	public function saveUploadExcelFile($fileFullDir){
        
        $name = $_FILES["file"]["name"];
        $fileFullDir .= 'category_'.time().'_'.rand(1000,9999);
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
