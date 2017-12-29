<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m171228_074825_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull()->comment('名称'),
            'sn'=>$this->integer()->notNull()->comment('货号'),
            'create_time'=>$this->integer()->notNull()->comment('创建时间'),
            'market_price'=>$this->decimal()->notNull()->comment('市场价格'),
            'shop_price'=>$this->decimal()->notNull()->comment('本店价格'),
            'logo'=>$this->string()->comment('商标'),
            'status'=>$this->smallInteger()->defaultValue('1')->notNull()->comment('状态：1-上架，0-下架'),
            'goods_category_id'=>$this->integer()->notNull()->comment('分类ID'),
            'brand_id'=>$this->integer()->notNull()->comment('品牌ID'),
            'stock'=>$this->integer()->notNull()->comment('库存'),
            'sort'=>$this->integer()->notNull()->defaultValue(100)->comment('排序号'),
        ]);
        $this->createTable('goods_intro',[
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer()->notNull()->comment('商品ID'),
            'content'=>$this->text()->notNull()->comment('内容')
        ]);
        $this->createTable('goods_gallery',[
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer()->notNull()->comment('商品ID'),
            'path'=>$this->string()->comment('图片路径')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
