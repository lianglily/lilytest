<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Catalog\block\favoriteproduct;

use Yii;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Add extends \yii\base\BaseObject
{
    /**
     * 用户添加收藏产品
     */
    public function getLastData()
    {
        $product_id = Yii::$app->request->post('product_id');
        $status = Yii::$app->request->post('status',1);
        //没有登录的用户跳转到登录页面
        if (Yii::$app->user->isGuest) {
            $product = Yii::$service->product->getByPrimaryKey($product_id);
            $url = Yii::$service->url->getUrl($product['url_key']);
            Yii::$service->customer->setLoginSuccessRedirectUrl($url);
            echo json_encode([
				'status' => 'login',
				'content'=> Yii::$service->page->translate->__($errors),
				//'items_count' => Yii::$service->cart->quote->getCartItemCount(),
			]);
			exit;
            return Yii::$service->url->redirectByUrlKey('customer/account/login');
        }

        $identity = Yii::$app->user->identity;
        $user_id = $identity->id;
		if($status){
			$addStatus = Yii::$service->product->favorite->add($product_id, $user_id);
			if (!$addStatus) {
				//Yii::$service->page->message->addByHelperErrors();
				echo json_encode([
					'status' => 'fail',
					'content'=> Yii::$service->page->translate->__($errors),
					//'items_count' => Yii::$service->cart->quote->getCartItemCount(),
				]);
				exit;
			}else{
				echo json_encode([
					'status' => 'success',
					'items_count' => Yii::$service->cart->quote->getCartItemCount(),
				]);
				exit;
			}
		}else{
			$removeStatus = Yii::$service->product->favorite->removeByProductIdAndUserId($product_id, $user_id);
			if (!$removeStatus) {
				//Yii::$service->page->message->addByHelperErrors();
				echo json_encode([
					'status' => 'fail',
					'content'=> Yii::$service->page->translate->__($errors),
					//'items_count' => Yii::$service->cart->quote->getCartItemCount(),
				]);
				exit;
			}else{
				echo json_encode([
					'status' => 'success',
					'items_count' => Yii::$service->cart->quote->getCartItemCount(),
				]);
				exit;
			}
		}
        //$favoriteParam = Yii::$app->getModule('catalog')->params['favorite'];
        $appName = Yii::$service->helper->getAppName();
        $category_breadcrumbs = Yii::$app->store->get($appName.'_catalog','favorite_addSuccessRedirectFavoriteList');
        // 跳转。
        if ($category_breadcrumbs == Yii::$app->store->enable) {
            return Yii::$service->url->redirectByUrlKey('customer/productfavorite');
        } else {
            $product = Yii::$service->product->getByPrimaryKey($product_id);
            $urlKey = $product['url_key'];

            return Yii::$service->url->redirectByUrlKey($urlKey);
        }
    }
}
