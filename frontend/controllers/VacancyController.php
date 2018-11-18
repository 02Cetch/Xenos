<?php

namespace frontend\controllers;

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

        $pagination = new Pagination([
            'defaultPageSize' => 3,
            'totalCount' => $vacancy->count(),
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);

        $vacancies = $vacancy->getVacancies($pagination->offset, $pagination->limit);

//        echo '<pre>';
//            print_r($vacancies);
//        echo '</pre>';die;
        return $this->render('index', [
            'vacancies' => $vacancies,
            'pagination' => $pagination,
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
