<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title 标题
 * @property int $create_time 创建时间
 * @property string $intro 简介
 * @property int $status 状态：0-隐藏，1-显示
 * @property int $sort 排序
 * @property int $cate_id 分类ID
 */
class Article extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
            'class'=>TimestampBehavior::className(),
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT=>['create_time'],
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
            [['title','cate_id','intro'], 'required'],
            [['status', 'sort', 'cate_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => '标题',
            'create_time' => '创建时间',
            'intro' => '简介',
            'status' => '状态',
            'sort' => '排序',
            'cate_id' => '分类ID',
        ];
    }
    //与分类一对一
    public function getCateName(){
        return $this->hasOne(ArticleCategrory::className(),['id'=>'cate_id']);
    }
}
