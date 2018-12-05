<?php

namespace frontend\modules\notifications\controllers;

use Yii;
use frontend\models\User;
use frontend\modules\notifications\models\Notifications;
use yii\web\Controller;

/**
 * Default controller for the `notifications` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        /* @var $currentUser User */
        $currentUser = \Yii::$app->user->identity;

        $model = new Notifications();

        $notifications = $model->getNotifications($currentUser);


        return $this->render('index', [
            'model' => $model,
            'notifications' => $notifications,
        ]);
    }
}
