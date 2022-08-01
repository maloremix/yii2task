<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%url}}`.
 */
class m220731_151643_create_url_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%url}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(),
            'frequency' => $this->integer(),
            'replays' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%url}}');
    }
}
