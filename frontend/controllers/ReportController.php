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
     * @param $id
     * @return string
     *
     * Report resume action
     */
    public function actionReportResume($id)
    {
        return $this->render('report-resume');
    }

    /**
     * @param $id
     * @return string
     *
     * Report vacancy action
     */
    public function actionReportVacancy($id)
    {
        return $this->render('report-vacancy');
    }


}
