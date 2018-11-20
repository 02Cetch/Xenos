<?php
/**
 * Created by PhpStorm.
 * User: 55555
 * Date: 31.08.2018
 * Time: 12:59
 */

namespace frontend\models\forms;

use frontend\models\Vacancy;
use Yii;
use yii\helpers\ArrayHelper;
use frontend\models\Resume;
use yii\base\Model;

/**
 * Class SearchForm
 * @package frontend\models\forms
 *
 * содержит общие правила для валидации формы
 */
class SearchForm extends Model
{
    public $keyword;

    /**
     * @return array
     *
     * правила валидации формы
     */
    public function rules()
    {
        return [
            ['keyword', 'trim'],
            ['keyword', 'required'],
            ['keyword', 'string', 'min' => 3],
            ['keyword', 'string', 'max' => 300],
        ];
    }

    /**
     * @return $this
     *
     * поиск по таблице resume
     */
    public function resumeSearch()
    {
        // если форма провалидирована
        if($this->validate())
        {
            // sql запрос к Sphinx
            $sql = "SELECT * FROM resume_index WHERE MATCH(:keyword) OPTION ranker = sph04";

            $params = [
                'keyword' => $this->keyword,
            ];

            // возвращает ключи записей в БД
            $dataId = Yii::$app->sphinx->createCommand($sql, $params)->queryAll();

            // модифицируем массив
            $resumesId = ArrayHelper::map($dataId, 'id', 'id');

            // находим записи в БД и возвращаем
            return $data = Resume::find()->where(['id' => $resumesId])->asArray(); //->all();
        }
    }

    /**
     * @return $this
     *
     * поиск по таблице vacancy
     */
    public function vacancySearch()
    {
        // если форма провалидирована
        if($this->validate())
        {
            // sql запрос к Sphinx
            $sql = "SELECT * FROM vacancy_index WHERE MATCH(:keyword) OPTION ranker = sph04";

            $params = [
                'keyword' => $this->keyword,
            ];

            // возвращает ключи записей в БД
            $dataId = Yii::$app->sphinx->createCommand($sql, $params)->queryAll();


            // модифицируем массив
            $resumesId = ArrayHelper::map($dataId, 'id', 'id');

            // находим записи в БД и возвращаем
            return $data = Vacancy::find()->where(['id' => $resumesId])->asArray(); //->all();
        }
    }
}