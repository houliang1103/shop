<?php

use yii\db\Migration;

/**
 * Handles the creation of table `detail`.
 */
class m171225_062132_create_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('detail', [
            'id' => $this->primaryKey(),
            'content'=>$this->text()->notNull()->comment('文章内容'),
            'article_id'=>$this->integer()->notNull()->comment('文章ID')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('detail');
    }
}
