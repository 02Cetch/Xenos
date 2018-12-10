<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User List | Xenos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            [
                'attribute' => 'account_type',
                'format' => 'raw',
                'value' => function($user) {
                    return $user->isCompany($user->account_type) ? 'COMPANY' : 'USER';
                }
            ],
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            //'status',
            //'nickname:ntext',
            //'full_name:ntext',
            //'phone:ntext',
            //'address:ntext',
            //'account_type',
            //'years',
            //'description:ntext',
            [
                'attribute' => 'filename',
                'format' => 'raw',
                'value' => function($user) {
                    return Html::img($user->getImage(), ['width' => '130px']);
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
//            'reports',

            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]); ?>
</div>
