<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "students".
 *
 * @property int $id
 * @property int|null $group
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
 */
class Students extends \yii\db\ActiveRecord
{

    public $debts;
    public $avr_score;
    public $avr_group_score;

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
            [['group', 'exam1', 'exam2', 'exam3', 'exam4', 'exam5'], 'integer'],
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
}
