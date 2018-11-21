<?php

namespace frontend\controllers;

use frontend\models\forms\CreateResumeForm;

use Yii;

/**
 * Class CreateResumeController
 * @package frontend\controllers
 *
 * Creating New Resume
 */
class CreateResumeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new CreateResumeForm();


        /* @var $currentUser frontend\models\User*/
        $currentUser = Yii::$app->user->identity;

        // if user account = company
        if($currentUser->isCompany()) {
            // redirected
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
