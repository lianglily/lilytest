<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace common\models;

use yii\db\ActiveRecord;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class ReturnItem extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%order_product_return}}';
    }
    
    public function rules()
    {
        $rules = [
            
            ['order_id', 'filter', 'filter' => 'trim'],
            ['order_id', 'required'],
            
            ['product_id', 'filter', 'filter' => 'trim'],
            ['product_id', 'required'],
            
            ['type', 'filter', 'filter' => 'trim'],
            ['type', 'required'],
            
            ['qty', 'filter', 'filter' => 'trim'],
            ['qty', 'required'],
            
            
        ];

        return $rules;
    }
    
    
}
