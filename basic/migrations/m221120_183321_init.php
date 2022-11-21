<?php

use yii\db\Migration;

/**
 * Class m221120_183321_init
 */
class m221120_183321_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('CREATE TYPE "record_st" AS enum (\'ACTIVE\', \'DELETED\');');
        $this->execute('CREATE TYPE "role" AS ENUM (\'ADMIN\', \'USER\');');

        $this->execute('CREATE TABLE "students" (
            "id" bigserial NOT NULL,
            PRIMARY KEY ("id"),
            "group" integer NULL,
            "name" text NOT NULL,
            "credit1" boolean NULL,
            "credit2" boolean NULL,
            "credit3" boolean NULL,
            "credit4" boolean NULL,
            "credit5" boolean NULL,
            "exam1" integer NULL,
            "exam2" integer NULL,
            "exam3" integer NULL,
            "exam4" integer NULL,
            "exam5" integer NULL,
            "record_status" record_st NOT NULL DEFAULT \'ACTIVE\'
          );');
        $this->execute('CREATE TABLE "users" (
          "id" bigserial NOT NULL,
          PRIMARY KEY ("id"),
          "name" text NOT NULL UNIQUE,
          "role" role NOT NULL DEFAULT \'USER\',
          "password_hash" text NOT NULL,
          "record_status" record_st NOT NULL DEFAULT \'ACTIVE\'
        );');

        $this->insert('users', [
            'name' => 'admin', 
            'role' => 'ADMIN', 
            'password_hash' => '$2y$13$kYPIII6pwlPyxpbhmJpt9eQFHRoksBG3w9A79SYJBnp8mGHIZShEW',
        ]);
        $this->insert('users', [
            'name' => 'user', 
            'role' => 'USER', 
            'password_hash' => '$2y$13$AK52DSXuwtDp8IPp/HJk/u/UcLSXZnQBoQvi2KXqwTF2ekrvNWjji',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("students");
        $this->dropTable("users");
        $this->execute('DROP TYPE "record_st"');
        $this->execute('DROP TYPE "role"');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221120_183321_init cannot be reverted.\n";

        return false;
    }
    */
}
