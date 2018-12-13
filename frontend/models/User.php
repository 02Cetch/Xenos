<?php
namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $about
 * @property integer $type
 * @property string $nickname
 * @property int $phone
 * @property string $address
 * @property integer $account_type
 * @property integer $year
 * @property string $description
 * @property string $image
 * @property string $password write-only password
 * @property integer $reports
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const USER_ACCOUNT = 1;
    const COMPANY_ACCOUNT = 2;

    const DEFAULT_IMAGE = '/img/no-image.png';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     *
     * связываем таблицы User и Resume по ключу
     */
    public function getResumes()
    {
        return $this->hasMany(Resume::class, ['user_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     *
     * связываем таблицы User и Vacancy по ключу
     */
    public function getVacancies()
    {
        return $this->hasMany(Vacancy::class, ['user_id' => 'id']);
    }

    /**
     * @param $id
     * @return array|null|ActiveRecord
     *
     * getting user by id
     */
    public function getUserById($id)
    {
        $model = new User();

        return $user = $model->find()->where(['id' => $id])->one();
    }
    /**
     * @param User $user
     * @return bool
     *
     * Пожаловаться на пользователя
     */
    public function report(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;

        $key = "user:{$this->getId()}:reports";

        if (!$redis->sismember($key, $user->getId())) {
            $redis->sadd($key, $user->getId());

            $this->reports++;

            return $this->save(false, ['reports']);
        }
    }

    /**
     * @return int
     *
     * Returns user account type
     *
     */
    public static function returnUserAccountType()
    {
        return self::USER_ACCOUNT;
    }

    /**
     * @return int
     *
     * Returns company account type
     */
    public static function returnCompanyAccountType()
    {
        return self::COMPANY_ACCOUNT;
    }

    /**
     * @param User $user
     * @return mixed
     *
     * проверяет, жаловались ли уже на пользователя
     */
    public function isReported(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;

        return $redis->sismember("user:{$this->id}:reports", $user->getId());
    }

    /**
     * @param $id
     * @return mixed
     *
     * Getting user by resume id
     */
    public function getUserByResumeId($id)
    {
        $resume = Resume::find()->where(['id' => $id])->one();
        return $userId = $resume->user_id;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
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
     * @param $id
     * @return bool
     * Проверяет, является ли тип аккаунта пользователя - User
     * по ID
     */
    public function isUserById($id)
    {
        $model = new User();

        $user = $model->find()->where(['id' => $id])->one();

        if($user->account_type === self::USER_ACCOUNT) {
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

    /**
     * @param $id
     * @return bool
     *
     * Проверяет, является ли тип аккаунта пользователя - Company
     * по ID
     */
    public function isCompanyById($id)
    {
        $model = new User();
        $user = $model->find()->where(['id' => $id])->one();

        if($user->account_type === self::COMPANY_ACCOUNT) {
            return true;
        }
        return false;
    }

    /**
     * @param $email
     * @return bool
     *
     * Проверяет, уникален ли Email
     */
    public function isUniqueEmail($email)
    {
        $user = new User();

        if($this->email === $email) {
            return true;
        }
        elseif ($user->find()->where(['email' => $email])->all()) {
            return false;
        }
        return false;
    }

    /**
     * @return array|ActiveRecord[]
     *
     * отдаёт все резюме пользователя, основываясь на текущем залогиненном пользователе
     */
    public function getResumesByUser()
    {
        return $resumes = Resume::find()->where(['user_id' => $this->getId()])->asArray()->all();
    }

    /**
     * @return array|ActiveRecord[]
     *
     * отдаёт все вакансии пользователя, основываясь на текущем залогиненном пользователе
     */
    public function getVacanciesByUser()
    {
        return $resumes = Vacancy::find()->where(['user_id' => $this->getId()])->asArray()->all();
    }

    /**
     * @param $id
     * @return array|ActiveRecord[]
     * отдаёт все резюме пользователя, основываясь на на переданном ID пользователя
     */
    public function getResumesByUserId($id)
    {
        return $vacancies = Resume::find()->where(['user_id' => $id])->all();
    }

    /**
     * @param $id
     * @return array|ActiveRecord[]
     *
     * отдаёт все вакансии пользователя, основываясь на на переданном ID пользователя
     */
    public function getVacanciesByUserId($id)
    {
        return $vacancies = Vacancy::find()->where(['user_id' => $id])->all();
    }

    /**
     * @return int|mixed|string
     *
     * возвращает nickname пользователя
     */
    public function getNickname()
    {
        // если у пользователя есть nickname, то возвращаем его, иначе возвращаем id пользователя
        return ($this->nickname) ? $this->nickname : $this->getId();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }
    public function getPicture()
    {
        if($this->image) {
            return Yii::$app->storage->getFile($this->picture);
        }
        return self::DEFAULT_IMAGE;
    }
    /**
     * Delete picture from user record and file system
     * @return boolean
     */
    public function deletePicture()
    {
        if ($this->picture && Yii::$app->storage->deleteFile($this->picture)) {
            $this->picture = null;
            return $this->save(false, ['picture']);
        }
        return false;
    }
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

}
