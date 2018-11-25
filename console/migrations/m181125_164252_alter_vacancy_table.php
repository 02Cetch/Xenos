<?php

use yii\db\Migration;

/**
 * Class m181125_164252_alter_vacancy_table
 */
class m181125_164252_alter_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%vacancy}}', 'reports', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%vacancy}}', 'reports', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181125_164252_alter_vacancy_table cannot be reverted.\n";

        return false;
    }
    */
}
