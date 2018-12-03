<?php

namespace frontend\modules\notifications\models;

use frontend\models\Resume;
use frontend\models\User;
use Yii;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property int $sender_id
 * @property int $receiver_id
 * @property int $resume_id
 * @property int $type
 * @property int $seen
 * @property int $created_at
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * Типы уведомлений
     *
     * self::NOTIFICATION_TYPE_LIKED_RESUME_BY_COMPANY тип уведомлений,
     * при котором пользователь оповещается об отклике на его резюме
     *
     * self::NOTIFICATION_TYPE_UPDATE_USER_DATA тип уведомлений,
     * при котором пользователь оповещается о смене данных его аккаунта
     *
     * self::NOTIFICATION_TYPE_RESET_PASSWORD тип уведомлений,
     * при котором пользователь оповещается о смене пароля
     */
    const NOTIFICATION_TYPE_LIKED_RESUME_BY_COMPANY = 1;
    const NOTIFICATION_TYPE_UPDATE_USER_DATA = 2;
    const NOTIFICATION_TYPE_RESET_PASSWORD = 3;


    /**
     * Видел ли это уведомление пользователь
     */
    const NOTIFICATION_NOT_SEEN_BY_USER = 0;
    const NOTIFICATION_IS_SEEN_BY_USER = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifications';
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'receiver_id']);
    }
    public function getResume()
    {
        return $this->hasOne(Resume::class, ['id' => 'resume_id']);
    }

    public static function count($userId)
    {
        return Notifications::find()->where(['receiver_id' => $userId])->andWhere(['seen' => 0])->count();
    }

    public function getUserById($id)
    {
        return User::find()->where(['id' => $id])->one();
    }

    public function getNotifications(User $user)
    {
        $model = new Notifications();

        return $model->find()->where(['receiver_id' => $user->id])->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function isSeenByUser()
    {
        if ($this->seen === self::NOTIFICATION_IS_SEEN_BY_USER) {
            return true;
        }
        return false;
    }
    public function setSeenByUser()
    {
        if ($this->seen === self::NOTIFICATION_IS_SEEN_BY_USER) {
            return true;
        }

        $notification = $this;

        $notification->seen = self::NOTIFICATION_IS_SEEN_BY_USER;

        $notification->save(true);
    }

    /**
     * @param null | int $senderId
     * @param int $receiverId
     * @param null | int $resumeId
     * @param int $type
     * @return bool
     * Метод для создания уведомления
     *
     */
    public function createNotification($senderId = null, $receiverId, $resumeId = null, $type)
    {
            /* @var $redis Connection */
            $redis = Yii::$app->redis;

        if ($type === self::NOTIFICATION_TYPE_LIKED_RESUME_BY_COMPANY) {

            $key = "notification:{$this->getId()}:liked";

            if (!$redis->sismember($key, $senderId)) {

                $redis->sadd($key, $senderId);

                $notification = $this;

                $notification->sender_id = $senderId;
                $notification->receiver_id = $receiverId;
                $notification->resume_id = $resumeId;
                $notification->type = $type;
                $notification->created_at = $time = time();
                $notification->seen = self::NOTIFICATION_NOT_SEEN_BY_USER;

                return $notification->save(false);

            }
        }else {
            $notification = $this;

            $notification->sender_id = $senderId;
            $notification->receiver_id = $receiverId;
            $notification->resume_id = $resumeId;
            $notification->type = $type;
            $notification->created_at = $time = time();
            $notification->seen = self::NOTIFICATION_NOT_SEEN_BY_USER;

            return $notification->save(false);
        }
    }

    public function isAlreadyNotify($id)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;

        return $redis->sismember("notification:{$this->id}:liked", $id);
    }
    /**
     *
     * @return bool
     *
     * Проверяет тип уведомления на LIKED_RESUME_BY_COMPANY
     */
    public function typeLikedResumeByCompany()
    {
        if ($this->type === self::NOTIFICATION_TYPE_LIKED_RESUME_BY_COMPANY) {
            return true;
        }
        return false;
    }

    /**
     *
     * @return bool
     *
     * Проверяет тип уведомления на UPDATE_USER_DATA
     */
    public function typeUpdateUserData()
    {
        if ($this->type === self::NOTIFICATION_TYPE_UPDATE_USER_DATA) {
            return true;
        }
        return false;
    }

    /**
     *
     * @return bool
     *
     * Проверяет тип уведомления на RESET_PASSWORD
     */
    public function typeResetPassword()
    {
        if ($this->type === self::NOTIFICATION_TYPE_RESET_PASSWORD) {
            return true;
        }
        return false;
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
    public function rules()
    {
        return [
            [['sender_id', 'receiver_id', 'type', 'seen', 'created_at'], 'integer'],
            [['created_at'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_id' => 'Sender ID',
            'receiver_id' => 'Receiver ID',
            'resume_id' => 'Resume ID',
            'type' => 'Type',
            'seen' => 'Seen',
            'created_at' => 'Created At',
        ];
    }
}
