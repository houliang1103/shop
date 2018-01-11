<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int $goods_id 商品ID
 * @property int $amount
 * @property int $time
 * @property int $user_id 所属用户ID
 */
class Cart extends \yii\db\ActiveRecord
{
   public function behaviors()
   {
       return [
           [
               'class' => TimestampBehavior::className(),
               'attributes' => [
                   # 创建之前
                   self::EVENT_BEFORE_INSERT => ['time'],

               ],
           ]
       ];
   }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'goods_id', 'amount', 'user_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品ID',
            'amount' => 'Amount',
            'time' => 'Time',
            'user_id' => '所属用户ID',
        ];
    }
}
