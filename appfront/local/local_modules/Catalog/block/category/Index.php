<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace appfront\local\local_modules\Catalog\block\category;

use Yii;
use yii\base\InvalidValueException;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Index extends \yii\base\BaseObject
{
    // ��ǰ�������
    protected $_category;
    // ҳ�����
    protected $_title;
    // ��ǰ����������Ӧ��ֵ
    protected $_primaryVal;
    // Ĭ�ϵ������ֶ�
    protected $_defautOrder;
    // Ĭ�ϵ������������ǽ���
    protected $_defautOrderDirection = SORT_DESC;
    // ��ǰ��where����
    protected $_where;
    // url�Ĳ�����ÿҳ��Ʒ����
    protected $_numPerPage = 'numPerPage';
    // url�Ĳ�����������
    protected $_direction = 'dir';
    // url�Ĳ����������ֶ�
    protected $_sort = 'sort';
    // url�Ĳ�����ҳ��
    protected $_page = 'p';
    // url�Ĳ������۸�
    protected $_filterPrice = 'price';
    // url�Ĳ������۸�
    protected $_filterPriceAttr = 'price';
    // ��Ʒ����
    protected $_productCount;
    protected $_filter_attr;
    protected $_numPerPageVal;
    
    public function init()
    {
        parent::init();
        $this->getQuerySort();
    }
    protected $_sort_items;
    public function getQuerySort()
    {
        if (!$this->_sort_items) {
            $category_sorts = Yii::$app->store->get('category_sort');
            if (is_array($category_sorts)) {
                foreach ($category_sorts as $one) {
                    $sort_key = $one['sort_key'];
                    $sort_label = $one['sort_label'];
                    $sort_db_columns = $one['sort_db_columns'];
                    $sort_direction = $one['sort_direction'];
                    $this->_sort_items[$sort_key] = [
                        'label'        => $sort_label,
                        'db_columns'   => $sort_db_columns,
                        'direction'    => $sort_direction,
                    ];
                }
            }
        }
        
    }
    
    public function getLastData()
    {
        // ÿҳ��ʾ�Ĳ�Ʒ���������а�ȫ��֤�������������Ԥ�����õ�ֵ�ڣ���ᱨ��
        // ������Ϊ�˷�ֹ���⹥����Ҳ���Ƿ��ͺܶ಻ͬ��ҳ����������ӣ��ƿ����档
        $this->getNumPerPage();
        //echo Yii::$service->page->translate->__('fecshop,{username}', ['username' => 'terry']);
        if(!$this->initCategory()){
            Yii::$service->url->redirect404();
            return;
        }
        
        // change current layout File.
        //Yii::$service->page->theme->layoutFile = 'home.php';

        $productCollInfo = $this->getCategoryProductColl();
        $products = $productCollInfo['coll'];
        $this->_productCount = $productCollInfo['count'];
		$productPrimaryKey = Yii::$service->product->getPrimaryKey();
		$array_ids=array_column($products,'_'.$productPrimaryKey);
		$qtys  = Yii::$service->product->stock->getQtyByProductIds($array_ids);
		
        //echo $this->_productCount;
        return [
			'qtys'					=> $qtys,
            'title'                 => $this->_title,
            'name'                  => Yii::$service->store->getStoreAttrVal($this->_category['name'], 'name'),
            'name_default_lang'     => Yii::$service->fecshoplang->getDefaultLangAttrVal($this->_category['name'], 'name'),
            'image'                 => $this->_category['image'] ? Yii::$service->category->image->getUrl($this->_category['image']) : '',
            'description'           => Yii::$service->store->getStoreAttrVal($this->_category['description'], 'description'),
            'products'              => $products,
            'query_item'            => $this->getQueryItem(),
            'product_page'          => $this->getProductPage(),
            'refine_by_info'        => $this->getRefineByInfo(),
            'filter_info'           => $this->getFilterInfo(),
            'filter_price'          => $this->getFilterPrice(),
            'filter_category'       => $this->getFilterCategoryHtml(),
            //'content' => Yii::$service->store->getStoreAttrVal($this->_category['content'],'content'),
            //'created_at' => $this->_category['created_at'],
        ];
    }

    /**
     * �õ��ӷ��࣬����ӷ��಻���ڣ��򷵻�ͬ�����ࡣ
     */
    protected function getFilterCategory()
    {
        $category_id = $this->_primaryVal;
        $parent_id = $this->_category['parent_id'];
        $filter_category = Yii::$service->category->getFilterCategory($category_id, $parent_id);

        return $filter_category;
    }
    /**
     * @param $filter_category | Array
     * ͨ���ݹ�ķ�ʽ���õ������Լ��ӷ����html��
     */
    protected function getFilterCategoryHtml($filter_category = '')
    {
        $str = '';
        if (!$filter_category) {
            $filter_category = $this->getFilterCategory();
        }
        if (is_array($filter_category) && !empty($filter_category)) {
            $str .= '<ul>';
            foreach ($filter_category as $cate) {
                $name = Yii::$service->store->getStoreAttrVal($cate['name'], 'name');
                $url = Yii::$service->url->getUrl($cate['url_key']);
                $current = '';
                if (isset($cate['current']) && $cate['current']) {
                    $current = 'class="current"';
                }
                $str .= '<li '.$current.'><a href="'.$url.'">'.$name.'</a>';
                if (isset($cate['child']) && is_array($cate['child']) && !empty($cate['child'])) {
                    $str .= $this->getFilterCategoryHtml($cate['child']);
                }
                $str .= '</li>';
            }
            $str .= '</ul>';
        }
        //exit;
        return $str;
    }
    /**
     * �õ���Ʒҳ���toolbar����
     * Ҳ���Ƿ���ҳ��ķ�ҳ���������֡�
     */
    protected function getProductPage()
    {
        $productNumPerPage = $this->getNumPerPage();
        $productCount = $this->_productCount;
        $pageNum = $this->getPageNum();
        $config = [
            'class'        => 'fecshop\app\appfront\widgets\Page',
            'view'        => 'widgets/page.php',
            'pageNum'        => $pageNum,
            'numPerPage'    => $productNumPerPage,
            'countTotal'    => $productCount,
            'page'            => $this->_page,
        ];

        return Yii::$service->page->widget->renderContent('category_product_page', $config);
    }
    /**
     * ����ҳ��toolbar���֣�
     * ��Ʒ���򣬲�Ʒÿҳ�Ĳ�Ʒ�����ȣ�Ϊ��Щ�����ṩ���ݡ�
     */
    protected function getQueryItem()
    {
        //$category_query  = Yii::$app->controller->module->params['category_query'];
        //$numPerPage      = $category_query['numPerPage'];
        
        $appName = Yii::$service->helper->getAppName();
        $numPerPage = Yii::$app->store->get($appName.'_catalog','category_query_numPerPage');
        $numPerPage = explode(',', $numPerPage);
        $sort                   = $this->_sort_items;
        $frontNumPerPage = [];
        if (is_array($numPerPage) && !empty($numPerPage)) {
            $attrUrlStr = $this->_numPerPage;
            foreach ($numPerPage as $np) {
                $urlInfo = Yii::$service->url->category->getFilterChooseAttrUrl($attrUrlStr, $np, $this->_page);
                //var_dump($url);
                //exit;
                $frontNumPerPage[] = [
                    'value'    => $np,
                    'url'        => $urlInfo['url'],
                    'selected'    => $urlInfo['selected'],
                ];
            }
        }
        $frontSort = [];
        $hasSelect = false;
        if (is_array($sort) && !empty($sort)) {
            $attrUrlStr = $this->_sort;
            $dirUrlStr  = $this->_direction;
            foreach ($sort as $np=>$info) {
                $label      = $info['label'];
                $direction  = $info['direction'];
                $arr['sort']= [
                    'key' => $attrUrlStr,
                    'val' => $np,
                ];
                $arr['dir'] = [
                    'key' => $dirUrlStr,
                    'val' => $direction,
                ];
                $urlInfo = Yii::$service->url->category->getFilterSortAttrUrl($arr, $this->_page);
                if ($urlInfo['selected']) {
                    $hasSelect = true;
                }
                $frontSort[] = [
                    'label'     => $label,
                    'value'     => $np,
                    'url'       => $urlInfo['url'],
                    'selected'  => $urlInfo['selected'],
                ];
            }
        }
        if (!$hasSelect ){ // Ĭ�ϵ�һ��Ϊѡ�е�����ʽ
            $frontSort[0]['selected'] = true;
        }
        $data = [
            'frontNumPerPage' => $frontNumPerPage,
            'frontSort'       => $frontSort,
        ];

        return $data;
    }
    /**
     * @return Array
     * �õ���ǰ���࣬�������ڹ��˵��������飬�������ּ���ó�
     * 1.ȫ��Ĭ�����Թ��ˣ�catalog module �����ļ������� category_filter_attr����
     * 2.��ǰ�������Թ��ˣ�Ҳ���Ƿ����� filter_product_attr_selected �ֶ�
     * 3.��ǰ����ȥ�������Թ��ˣ�Ҳ���Ƿ����� filter_product_attr_unselected
     * ���ճ���һ����ǰ���࣬���ڹ��˵��������顣
     */
    protected function getFilterAttr()
    {
        if (!$this->_filter_attr) {
            $appName = Yii::$service->helper->getAppName();
            $filter_default = Yii::$app->store->get($appName.'_catalog','category_filter_attr');
            $filter_default = explode(',',$filter_default);
            //$filter_default = Yii::$app->controller->module->params['category_filter_attr'];
            $current_fileter_select = $this->_category['filter_product_attr_selected'];
            $current_fileter_unselect = $this->_category['filter_product_attr_unselected'];
            $current_fileter_select_arr = $this->getFilterArr($current_fileter_select);
            $current_fileter_unselect_arr = $this->getFilterArr($current_fileter_unselect);
            $filter_attrs = array_merge($filter_default, $current_fileter_select_arr);
            $filter_attrs = array_diff($filter_attrs, $current_fileter_unselect_arr);
            $this->_filter_attr = $filter_attrs;
        }

        return $this->_filter_attr;
    }
    /**
     * �õ���������������Թ��˵Ĳ�������
     */
    protected function getRefineByInfo()
    {
        $get_arr = Yii::$app->request->get();
        //var_dump($get_arr);
        if (is_array($get_arr) && !empty($get_arr)) {
            $refineInfo = [];
            $filter_attrs = $this->getFilterAttr();
            $filter_attrs[] = 'price';
            //var_dump($filter_attrs);
            $currentUrl = Yii::$service->url->getCurrentUrl();
            foreach ($get_arr as $k=>$v) {
                $attr = Yii::$service->url->category->urlStrConvertAttrVal($k);
                //echo $attr;
                if (in_array($attr, $filter_attrs)) {
                    if ($attr == 'price') {
                        $refine_attr_str = $this->getFormatFilterPrice($v);
                        //$refine_attr_str = Yii::$service->url->category->urlStrConvertAttrVal($v);
                    } else {
                        $refine_attr_str = Yii::$service->url->category->urlStrConvertAttrVal($v);
                    }
                    $removeUrlParamStr = $k.'='.$v;
                    $refine_attr_url = Yii::$service->url->removeUrlParamVal($currentUrl, $removeUrlParamStr);
                    $refineInfo[] = [
                        'name' =>  $refine_attr_str,
                        'url'  =>  $refine_attr_url,
                        'attr' => $attr,
                    ];
                }
            }
        }
        if (!empty($refineInfo)) {
            $arr[] = [
                'name'    => 'clear all',
                'url'    => Yii::$service->url->getCurrentUrlNoParam(),
            ];
            $refineInfo = array_merge($arr, $refineInfo);
        }

        return $refineInfo;
    }
    /**
     * �������۸�����������Թ��˲���
     */
    protected function getFilterInfo()
    {
        $filter_info = [];
        $filter_attrs = $this->getFilterAttr();
        foreach ($filter_attrs as $attr) {
            if ($attr != 'price') {
                $filter_info[$attr] = Yii::$service->product->getFrontCategoryFilter($attr, $this->_where);
            }
        }

        return $filter_info;
    }
    /**
     * �����۸���˲���
     */
    protected function getFilterPrice()
    {
        $filter = [];
        //$priceInfo = Yii::$app->controller->module->params['category_query'];
        $appName = Yii::$service->helper->getAppName();
        $category_query_priceRange = Yii::$app->store->get($appName.'_catalog','category_query_priceRange');
        $category_query_priceRange = explode(',',$category_query_priceRange);
        if ( !empty($category_query_priceRange) && is_array($category_query_priceRange)) {
            foreach ($category_query_priceRange as $price_item) {
                $price_item = trim($price_item);
                $info = Yii::$service->url->category->getFilterChooseAttrUrl($this->_filterPrice, $price_item, $this->_page);
                $info['val'] = $this->getFormatFilterPrice($price_item);
                $filter[$this->_filterPrice][] = $info;
            }
        }

        return $filter;
    }
    /**
     * ��ʽ���۸��ʽ�������۸���˲���
     */
    protected function getFormatFilterPrice($price_item)
    {
        list($f_price, $l_price) = explode('-', $price_item);
        $str = '';
        if ($f_price == '0' || $f_price) {
            $f_price = Yii::$service->product->price->formatPrice($f_price);
            $str .= $f_price['symbol'].$f_price['value'].'---';
        }
        if ($l_price) {
            $l_price = Yii::$service->product->price->formatPrice($l_price);
            $str .= $l_price['symbol'].$l_price['value'];
        }

        return $str;
    }
    /**
     * @param $str | String
     * �ַ���ת�������顣
     */
    protected function getFilterArr($str)
    {
        $arr = [];
        if ($str) {
            $str = str_replace('��', ',', $str);
            $str_arr = explode(',', $str);
            foreach ($str_arr as $a) {
                $a = trim($a);
                if ($a) {
                    $arr[] = trim($a);
                }
            }
        }

        return $arr;
    }
    /**
     * �����������������򲿷�
     */
    protected function getOrderBy()
    {
        $primaryKey = Yii::$service->category->getPrimaryKey();
        $sort = Yii::$app->request->get($this->_sort);
        $direction = Yii::$app->request->get($this->_direction);

        $sortConfig = $this->_sort_items;
        if (is_array($sortConfig)) {
            if ($sort && isset($sortConfig[$sort])) {
                $orderInfo = $sortConfig[$sort];
            } else {
                foreach ($sortConfig as $k => $v) {
                    $orderInfo = $v;
                    if (!$direction) {
                        $direction = $v['direction'];
                    }
                    break;
                }
            }
            $db_columns = $orderInfo['db_columns'];
            $storageName = Yii::$service->product->serviceStorageName();
            if ($direction == 'desc') {
                $direction =  $storageName == 'mongodb' ? -1 :  SORT_DESC;
            } else {
                $direction = $storageName == 'mongodb' ? 1 :SORT_ASC;
            }
            
            return [$db_columns => $direction];
        }
        
    }
    /**
     * ����ҳ��Ĳ�Ʒ��ÿҳ��ʾ�Ĳ�Ʒ������
     * ����ǰ�˴��ݵĸ����������ں�̨��֤һ���Ƿ��ǺϷ��ĸ���������������һ�������Ʒ�����б�
     * ������Ϸ������쳣
     * ���������Ϊ�˷�ֹ��ҳ������α������Ĳ�ͬ������url���ƹ����档
     */
    protected function getNumPerPage()
    {
        if (!$this->_numPerPageVal) {
            $numPerPage = Yii::$app->request->get($this->_numPerPage);
            //$category_query_config = Yii::$app->getModule('catalog')->params['category_query'];
            $appName = Yii::$service->helper->getAppName();
            $categoryConfigNumPerPage = Yii::$app->store->get($appName.'_catalog','category_query_numPerPage');
            $category_query_config['numPerPage'] = explode(',',$categoryConfigNumPerPage);
            if (!$numPerPage) {
                if (isset($category_query_config['numPerPage'])) {
                    if (is_array($category_query_config['numPerPage'])) {
                        $this->_numPerPageVal = $category_query_config['numPerPage'][0];
                    }
                }
            } elseif (!$this->_numPerPageVal) {
                if (isset($category_query_config['numPerPage']) && is_array($category_query_config['numPerPage'])) {
                    $numPerPageArr = $category_query_config['numPerPage'];
                    if (in_array((int) $numPerPage, $numPerPageArr)) {
                        $this->_numPerPageVal = $numPerPage;
                    } else {
                        throw new InvalidValueException('Incorrect numPerPage value:'.$numPerPage);
                    }
                }
            }
        }

        return $this->_numPerPageVal;
    }
    /**
     * �õ���ǰ�ڼ�ҳ
     */
    protected function getPageNum()
    {
        $numPerPage = Yii::$app->request->get($this->_page);

        return $numPerPage ? (int) $numPerPage : 1;
    }
    /**
     * �õ���ǰ����Ĳ�Ʒ
     */
    protected function getCategoryProductColl()
    {
        $select = [
            'sku', 'spu', 'name', 'image',
            'price', 'special_price',
            'special_from', 'special_to',
            'url_key', 'score', 'reviw_rate_star_average', 'review_count','is_in_stock'
        ];
        if (is_array($this->_sort_items)) {
            foreach ($this->_sort_items as $sort_item) {
                $select[] = $sort_item['db_columns'];
            }
        }
        $filter = [
            'pageNum'      => $this->getPageNum(),
            'numPerPage'  => $this->getNumPerPage(),
            'orderBy'      => $this->getOrderBy(),
            'where'          => $this->_where,
            'select'      => $select,
        ];
        
        return Yii::$service->category->product->getFrontList($filter);
    }
    /**
     * �õ����ڲ�ѯ��where���顣
     */
    protected function initWhere()
    {
        $filterAttr = $this->getFilterAttr();
        foreach ($filterAttr as $attr) {
            $attrUrlStr = Yii::$service->url->category->attrValConvertUrlStr($attr);
            $val = Yii::$app->request->get($attrUrlStr);
            if ($val) {
                $val = Yii::$service->url->category->urlStrConvertAttrVal($val);
                $where[$attr] = $val;
            }
        }
        $filter_price = Yii::$app->request->get($this->_filterPrice);
        list($f_price, $l_price) = explode('-', $filter_price);
		$discount=100;
		$session = Yii::$app->session;
		if(isset($session['grade']['discount_rate'])){
			$discount=$session['grade']['discount_rate'];
		}
        if ($f_price == '0' || $f_price) {
            $where[$this->_filterPriceAttr]['$gte'] = (float) $f_price*100/$discount;
        }
        if ($l_price) {
            $where[$this->_filterPriceAttr]['$lte'] = (float) $l_price*100/$discount;
        }
        $where['category'] = $this->_primaryVal;
        //var_dump($where);exit;
        return $where;
    }
    /**
     * ���ಿ�ֵĳ�ʼ��
     * ��һЩ���Խ��и�ֵ��
     */
    protected function initCategory()
    {
        $primaryKey = Yii::$service->category->getPrimaryKey();
        $primaryVal = Yii::$app->request->get($primaryKey);
        $this->_primaryVal = $primaryVal;
        $category = Yii::$service->category->getByPrimaryKey($primaryVal);
        if ($category) {
            $enableStatus = Yii::$service->category->getCategoryEnableStatus();
            if ($category['status'] != $enableStatus){
                
                return false;
            }
        } else {
            
            return false;
        }
        $this->_category = $category;
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => Yii::$service->store->getStoreAttrVal($category['meta_keywords'], 'meta_keywords'),
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::$service->store->getStoreAttrVal($category['meta_description'], 'meta_description'),
        ]);
        $this->_title = Yii::$service->store->getStoreAttrVal($category['title'], 'title');
        $name = Yii::$service->store->getStoreAttrVal($category['name'], 'name');
        $this->breadcrumbs($name);
        $this->_title = $this->_title ? $this->_title : $name;
        Yii::$app->view->title = $this->_title;
        $this->_where = $this->initWhere();
        return true;
    }

    // ���м����
    protected function breadcrumbs($name)
    {
        $appName = Yii::$service->helper->getAppName();
        $category_breadcrumbs = Yii::$app->store->get($appName.'_catalog','category_breadcrumbs');
        
        if ($category_breadcrumbs == Yii::$app->store->enable) {
            $parent_info = Yii::$service->category->getAllParentInfo($this->_category['parent_id']);
            if (is_array($parent_info) && !empty($parent_info)) {
                foreach ($parent_info as $info) {
                    $parent_name = Yii::$service->store->getStoreAttrVal($info['name'], 'name');
                    $parent_url = Yii::$service->url->getUrl($info['url_key']);
                    Yii::$service->page->breadcrumbs->addItems(['name' => $parent_name, 'url' => $parent_url]);
                }
            }
            Yii::$service->page->breadcrumbs->addItems(['name' => $name]);
        } else {
            Yii::$service->page->breadcrumbs->active = false;
        }
    }
}
