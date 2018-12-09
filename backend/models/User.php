<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $nickname
 * @property string $full_name
 * @property string $phone
 * @property string $address
 * @property int $account_type
 * @property int $years
 * @property string $description
 * @property string $picture
 * @property int $reports
 */
class User extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const USER_ACCOUNT = 1;
    const COMPANY_ACCOUNT = 2;

    const DEFAULT_IMAGE = '/images/avatar.png';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function rules()
//    {
//        return [
//            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at', 'account_type'], 'required'],
//            [['status', 'created_at', 'updated_at', 'account_type', 'years', 'reports'], 'integer'],
//            [['nickname', 'full_name', 'phone', 'address', 'description', 'picture'], 'string'],
//            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
//            [['auth_key'], 'string', 'max' => 32],
//            [['username'], 'unique'],
//            [['email'], 'unique'],
//            [['password_reset_token'], 'unique'],
//        ];
//    }
    /**
     * @return bool
     * Проверяет, является ли тип аккаунта пользователя - User
     */
    public function isUser()
    {
        if($this->account_type === self::USER_ACCOUNT) {

            return true;
        }
        return false;
    }
    /**
     * @return bool
     * Проверяет, является ли тип аккаунта пользователя - Company
     */
    public function isCompany()
    {
        if($this->account_type === self::COMPANY_ACCOUNT) {
            return true;
        }
        return false;
    }

    public static function findReports()
    {
        return User::find()->where('reports > 0')->orderBy('reports DESC');
    }
    public function getImage()
    {
        if($this->picture) {
            return Yii::$app->storage->getFile($this->picture);
        }
        return self::DEFAULT_IMAGE;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'nickname' => 'Nickname',
            'full_name' => 'Full Name',
            'phone' => 'Phone',
            'address' => 'Address',
            'account_type' => 'Account Type',
            'years' => 'Years',
            'description' => 'Description',
            'picture' => 'Picture',
            'reports' => 'Reports',
        ];
    }
}
