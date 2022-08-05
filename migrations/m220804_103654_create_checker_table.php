<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%checker}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%url}}`
 */
class m220804_103654_create_checker_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%checker}}', [
            'id' => $this->primaryKey(),
            'url_id' => $this->integer()->notNull(),
            'date' => $this->timestamp(),
            'number' => $this->integer(),
            'http' => $this->integer(),
        ]);

        // creates index for column `url_id`
        $this->createIndex(
            '{{%idx-checker-url_id}}',
            '{{%checker}}',
            'url_id'
        );

        // add foreign key for table `{{%url}}`
        $this->addForeignKey(
            '{{%fk-checker-url_id}}',
            '{{%checker}}',
            'url_id',
            '{{%url}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%url}}`
        $this->dropForeignKey(
            '{{%fk-checker-url_id}}',
            '{{%checker}}'
        );

        // drops index for column `url_id`
        $this->dropIndex(
            '{{%idx-checker-url_id}}',
            '{{%checker}}'
        );

        $this->dropTable('{{%checker}}');
    }
}
