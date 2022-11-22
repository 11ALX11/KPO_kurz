<?php

namespace app\models;

use Yii;

/**
 * This is the model class for search form in users/index.
 *
 * @property int $id
 * @property string $name
 * @property string $role
 */
class UsersSearchForm extends yii\base\Model {

    public $id = '';
    public $name = '';
    public $role = '0';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'role'], 'string'],
            [['role'], 'validateSearchRole'],
            [['id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id (filter)',
            'name' => 'Name (filter)',
            'role' => 'Role (filter)',
        ];
    }

    /**
     * Validates the role.
     * This method serves as the inline validation for role.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateSearchRole($attribute, $params)
    {
        if (!$this->hasErrors()) {

            if (!array_key_exists($this->$attribute, UsersSearchForm::getSearchRoleDropDownListData())) {
                $this->addError($attribute, 'Incorrect role (filter): '.$this->$attribute.'.');
            }
        }
    }

    /**
     * Returns array for dropList
     *
     * @return array array for dropList field in ActiveField
     */
    public static function getSearchRoleDropDownListData()
    {
        return array_merge(['0' => ''], Users::getRoleDropDownListData());
    }

}