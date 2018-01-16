<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string $name 收货人姓名
 * @property string $tel 收货人电话
 * @property string $province 省份
 * @property string $city 城市
 * @property string $area 地区
 * @property string $address 详细地址
 * @property int $user_id 用户ID
 * @property int $goods_id 商品ID
 * @property string $price 总价
 * @property int $status 0: 待支付  1：已支付 2：已发货 3：已收货
 * @property int $create_time 创建时间
 * @property int $update_time 修改时间
 * @property string $sn 订单号
 * @property string $send_type 送货方式
 * @property string $pay_type 支付方式
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
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
            'name' => '收货人姓名',
            'tel' => '收货人电话',
            'province' => '省份',
            'city' => '城市',
            'area' => '地区',
            'address' => '详细地址',
            'user_id' => '用户ID',
            'goods_id' => '商品ID',
            'price' => '总价',
            'status' => '0: 待支付  1：已支付 2：已发货 3：已收货',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'sn' => '订单号',
            'send_type' => '送货方式',
            'pay_type' => '支付方式',
        ];
    }
}
