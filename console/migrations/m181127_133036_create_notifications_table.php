<?php

use yii\db\Migration;

/**
 * Handles the creation of table `notifications`.
 */
class m181127_133036_create_notifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('notifications', [
            'id' => $this->primaryKey(),
            'sender_id' => $this->integer(),
            'receiver_id' => $this->integer(),
            'resume_id' => $this->integer(),
            'type' => $this->integer(),
            'seen' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('notifications');
    }
}
