<?php

namespace appfront\local\local_modules\Catalog\block\category;

use fecshop\interfaces\block\BlockCache;
use Yii;

class Menu implements BlockCache
{
    public function getLastData()
    {
		Yii::$service->page->menu->displayHome=false;
        $categoryArr = Yii::$service->page->menu->getMenuData();
        
        return [
            'categoryArr' => $categoryArr,
        ];
    }

    public function getCacheKey()
    {
        $lang           = Yii::$service->store->currentLangCode;
        $appName        = Yii::$service->helper->getAppName();
        $cacheKeyName   = 'menu';
        $currentStore   = Yii::$service->store->currentStore;
        return self::BLOCK_CACHE_PREFIX.'_'.$currentStore.'_'.$lang.'_'.$appName.'_'.$cacheKeyName;
    }
}
