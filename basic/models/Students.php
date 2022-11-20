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
            [['group', 'exam1', 'exam2', 'exam3', 'exam4', 'exam5'], 'integer'],
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

    public function delete()
    {
        return $this->record_status === 'DELETED';
    }
}
