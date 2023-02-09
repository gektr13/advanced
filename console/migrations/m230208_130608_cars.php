<?php

use yii\db\Migration;

/**
 * Class m230208_130608_cars
 */
class m230208_130608_cars extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%car}}', [
            'id' => $this->primaryKey(),
            'owner_id' => $this->integer()->notNull(),
            'brand' => $this->string(12)->notNull(),
            'model' => $this->string(12)->notNull(),
            'horsepower' =>  $this->integer()->notNull(),
            'price' => $this->integer()->notNull(),
            'year' => $this->integer()->notNull(),
            'region' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-car-owner_id',
            'car',
            'owner_id',
            'owner',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%car}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230208_130608_cars cannot be reverted.\n";

        return false;
    }
    */
}
