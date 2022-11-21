<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $role
 * @property string $password_hash
 * @property string $record_status
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'password_hash'], 'required'],
            [['name', 'role', 'password_hash', 'record_status'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'role' => 'Role',
            'password_hash' => 'Password Hash',
            'record_status' => 'Record Status',
        ];
    }

    /**
     * Finds user by id
     *
     * @param string $id
     * @return static|null
     */
    public static function findIdentity($id)
    {
        $user = static::findOne($id);
        if ($user->record_status == 'DELETED') {
            return null;
        }

        return $user;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->password_hash;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function getUsername()
    {
        return $this->name;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = static::findOne(['name' => $username]);
        if ($user->record_status == 'DELETED') {
            return null;
        }
        
        return $user;
    }

    /**
     * Validates password
     *
     * @param string $password The password to verify.
     * @return bool whether the password is correct.
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Create password_hash
     *
     * @param string $password The password to turn in.
     * @return string returns hash.
     */
    public static function createHash($password)
    {
        return Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Checks if user is admin
     *
     * @return bool true, if user is admin.
     */
    public function isAmdin()
    {
        return $this->role === 'ADMIN';
    }

    /**
     * Deltes record by marking it's status as DELETED
     *
     * @return bool true if operation was succesfull
     */
    public function delete()
    {
        $this->record_status = 'DELETED';
        return $this->save();
    }
}
