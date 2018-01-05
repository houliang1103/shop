<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "goods_intro".
 *
 * @property int $id
 * @property int $goods_id 商品ID
 * @property string $content 内容
 */
class GoodsIntro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_intro';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'content' => '内容',
        ];
    }
}
