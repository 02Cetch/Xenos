<?php
/**
 * Created by PhpStorm.
 * User: 55555
 * Date: 03.12.2018
 * Time: 16:21
 */

namespace frontend\modules\notifications\controllers;


use frontend\models\User;
use Yii;
use yii\web\Response;
use frontend\modules\notifications\models\Notifications;
use yii\web\Controller;

/**
 * Create controller for the `notifications` module
 */
class CreateController extends Controller
{

    /**
     * @return string
     *
     * notifications/create/type-liked-resume-by-company
     */
    public function actionTypeLikedResumeByCompany()
    {
        if(Yii::$app->user->isGuest) {
            return $this->redirect(['/user/login']);
        }
        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        $model = new Notifications();

        $user = new User();

        Yii::$app->response->format = Response::FORMAT_JSON;

        $senderId = $currentUser->getId();
        $resumeId = Yii::$app->request->post('resumeId');
        $receiverId = $user->getUserByResumeId($resumeId);

        if($currentUser->isCompany() && $model->createNotification($senderId, $receiverId, $resumeId, $type = Notifications::getTypeLikedResumeByCompany())) {
            return [
                'success' => true,
                'text' => 'Success',
            ];
        }
        return [
            'success' => false,
            'text' => 'Error',
        ];
    }
}