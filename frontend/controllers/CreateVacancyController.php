<?php

namespace frontend\controllers;

use frontend\models\forms\CreateVacancyForm;

use Yii;

/**
 * Class CreateVacancyController
 * @package frontend\controllers
 *
 * Creating new vacancy
 */
class CreateVacancyController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new CreateVacancyForm();

        $currentUser = Yii::$app->user->identity;

        if($currentUser->isUser()) {
            $this->goHome();
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if($model->save()) {
                    Yii::$app->getSession()->setFlash('Success', 'Your account information updated');
                }
            }
        }

        return $this->render('index', [
            'currentUser' => $currentUser,
            'model' => $model,
        ]);

    }

}
