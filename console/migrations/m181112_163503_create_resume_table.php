<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resume`.
 */
class m181112_163503_create_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('resume', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'salary' => $this->integer(),
            'experience' => $this->integer(),
            'description' => $this->text(),
            'working_experience' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('resume');
    }
}
