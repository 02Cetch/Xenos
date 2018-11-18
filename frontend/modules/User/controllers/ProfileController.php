<?php

namespace frontend\modules\User\controllers;

use yii\data\Pagination;
use frontend\modules\User\models\EditForm;
use Yii;
use yii\web\Controller;
use frontend\models\User;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\web\Response;
use frontend\modules\user\models\forms\PictureForm;

class ProfileController extends Controller
{

    /**
     * экшен, для показа страницы профиля пользователя
     *
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        $user = new User();


        if($user->isUserById($id)) {
            $userPosts = $user->getResumesByUserId($id);
        } elseif ($user->isCompanyById($id)) {
            $userPosts = $user->getVacanciesByUserId($id);
        }

//        echo '<pre>';
//            print_r($this->findUser($id));
//            echo '<br>';
//            print_r($currentUser);die;

        // экземпляр класса PictureForm
        $modelPicture = new PictureForm();

        // передаём во view пользователя,
        // на которого зашли(user)
        // и текущего залогиненного пользователя(currentUser),
        // а также экземпляр модели modelPicture
        return $this->render('view', [
            'user' => $this->findUser($id),
            'userPosts' => $userPosts,
            'currentUser' => $currentUser,
            'modelPicture' => $modelPicture,
        ]);
    }

    public function actionEdit()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        $user = Yii::$app->user->identity;

        $model = new EditForm();
        $modelPicture = new PictureForm();

        if($currentUser->isUser()) {
            $model->scenario = EditForm::SCENARIO_USER_UPDATE;
        } else {
            $model->scenario = EditForm::SCENARIO_COMPANY_UPDATE;
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->load(Yii::$app->request->post())) {
                    if($model->save()) {
                        Yii::$app->getSession()->setFlash('Success', 'Your account information updated');
                        $this->redirect('/profile/view/' . $currentUser->id);
                    }
                }
            }
        }

        return $this->render('edit', [
            'currentUser' => $currentUser,
            'model' => $model,
            'modelPicture' => $modelPicture,
        ]);
    }
    public function actionEditAccount()
    {
        echo 'Hello';
    }
    /**
     * Handle profile image upload via ajax request
     */
    public function actionUploadPicture()
    {
        // формат ответа - JSON (теперь можно возвращать массивы)
        Yii::$app->response->format = Response::FORMAT_JSON;

        // экземпляр класса PictureForm
        $model = new PictureForm();
        // записываем в public $picture адрес заруженной картинки
        //чтобы потом провалидировать и уменьшить изображение), а также загрузить на сервер
        $model->picture = UploadedFile::getInstance($model, 'picture');

        // если модель провалидирована
        if ($model->validate()) {

            // записываем в $user текущего пользователя
            $user = Yii::$app->user->identity;

            // записываем в БД таблицу в строку picture адрес заруженной картинки
            $user->picture = Yii::$app->storage->saveUploadedFile($model->picture); // 15/27/30379e706840f951d22de02458a4788eb55f.jpg

            // сохраняем на сервер картинку
            if ($user->save(false, ['picture'])) {
                // также мы можем вернуть массив, потому что указали формат ответа - JSON
                return [
                    'success' => true,
                    'pictureUri' => Yii::$app->storage->getFile($user->picture),
                ];
            }
        }
        return ['success' => false, 'errors' => $model->getErrors()];
    }



    /**
     * @param string $nickname
     * @return User
     * @throws NotFoundHttpException
     */
    private function findUser($nickname)
    {
        if ($user = User::find()->where(['nickname' => $nickname])->orWhere(['id' => $nickname])->one()) {
            return $user;
        }
        throw new NotFoundHttpException();
    }

    /**
     * экшен удаления картинки
     * @return Response
     *
     */
    public function actionDeletePicture()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        /* @var $currentUser */
        $currentUser = Yii::$app->user->identity;

        if ($currentUser->deletePicture()) {
            Yii::$app->session->setFlash('success', 'Picture deleted');
        } else {
            Yii::$app->session->setFlash('danger', 'Error occured');
        }

        return $this->redirect(['/user/profile/view', 'nickname' => $currentUser->getNickname()]);
    }
    /**
     * @param integer $nickname
     * @return User
     * @throws NotFoundHttpException
     */
    private function findUserById($id)
    {
        if ($user = User::findOne($id)) {
            return $user;
        }
        throw new NotFoundHttpException();
    }

}