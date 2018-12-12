<?php

namespace frontend\models;

use yii\helpers\ArrayHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "resume".
 *
 * @property int $id
 * @property string $title
 * @property int $salary
 * @property int $user_id
 * @property int $experience
 * @property string $description
 * @property string $working_experience
 * @property int $created_at
 * @property int $updated_at
 * @property int $reports
 */
class Resume extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume';
    }
    /**
     * @return \yii\db\ActiveQuery
     *
     * связываем таблицы Resume и User по ключу
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     *
     */
    public function getResumeById($id)
    {
        $resume =  $this->find()->where(['id' => $id])->one();
        if (!$resume){
            throw new NotFoundHttpException('Resume not found');
        }
        return $resume;
    }

    /**
     * @param User $user
     * @return bool
     *
     * Пожаловаться на резюме
     */
    public function report(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;

        $key = "resume:{$this->getId()}:reports";

        if (!$redis->sismember($key, $user->getId())) {
            $redis->sadd($key, $user->getId());

            $this->reports++;

            return $this->save(false, ['reports']);
        }
    }
    public function isReported(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;

        return $redis->sismember("resume:{$this->id}:reports", $user->getId());
    }
    /**
     * @return array|null|\yii\db\ActiveRecord
     *
     * возвращает данные пользователя
     */
    public function getUserData()
    {

        return $data = User::find()->where(['id' => $this->user_id])->one();
    }


    /**
     * @param $currentUser
     * @return bool
     *
     * проверяет, является ли данное резюме, сделано пользователем,
     * который посетил залогинен
     *
     */
    public function isUserResume($currentUser)
    {
        if($this->user_id = $currentUser->id) {
            return true;
        }
        return false;
    }

    public function getResumes($offset, $limit)
    {
        return $this->find()->orderBy(['updated_at' => SORT_DESC])->offset($offset)->limit($limit)->all();
    }

    public function count() {
        return $this->find()->count();
    }

    function nl2br2($string) {

        return preg_replace('/\<br(\s*)?\/?\>/i', PHP_EOL, $string);
//        return str_replace(["\r\n", "\r", "\n"], '<br/>', $string);

        return $string;
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
            [['title', 'created_at', 'updated_at'], 'required'],
            [['salary', 'experience', 'created_at', 'updated_at'], 'integer'],
            [['description', 'working_experience'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'salary' => 'Salary',
            'experience' => 'Experience',
            'description' => 'Description',
            'working_experience' => 'Working Experience',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
