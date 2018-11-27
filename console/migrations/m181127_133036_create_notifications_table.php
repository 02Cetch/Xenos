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
