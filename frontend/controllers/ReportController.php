<?php

namespace frontend\controllers;

use Yii;

use frontend\models\Vacancy;
use frontend\models\Resume;
use frontend\models\User;
use yii\web\Response;

/**
 * Class ReportController
 * @package frontend\controllers
 *
 * Контроллер для репортов записей
 */
class ReportController extends \yii\web\Controller
{

    /**
     * @param $id
     * @return string
     *
     * Report profile action
     */
    public function actionReportProfile()
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['/user/login']);
        }

        $model = new User();

        Yii::$app->response->format = Response::FORMAT_JSON;

        // получаем id поста, на который пожаловались
        // по методу post
        $id = Yii::$app->request->post('id');

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;
        // находим пост
        $user = $model->getUserById($id);

        if($user->report($currentUser)) {
            return [
                'success' => true,
                'text' => 'User Reported',
            ];
        }
        return [
            'success' => false,
            'text' => 'Error',
        ];
    }


    /**
     * @return string
     *
     * Report vacancy action
     */
    public function actionReportVacancy()
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['/user/login']);
        }

        $model = new Vacancy();

        Yii::$app->response->format = Response::FORMAT_JSON;

        // получаем id поста, на который пожаловались
        // по методу post
        $id = Yii::$app->request->post('id');

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        // находим вакансию
        $vacancy = $model->getVacancyById($id);

        if($vacancy->report($currentUser)) {
            return [
                'success' => true,
                'text' => 'Vacancy Reported',
            ];
        }
        return [
            'success' => false,
            'text' => 'Error',
        ];
    }

    /**
     * @return string
     *
     * Report resume action
     */
    public function actionReportResume()
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['/user/login']);
        }

        $model = new Resume();

        Yii::$app->response->format = Response::FORMAT_JSON;

        // получаем id поста, на который пожаловались
        // по методу post
        $id = Yii::$app->request->post('id');

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        // находим вакансию
        $resume = $model->getResumeById($id);

        if($resume->report($currentUser)) {
            return [
                'success' => true,
                'text' => 'Resume Reported',
            ];
        }
        return [
            'success' => false,
            'text' => 'Error',
        ];
    }

}
