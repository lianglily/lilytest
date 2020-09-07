<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model.
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $password write-only password
 */
class Creditpay extends ActiveRecord
{
    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function refund($ids,$total,$user_id,$order_ids=0)
    {
        //update sales_flat_order set credit_refund_status =1 and credit_refund = grand_total where order_id in ?
		//update customer set credit_used = credit_used - $total where id = ?;
		$connection=Yii::$app->db;   // 假设你已经建立了一个 "db" 连接
		//原始方式：
		$transaction=$connection->beginTransaction();
		 
		try
		{
		 
			$command=$connection->createCommand("update sales_flat_order set credit_refund_status =1 , credit_refund = grand_total where order_id in ($ids) ");
			$command->execute();

			$command=$connection->createCommand('update customer set credit_used = credit_used - :total where id = :id ');
			$command->bindParam(':id', $user_id);
			$command->bindParam(':total', $total);
			
			$command->execute();
		    
		    $command=$connection->createCommand('insert into credit_record (id,customer_id,order_id,type,time,amount) values (null,:user_id,:order_id,2,:time,:amount)');
			$command->bindParam(':user_id', $user_id);
			$command->bindParam(':order_id', implode(",",$order_ids));
			$command->bindParam(':time', time());
			$command->bindParam(':amount', $total);

			$command->execute();
			
			$transaction->commit();
			return true;
		 
		}
		 catch(Exception $e) // 如果有一条查询失败，则会抛出异常
		 {
		 
			$transaction->rollBack();
		 
		}
		return false;
    }
    /**
     * {@inheritdoc}
     */
    public static function cancelRefund($total,$user_id,$order_id=0)
    {
        
		$connection=Yii::$app->db;   // 假设你已经建立了一个 "db" 连接
		//原始方式：
		$transaction=$connection->beginTransaction();
		 
		try
		{

			$command=$connection->createCommand('update customer set credit_used = credit_used + :total where id = :id ');
			$command->bindParam(':id', $user_id);
			$command->bindParam(':total', $total);

			$command->execute();
			
			$command=$connection->createCommand('insert into credit_record (id,customer_id,order_id,type,time,amount) values (null,:user_id,:order_id,1,:time,:amount)');
			$command->bindParam(':user_id', $user_id);
			$command->bindParam(':order_id', $order_id);
			$command->bindParam(':time', time());
			$command->bindParam(':amount', $total);

			$command->execute();
		 
			$transaction->commit();
			return true;
		 
		}
		 catch(Exception $e) // 如果有一条查询失败，则会抛出异常
		 {
		 
			$transaction->rollBack();
		 
		}
		return false;
    }
    
}
