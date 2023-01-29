<?php

use yii\db\Migration;

/**
 * Class m230127_135926_create_user_admin
 */
class m230127_135926_create_user_admin extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->insert('{{user}}', [
            'username' => 'admin',
            'auth_key' => 'Jg6O-7Sho1sxY38OgTcx3RTX30VUlXTi',
            'password_hash' => '$2y$13$MKjLOsF/qyONMpwqhOe99ufFNK.3f8amFf5lB27/4zD9F1Xj4EiVy',
            'email' => 'admin@localhost.local',
            'status' => '10',
            'created_at' => time(),
            'updated_at' => time()
        ]);
    }

    public function down()
    {
        $this->delete('{{user}}', 'username = "admin"');
    }

}
