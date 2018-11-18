<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup | Xenos';
$this->params['breadcrumbs'][] = $this->title;
?>
</header>
<section class="login__form">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    <div class="input_container">
                        <div class="formHeading">Signup</div>

                        <?php $form = ActiveForm::begin([
                            'options' => [
                                'class'=> 'loginForm',
                                'id' => 'form-signup',
                        ]]); ?>

                        <p class="form__input__title">E-mail</p>
                        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'class' => 'inputs'])->label(false) ?>

                        <p class="form__input__title">Nickname/Company</p>
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'inputs'])->label(false) ?>

                        <p class="form__input__title">Password</p>
                        <?= $form->field($model, 'password')->passwordInput()->label(false) ?>

                        <label><?= $form->field($model,'account_type')->radioList( ['1'=>'Searching Job', '2'=>'Company'], array('separator'=>' ')) ?></label>
                        <br>
                        <div class="form-group">
                            <?= Html::submitButton('Sign Up', ['class' => 'button__to accent button__sumbit', 'name' => 'signup-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
            </div>
        </div>
    </div>
</section>
