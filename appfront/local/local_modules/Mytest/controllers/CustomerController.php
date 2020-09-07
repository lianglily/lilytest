<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Mytest\controllers;

use fecshop\app\appfront\modules\AppfrontController;
use Yii;
use yii\web\Response;
use fecelastic\models\elasticSearch\Product;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class CustomerController extends AppfrontController
{
	public $enableCsrfValidation = false;

    //查询
    public function actionTest(){
		$lang = Yii::$service->store->currentLangCode;
        Product::initLang($lang);
		Product::createIndex();
		die();
        $keyword = "java2";
        $res = Es::find()->query([
            "term" => ['title'=>'php自学'],
            //"multi_match" => [
                //"query" => $keyword,
               // "fields" => ["title"] //检索属性
           //],
        ])->asArray()->all();

        echo '<pre>';
        print_r($res);
        exit;

    }

    //创建 或更新
    public function actionAdd(){
        $ESArray = [
            'Es' => [
                'productid' => '4',
                'title' => 'php2',
                'price' => '22'
            ]
        ];

        $es = new Es();
        if(!$es->saveRecord($ESArray)){
            throw new \Exception("操作失败");
        }

        echo "操作成功";

    }

    //删除
    public function actionDelete($id){

        $es = new Es();
        if(!$es->deleteRecord($id)){
            throw new \Exception("删除失败");
        }
        echo "操作成功";

    }
    
}