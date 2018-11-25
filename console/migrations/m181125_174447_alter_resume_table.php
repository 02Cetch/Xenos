<?php

use yii\db\Migration;

/**
 * Class m181125_174447_alter_resume_table
 */
class m181125_174447_alter_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%resume}}', 'reports', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%resume}}', 'reports', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181125_174447_alter_resume_table cannot be reverted.\n";

        return false;
    }
    */
}
