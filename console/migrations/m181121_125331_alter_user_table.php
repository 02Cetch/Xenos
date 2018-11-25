<?php

use yii\db\Migration;

/**
 * Class m181121_125331_alter_user_table
 */
class m181121_125331_alter_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'reports', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'reports', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181121_125331_alter_user_table cannot be reverted.\n";

        return false;
    }
    */
}
