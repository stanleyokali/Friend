<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $username
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 *
 * @property FriendRequest[] $friendRequests
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
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
            [['firstname', 'lastname', 'username', 'password'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['firstname', 'lastname'], 'string', 'max' => 50],
            [['username'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'username' => 'Username',
            'password' => 'Password',
            
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
        // return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
    public function getId()
    {
        return $this->id;
    }
    public function getAuthKey()
    {
        // return $this->auth_Key;
    }
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }
        public function validatePassword($password)
    {
        return $this->password === $password;
    }

    /**
     * Gets query for [[FriendRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFriendRequests()
    {
        return $this->hasMany(FriendRequest::className(), ['user_id' => 'id']);
    }
}
