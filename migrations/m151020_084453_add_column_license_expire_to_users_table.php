<?php

use yii\db\Schema;
use yii\db\Migration;

class m151020_084453_add_column_license_expire_to_users_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'single_license_expire', $this->date()->defaultValue(date('Y-m-d', strtotime('+3 months'))));
        $this->addColumn('{{%users}}', 'multiple_license_expire', $this->date()->defaultValue(date('Y-m-d', strtotime('+3 months'))));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'single_license_expire');
        $this->dropColumn('{{%users}}', 'multiple_license_expire');
        echo "m151020_084453_add_column_license_expire_to_users_table was reverted.\n";
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
