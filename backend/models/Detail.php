<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detail".
 *
 * @property int $id
 * @property string $content 文章内容
 * @property int $article_id 文章ID
 */
class Detail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'article_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '文章内容',
            'article_id' => '文章ID',
        ];
    }
}
