<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\resume */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Resumes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-view">

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
            'user_id',
            'title',
            'salary',
            'experience',
            'description:ntext',
            'working_experience:ntext',
            'created_at:datetime',
            'updated_at:datetime',
            'reports',
        ],
    ]) ?>

</div>
