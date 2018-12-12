<?php

namespace frontend\modules\Vacancy\controllers;

use yii\data\ActiveDataProvider;
use frontend\models\forms\SearchForm;
use Yii;
use frontend\models\User;
use frontend\models\Vacancy;
use yii\data\Pagination;
use yii\web\Response;
use yii\helpers\Url;

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
        }

        return $this->render('index', [
            'pagination' => $pagination,
            'model' => $model,
            'vacancies' => $vacancies,
            'keyword' => $model->getKeyword(),
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

        return $this->render('view', [
            'vacancy' => $vacancy,
            'userData' => $userData,
            'user' => $user,
            'currentUser' => $currentUser,
        ]);
    }

    /**
     * @return string
     *
     * Delete vacancy action
     */
    public function actionDelete()
    {

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        if(Yii::$app->user->isGuest || $currentUser->isUser()) {
            return $this->goHome();
        }

        $model = new Vacancy();

        Yii::$app->response->format = Response::FORMAT_JSON;

        // получаем id поста, который должен быть удалён
        // по методу post
        $id = Yii::$app->request->post('id');


        // находим вакансию
        $vacancy = $model->getVacancyById($id);

        // на всякий случай, проверяем, является ли
        // пользователь автором вакансии
        if($currentUser->getId() != $vacancy->user_id ) {
            return $this->goHome();
        }

        if($vacancy->delete()) {
            return $this->redirect(Url::to(['/user/profile/view', 'id' => $currentUser->getId()]));
        }
        return $this->redirect(Url::to(['/user/profile/view', 'id' => $currentUser->getId()]));

        return [
            'success' => false,
            'text' => 'Error',
        ];
    }

}
