<?php

use yii\db\Migration;

/**
 * Class m221221_133330_add_debts
 */
class m221221_133330_add_debts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('
            CREATE FUNCTION students_debts_count(cr1 boolean, cr2 boolean, cr3 boolean, cr4 boolean, cr5 boolean, ex1 integer, ex2 integer, ex3 integer, ex4 integer, ex5 integer) RETURNS integer AS $$
                DECLARE
                    x integer := 0;
                BEGIN

                    IF cr1 IS NOT TRUE THEN x:=x+1; END IF;
                    IF cr2 IS NOT TRUE THEN x:=x+1; END IF;
                    IF cr3 IS NOT TRUE THEN x:=x+1; END IF;
                    IF cr4 IS NOT TRUE THEN x:=x+1; END IF;
                    IF cr5 IS NOT TRUE THEN x:=x+1; END IF;

                    IF ex1 IS NULL THEN x:=x+1; END IF;
                    IF ex2 IS NULL THEN x:=x+1; END IF;
                    IF ex3 IS NULL THEN x:=x+1; END IF;
                    IF ex4 IS NULL THEN x:=x+1; END IF;
                    IF ex5 IS NULL THEN x:=x+1; END IF;

                    RETURN x;
                END;
            $$ LANGUAGE plpgsql;
        ');

        $this->execute('
            ALTER TABLE "students"
            ADD "debts" integer NULL GENERATED ALWAYS AS (students_debts_count(credit1, credit2, credit3, credit4, credit5, exam1, exam2, exam3, exam4, exam5)) STORED,
            ADD "avr_score" integer NULL GENERATED ALWAYS AS ((exam1 + exam2 + exam3 + exam4 + exam5) / 5) STORED;
        ');

        $this->execute('
            CREATE FUNCTION students_avr_group_score_count(grp text) RETURNS integer AS $$
                SELECT AVR(avr_score) FROM students WHERE students.group = grp;
            $$ LANGUAGE SQL;
        ');

        $this->execute('
            ALTER TABLE "students"
            ADD "avr_group_score" integer NULL GENERATE ALWAYS AS (students_avr_group_score_count(group)) STORED;
        ');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221221_133330_add_debts cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221221_133330_add_debts cannot be reverted.\n";

        return false;
    }
    */
}
