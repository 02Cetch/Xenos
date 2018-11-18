<?php

use yii\db\Migration;

/**
 * Class m181112_163648_alter_user_table
 */
class m181112_163648_alter_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'nickname', $this->text());
        $this->addColumn('{{%user}}', 'full_name', $this->text());
        $this->addColumn('{{%user}}', 'phone', $this->text());
        $this->addColumn('{{%user}}', 'address', $this->text());
        $this->addColumn('{{%user}}', 'account_type', $this->integer()->notNull());
        $this->addColumn('{{%user}}', 'years', $this->integer());
        $this->addColumn('{{%user}}', 'description', $this->text());
        $this->addColumn('{{%user}}', 'picture', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'nickname', $this->text());
        $this->dropColumn('{{%user}}', 'full_name', $this->text());
        $this->dropColumn('{{%user}}', 'phone', $this->text());
        $this->dropColumn('{{%user}}', 'address', $this->text());
        $this->dropColumn('{{%user}}', 'account_type', $this->integer()->notNull());
        $this->dropColumn('{{%user}}', 'years', $this->integer());
        $this->dropColumn('{{%user}}', 'description', $this->text());
        $this->dropColumn('{{%user}}', 'picture', $this->text());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181112_163648_alter_user_table cannot be reverted.\n";

        return false;
    }
    */
}
