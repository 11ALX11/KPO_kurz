<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "students".
 *
 * @property int $id
 * @property string|null $group
 * @property string $name
 * @property bool|null $credit1
 * @property bool|null $credit2
 * @property bool|null $credit3
 * @property bool|null $credit4
 * @property bool|null $credit5
 * @property int|null $exam1
 * @property int|null $exam2
 * @property int|null $exam3
 * @property int|null $exam4
 * @property int|null $exam5
 * @property string $record_status
 * @property int|null $debts
 * @property int|null $avr_score
 * @property int|null $avr_group_score
 */
class Students extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'students';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group', 'exam1', 'exam2', 'exam3', 'exam4', 'exam5'], 'default', 'value' => null],
            [['group'], 'string', 'min' => Yii::$app->params['validGroupRange']['min'], 'max' => Yii::$app->params['validGroupRange']['max']],
            [['group', 'exam1', 'exam2', 'exam3', 'exam4', 'exam5', 'debts'], 'integer'],
            [['avr_score', 'avr_group_score'], 'number'],
            [['exam1', 'exam2', 'exam3', 'exam4', 'exam5'], 'in', 'range' => Yii::$app->params['validExamMarks']],
            [['name'], 'required'],
            [['name', 'record_status'], 'string'],
            [['credit1', 'credit2', 'credit3', 'credit4', 'credit5'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group' => 'Group',
            'name' => 'Name',
            'credit1' => 'Credit1',
            'credit2' => 'Credit2',
            'credit3' => 'Credit3',
            'credit4' => 'Credit4',
            'credit5' => 'Credit5',
            'exam1' => 'Exam1',
            'exam2' => 'Exam2',
            'exam3' => 'Exam3',
            'exam4' => 'Exam4',
            'exam5' => 'Exam5',
            'record_status' => 'Record Status',
            'debts' => 'Debts',
            'avr_score' => 'Avr. Score',
            'avr_group_score' => 'Avr. Group Score',
        ];
    }

    /**
     * Deletes record by marking it's status as DELETED
     *
     * @return bool true if operation was succesfull
     */
    public function delete()
    {
        $this->record_status = 'DELETED';
        return $this->save();
    }

    /**
     * Updates avr_group_score
     *
     * @return void
     */
    public function updateAvrGroupScore()
    {
        $models = Students::find()
            ->where('"group" = \''. $this->group .'\' AND "record_status" = \'ACTIVE\'')
            ->all();
        
        $sum = 0; $n = 0;
        foreach ($models as $model) {
            $sum += $model->avr_score;
            if ( is_null($model->avr_score) ) {
                $n++;
            }
        }
        if (count($models) - $n > 0) {
            $avg = $sum / (count($models) - $n);

            $this->avr_group_score = $avg;
            Students::updateAll(['avr_group_score' => $avg], ['group' => $this->group]);
        }
        else {
            $this->avr_group_score = null;
            $this->save();
        }
    }
}
