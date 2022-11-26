<?php

namespace app\models;

use Yii;

/**
 * This is the model class for search form in students/index.
 *
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
 */
class StudentsSearchForm extends yii\base\Model {

    public $group;
    public $name;
    public $credit1;
    public $credit2;
    public $credit3;
    public $credit4;
    public $credit5;
    public $exam1;
    public $exam2;
    public $exam3;
    public $exam4;
    public $exam5;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group'], 'string', 'min' => Yii::$app->params['validGroupRange']['min'], 'max' => Yii::$app->params['validGroupRange']['max']],
            [['group', 'exam1', 'exam2', 'exam3', 'exam4', 'exam5'], 'integer'],
            [['exam1', 'exam2', 'exam3', 'exam4', 'exam5'], 'in', 'range' => Yii::$app->params['validExamMarks']],
            [['name'], 'string'],
            [['credit1', 'credit2', 'credit3', 'credit4', 'credit5'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'group' => 'Group (filter)',
            'name' => 'Name (filter)',
            'credit1' => 'Credit №1 (filter)',
            'credit2' => 'Credit №2 (filter)',
            'credit3' => 'Credit №3 (filter)',
            'credit4' => 'Credit №4 (filter)',
            'credit5' => 'Credit №5 (filter)',
            'exam1' => 'Exam №1 (filter)',
            'exam2' => 'Exam №2 (filter)',
            'exam3' => 'Exam №3 (filter)',
            'exam4' => 'Exam №4 (filter)',
            'exam5' => 'Exam №5 (filter)',
        ];
    }

    /**
     * Returns array for dropList
     *
     * @return array array for dropList field in ActiveField
     */
    public static function getSearchCreditDropDownListData()
    {
        return [
            '' => '',
            '1' => 'Yes',
            '0' => 'No',
        ];
    }

}