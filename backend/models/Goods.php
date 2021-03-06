<?php

namespace backend\models;

use backend\models\Brand;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use backend\models\Category;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $name 名称
 * @property int $sn 货号
 * @property int $create_time 创建时间
 * @property string $market_price 市场价格
 * @property string $shop_price 本店价格
 * @property string $logo 商标
 * @property int $status 状态：1-上架，0-下架
 * @property int $goods_category_id 分类ID
 * @property int $brand_id 品牌ID
 * @property int $stock 库存
 * @property int $sort 排序号
 */
class Goods extends \yii\db\ActiveRecord
{

    public $imgsFile;
    public function behaviors()
    {
        return [
            [
            'class'=>TimestampBehavior::className(),
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT=>['create_time'],
            ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','market_price', 'shop_price', 'goods_category_id', 'brand_id', 'stock'], 'required'],
            [['create_time', 'status', 'goods_category_id', 'brand_id', 'stock', 'sort'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['logo','sn','imgsFile'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'sn' => '货号',
            'create_time' => '创建时间',
            'market_price' => '市场价格',
            'shop_price' => '本店价格',
            'logo' => '商标',
            'imgs' => '商品展示',
            'status' => '状态',
            'goods_category_id' => '所属分类',
            'brand_id' => '所属品牌',
            'stock' => '库存',
            'sort' => '排序号',
        ];
    }
    //商品与品牌一对一关系
    public function getBrandName(){
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }
    //商品与商品分类一对一关系

    public function getCateName(){
        return $this->hasOne(Category::className(),["id"=>"goods_category_id"]);
    }
    //商品与商品详情一对一
    public function getIntro(){
        return $this->hasOne(GoodsIntro::className(),['goods_id'=>'id']);
    }
    //商品与商品图片一对多
    public function getImages(){
        return $this->hasMany(GoodsGallery::className(),['goods_id'=>'id']);
    }

}
