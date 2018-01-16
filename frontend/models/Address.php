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


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'user_id', 'province', 'city', 'address', 'tel','name'], 'required'],
            [[ 'area', 'status'], 'safe'],
            [['tel'], 'match','pattern' => '/0?(13|14|15|17|18|19)[0-9]{9}/','message' => '手机号码不正确'],
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
