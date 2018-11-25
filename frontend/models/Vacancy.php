<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "vacancy".
 *
 * @property int $id
 * @property string $title
 * @property int $salary
 * @property string $responsibilities
 * @property string $offer
 * @property int $experience
 * @property string $description
 * @property int $reports
 */
class Vacancy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['salary', 'experience'], 'integer'],
            [['responsibilities', 'offer', 'description'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }
    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     *
     * get vacancy by id
     */
    public function getVacancyById($id)
    {
        return $this->find()->where(['id' => $id])->one();
    }

    public function report(User $user)
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;

        $key = "vacancy:{$this->getId()}:reports";

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

        return $redis->sismember("vacancy:{$this->id}:reports", $user->getId());
    }

    /**
     * @return \yii\db\ActiveQuery
     *
     * связываем таблицы Vacancy и User по ключу
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     *
     * Получаем данные пользователя
     */
    public function getUserData()
    {

        return $data = User::find()->where(['id' => $this->user_id])->one();
    }

    /**
     * @param $currentUser
     * @return bool
     *
     * проверяет, является ли данная вакансия, сделана пользователем,
     * который посетил залогинен
     *
     */
    public function isUserVacancy($currentUser)
    {
        if($this->user_id = $currentUser->id) {
            return true;
        }
        return false;
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
            'responsibilities' => 'Responsibilities',
            'offer' => 'Offer',
            'experience' => 'Experience',
            'description' => 'Description',
        ];
    }

    /**
     * @param $offset
     * @param $limit
     * @return array|\yii\db\ActiveRecord[]
     *
     * get vacancies
     */
    public function getVacancies($offset, $limit)
    {
        return $this->find()->orderBy('updated_at')->offset($offset)->limit($limit)->all();
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
     * @return int|string
     *
     * count vacancies
     */
    public function count() {
        return $this->find()->count();
    }
}
