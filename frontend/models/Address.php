<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property int $user_id 所属用户ID
 * @property string $province 省份
 * @property string $city 市区
 * @property string $area 地区
 * @property string $address 详细地址
 * @property string $tel 电话
 * @property int $status 1：默认 2：非默认
 * @property string $name
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'province', 'city', 'address', 'tel'], 'required'],
            [['id', 'user_id', 'status'], 'integer'],
            [['province', 'city', 'name'], 'string', 'max' => 50],
            [['area'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 20],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '所属用户ID',
            'province' => '省份',
            'city' => '市区',
            'area' => '地区',
            'address' => '详细地址',
            'tel' => '电话',
            'status' => '1：默认 2：非默认',
            'name' => 'Name',
        ];
    }
}
