<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login | Xenos';
$this->params['breadcrumbs'][] = $this->title;
?>
</header>
<section class="login__form">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="input_container">
                    <div class="formHeading">Signup</div>

                    <?php $form = ActiveForm::begin(['options' => [
                        'class'=> 'loginForm',
                        'id' => 'form-signup',
                    ]]); ?>

                    <p class="form__input__title">E-mail</p>
                    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'class' => 'inputs'])->label(false) ?>

                    <p class="form__input__title">Password</p>
                    <?= $form->field($model, 'password')->passwordInput()->label(false) ?>
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <br>
                    <div style="color:#999;margin:1em 0">
                        If you forgot your password you can <?= Html::a('reset it', ['/user/default/request-password-reset']) ?>.
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'button__to accent button__sumbit', 'name' => 'signup-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
</section>