<?php

use yii\db\Migration;

/**
 * Class m230208_130442_owner
 */
class m230208_130442_owner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%owner}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(12)->notNull()->unique(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%owner}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230208_130442_owner cannot be reverted.\n";

        return false;
    }
    */
}
