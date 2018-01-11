<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_categrory".
 *
 * @property int $id
 * @property string $name 名称
 * @property int $is_help 帮助类：0-是，1-非
 * @property int $status 状态：0-隐藏，1-显示
 * @property int $sort 排序
 * @property string $intro 简介
 */
class ArticleCategrory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','intro'], 'required'],
            [['is_help', 'status', 'sort'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '名称',
            'is_help' => '帮助类',
            'status' => '状态',
            'sort' => '排序',
            'intro' => '简介',
        ];
    }
}
