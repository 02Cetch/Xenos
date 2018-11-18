<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vacancy`.
 */
class m181112_123720_create_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vacancy', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'salary' => $this->integer(),
            'responsibilities' => $this->text(),
            'offer' => $this->text(),
            'experience' => $this->integer(),
            'description' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vacancy');
    }
}
