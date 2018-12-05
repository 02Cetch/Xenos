<?php
/**
 * Created by PhpStorm.
 * User: 55555
 * Date: 05.12.2018
 * Time: 12:22
 */

namespace console\controllers;
use frontend\modules\notifications\models\Notifications;

class NotificationDeletionController extends \yii\console\Controller
{
    /**
     * консольная команда для удаления уведомлений
     * старше 30 дней
     *
     * можно запускать в Cron
     *
     * Каждое воскресенье:
     *  0 0 * * 7  php /var/www/project/yii notification-deletion/delete

     */
    public function actionDelete(){
        //количество прошедших дней, за которые не удалять записи

        $days = 30;
        $date = time() - $days * 24 * 60 * 60;
//        $date = date('Y-m-d', $seconds);

        $model = new Notifications();

        if($model->deleteNotifications($date)) {
            echo 'Success';
            return true;
        }
        echo 'Error';
        return false;
    }
}