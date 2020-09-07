<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Catalog\controllers;

use fecshop\app\appfront\modules\AppfrontController;
use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class ProductsimpleController extends AppfrontController
{
    public function init()
    {
        parent::init();
        Yii::$service->page->theme->layoutFile = 'productsimple_view.php';
    }
	
	
    // 产品详细页面
    public function actionIndex()
    {
        $data = $this->getBlock()->getLastData();
        
        if(is_array($data)){
            return $this->render($this->action->id, $data);
        }
    }
    /**
     * Yii2 behaviors 可以参看地址：http://www.yiichina.com/doc/guide/2.0/concept-behaviors
     * 这里的行为的作用为添加page cache（整页缓存）。
     */
    public function behaviors()
    {
        if (Yii::$service->store->isAppServerMobile()) {
            $primaryKey = Yii::$service->product->getPrimaryKey();
            $primaryVal = Yii::$app->request->get($primaryKey);
            $urlPath = 'catalog/product/'.$primaryVal;
            Yii::$service->store->redirectAppServerMobile($urlPath);
        }
        $behaviors = parent::behaviors();
        $primaryKey = Yii::$service->product->getPrimaryKey();
        $product_id = Yii::$app->request->get($primaryKey);
        $cacheName = 'product';
        if (Yii::$service->cache->isEnable($cacheName)) {
            $timeout = Yii::$service->cache->timeout($cacheName);
            $disableUrlParam = Yii::$service->cache->disableUrlParam($cacheName);
            $cacheUrlParam = Yii::$service->cache->cacheUrlParam($cacheName);
            $get_str = '';
            $get = Yii::$app->request->get();
            // 存在无缓存参数，则关闭缓存
            if (isset($get[$disableUrlParam])) {
                $behaviors[] =  [
                    'enabled' => false,
                    'class' => 'yii\filters\PageCache',
                    'only' => ['index'],
                ];
                
                return $behaviors;
            }
            if (is_array($get) && !empty($get) && is_array($cacheUrlParam)) {
                foreach ($get as $k=>$v) {
                    if (in_array($k, $cacheUrlParam)) {
                        if ($k != 'p' && $v != 1) {
                            $get_str .= $k.'_'.$v.'_';
                        }
                    }
                }
            }
            $store = Yii::$service->store->currentStore;
            $currency = Yii::$service->page->currency->getCurrentCurrency();

            $behaviors[] =  [
                'enabled' => true,
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => $timeout,
                'variations' => [
                    $store, $currency, $get_str, $product_id,
                ],
                //'dependency' => [
                //	'class' => 'yii\caching\DbDependency',
                //	'sql' => 'SELECT COUNT(*) FROM post',
                //],
            ];
			$behaviors['rateLimiter'] = [  
				'class' => RateLimiter::className(),  
				'enableRateLimitHeaders' => true,  
			];  
        }

        return $behaviors;
    }

    // ajax 得到产品加入购物车的价格。
    public function actionGetcoprice()
    {
        $custom_option_sku = Yii::$app->request->get('custom_option_sku');
        $product_id = Yii::$app->request->get('product_id');
        $qty = Yii::$app->request->get('qty');
        $cart_price = 0;
        $custom_option_price = 0;
        $product = Yii::$service->product->getByPrimaryKey($product_id);
        $cart_price = Yii::$service->product->price->getCartPriceByProductId($product_id, $qty, $custom_option_sku);
        if (!$cart_price) {
            return;
        }
        $price_info = [
            'price' => $cart_price,
        ];

        $priceView = [
            'view'    => 'catalog/product/index/price.php',
        ];
        $priceParam = [
            'price_info' => $price_info,
        ];

        echo json_encode([
            'price' =>Yii::$service->page->widget->render($priceView, $priceParam),
        ]);
        exit;
    }
    
    public function actionImage(){
        $sku = Yii::$app->request->get('sku');
        if ($sku) {
            $product = Yii::$service->product->getBySku($sku);
            if (isset($product['image']['main']['image'])) {
                $main_img = $product['image']['main']['image'];
                $img_type = substr($main_img, strpos($main_img,'.') + 1);
                $imgDir = Yii::$service->product->image->getResizeDir($main_img, [230, 230]);
                if (file_exists($imgDir)) {
                    header('content-type: image/'.$img_type);
                    echo file_get_contents($imgDir);
                }
            }
        }
        
    }
    
    
    // 增加评论
    public function actionReviewadd()
    {
    	
        //$reviewParam = Yii::$app->getModule('catalog')->params['review'];
        $appName = Yii::$service->helper->getAppName();
        $addReviewOnlyLogin = Yii::$app->store->get($appName.'_catalog','review_addReviewOnlyLogin');
        //$addReviewOnlyLogin = ($addReviewOnlyLogin ==  Yii::$app->store->enable)  ? true : false;
        if ($addReviewOnlyLogin ==  Yii::$app->store->enable && Yii::$app->user->isGuest) {
            $currentUrl = Yii::$service->url->getCurrentUrl();
            Yii::$service->customer->setLoginSuccessRedirectUrl($currentUrl);

            // 如果评论产品必须登录用户，则跳转到用户登录页面
            return Yii::$service->url->redirectByUrlKey('customer/account/login');
        }
        $editForm = Yii::$app->request->post('editForm');
        $editForm = Yii::$service->helper->htmlEncode($editForm);
        
        if (!empty($editForm) && is_array($editForm)) {
        	
            $saveStatus = $this->getBlock()->saveReview($editForm);
            if ($saveStatus) {
                $spu = Yii::$app->request->get('spu');
                $_id = Yii::$app->request->get('_id');
                $spu = Yii::$service->helper->htmlEncode($spu);
                $_id = Yii::$service->helper->htmlEncode($_id);
                if ($spu && $_id) {
                    $url = Yii::$service->url->getUrl('catalog/reviewproduct/lists', ['spu' => $spu, '_id'=>$_id]);
                    return $this->redirect($url);
                    
                }
            }
        }
        
        $data = $this->getBlock()->getLastData($editForm);
		
        return $this->render($this->action->id, $data);
    }

    public function actionReviewlists()
    {
        if (Yii::$service->store->isAppServerMobile()) {
            $product_id = Yii::$app->request->get('_id');
            $urlPath = 'product/review/lists/'.$product_id;
            Yii::$service->store->redirectAppServerMobile($urlPath);
        }
        $data = $this->getBlock()->getLastData($editForm);

        return $this->render($this->action->id, $data);
    }
    
    
}
