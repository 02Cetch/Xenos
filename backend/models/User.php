<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
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
    const DEFAULT_COMPANY_IMAGE = '/images/company_logo.png';


    const ROLE_ADMIN = 'admin';
    const ROLE_MODERATOR = 'moderator';

    public $roles;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['roles', 'safe'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function __construct()
    {
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'saveRoles']);
    }
    /**
     * Revoke old roles and assign new if any
     */
    public function saveRoles()
    {
        Yii::$app->authManager->revokeAll($this->getId());


        if (is_array($this->roles)) {

            foreach ($this->roles as $roleName) {
                if ($role = Yii::$app->authManager->getRole($roleName)) {
                    Yii::$app->authManager->assign($role, $this->getId());
                }
            }
        }
    }
    /**
     * Populate roles attribute with data from RBAC after record loaded from DB
     */
    public function afterFind()
    {
        $this->roles = $this->getRoles();
    }

    /**
     * Get user roles from RBAC
     * @return array
     */
    public function getRoles()
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->getId());

        return ArrayHelper::getColumn($roles, 'name', false);
    }
    /**
     * @return array
     */
    public function getRolesDropdown()
    {
        return [
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_MODERATOR => 'Moderator',
        ];
    }
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
        }elseif ($this->isCompany())
        {
            return self::DEFAULT_COMPANY_IMAGE;
        }

        return self::DEFAULT_IMAGE;
    }

    public function approve()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $key = "user:{$this->id}:reports";
        $redis->del($key);

        $this->reports = 0;
        return $this->save(false, ['reports']);
    }
    public static function returnUserAccountType()
    {
        return self::USER_ACCOUNT;
    }
    public static function returnCompanyAccountType()
    {
        return self::COMPANY_ACCOUNT;
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
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
}
