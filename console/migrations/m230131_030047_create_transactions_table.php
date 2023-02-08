<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transactions}}`.
 */
class m230131_030047_create_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transactions}}', [
            'id' => $this->primaryKey(),
            'organization_id' =>  $this->integer(),
            'value' => $this->float(),
            'purpose' => $this->string()->notNull(),
            'created_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-transaction-organization_id',
            'transactions',
            'organization_id',
            'organizations',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transactions}}');
    }
}
