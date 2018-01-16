<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "oreder_detail".
 *
 * @property int $id
 * @property int $goods_id 商品ID
 * @property string $logo 商品logo
 * @property string $price 商品单价
 * @property int $amount 商品数量
 * @property string $total_price 订单总价
 * @property int $order_id 订单ID
 * @property string $goods_name 商品名称
 */
class OrederDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oreder_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'logo' => '商品logo',
            'price' => '商品单价',
            'amount' => '商品数量',
            'total_price' => '订单总价',
            'order_id' => '订单ID',
            'goods_name' => '商品名称',
        ];
    }
}
