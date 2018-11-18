<?php

namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use frontend\models\Resume;
use frontend\models\User;

class ResumeController extends \yii\web\Controller
{
    /**
     * @return string
     *
     */
    public function actionIndex()
    {

        $resume = new Resume();

        // подключаем пагинацию
        $pagination = new Pagination([
            'defaultPageSize' => 3,
            'totalCount' => $resume->count(),
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);

        $resumes = $resume->getResumes($pagination->offset, $pagination->limit);

//        echo '<pre>';
//            print_r($userData);
//        echo '</pre>';die;
        return $this->render('index', [
            'resumes' => $resumes,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @param $id
     * @return string
     *
     * Просмотр резюме отдельно
     */
    public function actionView($id)
    {
        $user = new User();

        $resume = new Resume();

        $resume = $resume->getVacancyById($id);

        $userData = $resume->getUserData();

//        echo '<pre>';
//            print_r($userData);
//        echo '</pre>';die;


        /* @var $currentUser User*/
        $currentUser = Yii::$app->user->identity;

        return $this->render('view', [
            'resume' => $resume,
            'userData' => $userData,
            'user' => $user,
            'currentUser' => $currentUser
        ]);
    }


}
