<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m171225_062108_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(100)->notNull()->comment('标题'),
            'create_time'=>$this->integer()->notNull()->comment('创建时间'),
            'intro'=>$this->string()->comment('简介'),
            'status'=>$this->smallInteger()->defaultValue('1')->comment('状态：0-隐藏，1-显示'),
            'sort'=>$this->smallInteger()->defaultValue('100')->comment('排序'),
            'cate_id'=>$this->integer()->notNull()->comment('分类ID'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
