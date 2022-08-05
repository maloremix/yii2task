<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%url}}`.
 */
class m220804_071515_add_error_column_to_url_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%url}}', 'error', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%url}}', 'error');
    }
}
