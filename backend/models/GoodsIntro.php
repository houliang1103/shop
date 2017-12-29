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
            [['goods_id', 'content'], 'required'],
            [['goods_id'], 'integer'],
            [['content'], 'string'],
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
            'content' => '内容',
        ];
    }
}
