<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $logo
 * @property integer $status
 * @property string $intro
 * @property integer $sort
 */
class Brand extends \yii\db\ActiveRecord
{
    public $imgFile;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sort','status'], 'required'],
            [['intro'], 'safe'],
            [['name'], 'unique'],
            //[['imgFile'],'file','extensions' => 'jpg,gif,png','skipOnEmpty' => true]
            [['logo'],'safe']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '品牌',
            'status' => '状态',
            'intro' => '简介',
            'sort' => '排序',
            'logo' => '商标',
        ];
    }
}
