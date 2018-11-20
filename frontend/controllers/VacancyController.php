<?php

namespace frontend\controllers;

use yii\data\ActiveDataProvider;
use frontend\models\forms\SearchForm;
use Yii;
use frontend\models\User;
use frontend\models\Vacancy;
use yii\data\Pagination;

class VacancyController extends \yii\web\Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $vacancy = new Vacancy();
        $model = new SearchForm();

        $dataProvider = null;

        // подключаем пагинацию
        $pagination = new Pagination([
            'defaultPageSize' => 3,
            'totalCount' => $vacancy->count(),
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);

        // по умолчанию - пока пользователь не воспользовался поиском
        // отображает последние резюме
        $vacancies = $vacancy->getVacancies($pagination->offset, $pagination->limit);


        // если пользователь воспользовался поиском
        if($model->load(Yii::$app->request->post())) {

            // получаем данные, но уже без пагинации
            $vacancies = $model->vacancySearch();

            // убираем пагинацию
            $pagination = null;

            $dataProvider = new ActiveDataProvider([
                'query' => $vacancies,
//                'pagination' => [
//                    'pageSize' => 2,
//                ],
            ]);
            $vacancies = $dataProvider->getModels();
        }

        return $this->render('index', [
            'pagination' => $pagination,
            'model' => $model,
            'vacancies' => $vacancies,
        ]);
    }

    /**
     * @param $id
     * @return string
     *
     * Просмотр вакансии отдельно
     */
    public function actionView($id)
    {
        $user = new User();

        $vacancy = new Vacancy();

        $vacancy = $vacancy->getVacancyById($id);

        $userData = $vacancy->getUserData();

        /* @var $currentUser User*/
        $currentUser = Yii::$app->user->identity;

//        echo '<pre>';
//            print_r($vacancy);
//        echo '</pre>';die;

        return $this->render('view', [
            'vacancy' => $vacancy,
            'userData' => $userData,
            'user' => $user,
            'currentUser' => $currentUser,
        ]);
    }

}
