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
            $$ LANGUAGE plpgsql IMMUTABLE;
        ');

        $this->execute('
            ALTER TABLE "students"
                ADD "debts" integer NULL GENERATED ALWAYS AS (students_debts_count(credit1, credit2, credit3, credit4, credit5, exam1, exam2, exam3, exam4, exam5)) STORED,
                ADD "avr_score" real NULL GENERATED ALWAYS AS ((exam1 + exam2 + exam3 + exam4 + exam5) / 5.0) STORED,
                ADD "avr_group_score" real NULL;
                
        ');//ADD "is_triggered" boolean NULL;
        
        /*$this->execute('
            CREATE FUNCTION students_avr_group_score() RETURNS trigger AS $students_avr_group_score_trigger$
            DECLARE
                avr_grp_score real;
            BEGIN
                IF NEW.is_triggered IS NOT TRUE THEN
                    IF NEW.group IS NOT NULL THEN
                        NEW.is_triggered := true;
        
                        SELECT AVG(avr_score) INTO avr_grp_score FROM "students" WHERE "group" = NEW.group AND "record_status" = \'ACTIVE\';
                        UPDATE "students" SET "avr_group_score" = avr_grp_score WHERE "group" = NEW.group;
        
                        NEW.is_triggered := false;
                    END IF;
                END IF;

                RETURN NEW;
            END;
            $students_avr_group_score_trigger$ LANGUAGE plpgsql;
        ');

        $this->execute('
            CREATE TRIGGER students_avr_group_score_trigger 
            AFTER INSERT OR UPDATE ON students
                FOR EACH ROW 
                WHEN (NEW.is_triggered IS NOT TRUE)
                EXECUTE PROCEDURE students_avr_group_score();
        ');*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP FUNCTION "students_debts_count"(boolean, boolean, boolean, boolean, boolean, integer, integer, integer, integer, integer);');

        $this->execute('DROP TRIGGER "students_avr_group_score_trigger" ON "students"');
        $this->execute('DROP FUNCTION "students_avr_group_score"()');

        $this->execute('
            ALTER TABLE "students"
                DROP "avr_score",
                DROP "avr_group_score";
        ');// DROP "is_triggered";

        return true;
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
