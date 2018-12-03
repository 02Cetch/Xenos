<?php

namespace frontend\controllers;

use frontend\modules\notifications\models\Notifications;
use Yii;
use yii\data\Pagination;
use frontend\models\Resume;
use frontend\models\User;
use frontend\models\forms\SearchForm;
use yii\data\ActiveDataProvider;

class ResumeController extends \yii\web\Controller
{
   /**
    * @return string
    *
    *
    * страница отображения всех резюме
   */
    public function actionIndex()
    {

        $resume = new Resume();
        $model = new SearchForm();

        $dataProvider = null;

        // подключаем пагинацию
        $pagination = new Pagination([
            'defaultPageSize' => 3,
            'totalCount' => $resume->count(),
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);

        // по умолчанию - пока пользователь не воспользовался поиском
        // отображает последние резюме
        $resumes = $resume->getResumes($pagination->offset, $pagination->limit);


        // если пользователь воспользовался поиском
        if($model->load(Yii::$app->request->post())) {

            // получаем данные
            $resumes = $model->resumeSearch();

            // убираем пагинацию
            $pagination = null;
        }

        return $this->render('index', [
            'pagination' => $pagination,
            'model' => $model,
            'resumes' => $resumes,
            'keyword' => $model->getKeyword(),
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

        $notifications = new Notifications();

        /* @var $currentUser User*/
        $currentUser = Yii::$app->user->identity;

        return $this->render('view', [
            'resume' => $resume,
            'userData' => $userData,
            'user' => $user,
            'currentUser' => $currentUser,
            'notifications' => $notifications,
        ]);
    }


}
