<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\user */

$this->title = $model->username . ' ID:' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Approve', ['approve', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
//            'auth_key',
//            'password_hash',
            'password_reset_token',
            'email:email',
            'status',
            'created_at:datetime',
            'updated_at:datetime',
            'nickname:ntext',
            'full_name:ntext',
            'phone:ntext',
            'address:ntext',
            [
                'attribute' => 'account_type',
                'format' => 'raw',
                'value' => function($user) {
                    return $user->isCompany($user->account_type) ? 'COMPANY' : 'USER';
                }
            ],
            'years',
            'description:ntext',
            [
                'attribute' => 'filename',
                'format' => 'raw',
                'value' => function($user) {
                    return Html::img($user->getImage(), ['width' => '230px']);
                }
            ],
            'reports',
        ],
    ]) ?>

</div>
