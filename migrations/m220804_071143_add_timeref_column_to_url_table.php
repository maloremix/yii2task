<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%url}}`.
 */
class m220804_071143_add_timeref_column_to_url_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%url}}', 'timeRefresh', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%url}}', 'timeRefresh');
    }
}
