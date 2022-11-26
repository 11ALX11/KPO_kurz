<?php

use yii\db\Migration;

/**
 * Class m221126_154237_chg_group_type_into_string
 */
class m221126_154237_chg_group_type_into_string extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('students', 'group', 'text');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221126_154237_chg_group_type_into_string cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221126_154237_chg_group_type_into_string cannot be reverted.\n";

        return false;
    }
    */
}
