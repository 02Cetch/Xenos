<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Resume Reports | Xenos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'title',
            'salary',
            'experience',
//            'description:ntext',
//            'working_experience:ntext',
            'created_at:datetime',
            'updated_at:datetime',
            'reports',

            [
                'class' => 'yii\grid\ActionColumn',
                // обозначаем, какие кнопки нам нужны из стандартных
                // также добавляем свою кнопку "approve" (одобрить)
                // убирает все жалобы
                'template' => '&nbsp;{view}&nbsp;&nbsp;{approve}&nbsp;&nbsp;{delete}',
                'buttons' => [
                    'approve' => function($url, $post) {
                        return Html::a('<span class="glyphicon glyphicon-ok"> </span>', ['approve', 'id' => $post->id]);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
