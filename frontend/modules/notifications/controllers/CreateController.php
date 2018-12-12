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
     * Типы уведомлений
     *
     * self::NOTIFICATION_TYPE_LIKED_RESUME_BY_COMPANY тип уведомлений,
     * при котором пользователь оповещается об отклике на его резюме
     *
     * self::NOTIFICATION_TYPE_UPDATE_USER_DATA тип уведомлений,
     * при котором пользователь оповещается о смене данных его аккаунта
     *
     * self::NOTIFICATION_TYPE_RESET_PASSWORD тип уведомлений,
     * при котором пользователь оповещается о смене пароля
     */
    const NOTIFICATION_TYPE_LIKED_RESUME_BY_COMPANY = 1;
    const NOTIFICATION_TYPE_UPDATE_USER_DATA = 2;
    const NOTIFICATION_TYPE_RESET_PASSWORD = 3;


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

        if($currentUser->isCompany() && $model->createNotification($senderId, $receiverId, $resumeId, $type = self::NOTIFICATION_TYPE_LIKED_RESUME_BY_COMPANY)) {
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