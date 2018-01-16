<?php

use yii\db\Migration;

/**
 * Handles the creation of table `oreder_detail`.
 */
class m180113_074809_create_oreder_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('oreder_detail', [
            'id' => $this->primaryKey(),
            'goods_id' => $this->smallInteger()->notNull()->comment('商品ID'),
            'logo' => $this->string()->comment('商品logo'),
            'price' => $this->decimal()->notNull()->comment('商品单价'),
            'amount' => $this->integer()->notNull()->comment('商品数量'),
            'total_price' => $this->decimal()->notNull()->comment('订单总价'),
            'order_id' => $this->smallInteger()->notNull()->comment('订单ID'),
            'goods_name' => $this->string()->comment('商品名称'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('oreder_detail');
    }
}
