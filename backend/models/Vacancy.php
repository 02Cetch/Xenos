<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "vacancy".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property int $salary
 * @property string $responsibilities
 * @property string $offer
 * @property int $experience
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
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
            [['user_id', 'title', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'salary', 'experience', 'created_at', 'updated_at', 'reports'], 'integer'],
            [['responsibilities', 'offer', 'description'], 'string'],
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
            'user_id' => 'User ID',
            'title' => 'Title',
            'salary' => 'Salary',
            'responsibilities' => 'Responsibilities',
            'offer' => 'Offer',
            'experience' => 'Experience',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'reports' => 'Reports',
        ];
    }
    public static function findReports()
    {
        return Vacancy::find()->where('reports > 0')->orderBy('reports DESC');
    }
    public function approve()
    {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $key = "vacancy:{$this->id}:reports";
        $redis->del($key);

        $this->reports = 0;
        return $this->save(false, ['reports']);
    }
}
