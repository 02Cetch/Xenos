<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>

</header>
<section class="login__form">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="formHeading">Reset Password </div>
                <?php $form = ActiveForm::begin(
                    ['options' => [
                        'class'=> 'loginForm',
                        'id' => 'form-edit',
                    ]]); ?>

                <p class="form__input__title">E-mail</p>
                <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label(false) ?>

                <br>
                <br>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'button__to accent button__sumbit']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>

