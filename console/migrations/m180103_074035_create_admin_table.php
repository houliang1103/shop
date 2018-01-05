<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m180103_074035_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull()->comment('密码'),
            'email' => $this->string()->notNull()->unique()->comment('邮箱'),
            'token' => $this->string()->notNull()->comment('自动登录令牌'),
            'salt' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'last_ip'=>$this->integer()->notNull()->comment('最后登录IP'),
            'last_login_at'=>$this->integer()->notNull()->comment('最后登录时间'),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}
