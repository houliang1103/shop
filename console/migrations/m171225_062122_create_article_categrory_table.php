<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_categrory`.
 */
class m171225_062122_create_article_categrory_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_categrory', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('名称'),
            'is_help'=>$this->smallInteger()->defaultValue('1')->comment('帮助类：0-是，1-非'),
            'status'=>$this->smallInteger()->defaultValue('1')->comment('状态：0-隐藏，1-显示'),
            'sort'=>$this->smallInteger()->defaultValue('100')->comment('排序'),
            'intro'=>$this->string()->comment('简介'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_categrory');
    }
}
