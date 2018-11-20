<?php

namespace frontend\models;

use yii\helpers\ArrayHelper;
use Yii;
use yii\data\ActiveDataProvider;

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

    function nl2br2($string) {

        return preg_replace('/\<br(\s*)?\/?\>/i', PHP_EOL, $string);
//        return str_replace(["\r\n", "\r", "\n"], '<br/>', $string);

        return $string;
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
