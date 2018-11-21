<?php

namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use frontend\models\Resume;
use frontend\models\User;
use frontend\models\forms\SearchForm;
use yii\data\ActiveDataProvider;

/**
 * Class ReportController
 * @package frontend\controllers
 *
 * Контроллер для репортов записей
 */
class ReportController extends \yii\web\Controller
{

    /**
     * @param $id
     * @return string
     *
     * Report profile action
     */
    public function actionReportProfile($id)
    {
        return $this->render('report-profile');
    }

    /**
     * @param $id
     * @return string
     *
     * Report resume action
     */
    public function actionReportResume($id)
    {
        return $this->render('report-resume');
    }

    /**
     * @param $id
     * @return string
     *
     * Report vacancy action
     */
    public function actionReportVacancy($id)
    {
        return $this->render('report-vacancy');
    }


}
