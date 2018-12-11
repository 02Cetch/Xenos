<?php
    /* @var */

    use yii\widgets\ActiveForm;

    use yii\helpers\Html;

    $this->title = 'Create Vacancy | Xenos';
?>

</header>
<section class="login__form">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-6">
                <div class="formHeading">Create Vacancy</div>
                    <?php $form = ActiveForm::begin(
                        ['options' => [
                    //                        'enableAjaxValidation' => true,
                            'class'=> 'loginForm',
                            'id' => 'form-edit',
                        ]]); ?>

                    <p class="form__input__title">Position</p>
                    <?= $form->field($model, 'position')->textInput(['placeholder' => 'Senior Web Developer','class' => 'inputs'])->label(false) ?>
                    <br>
                    <br>
                    <p class="form__input__title">Salary <span class="hint">[$]</span></p>
                    <?= $form->field($model, 'salary')->textInput(['placeholder' => '3000', 'class' => 'inputs', 'id' => 'salary'])->label(false)?>
                    <br>
                    <br>
                    <p class="form__input__title">Working Experience <span class="hint">[years]</span></p>
                    <?= $form->field($model, 'experience')->textInput(['placeholder' => '5', 'class' => 'inputs', 'id' => 'experience'])->label(false)?>
                    <br>
                    <br>
                    <p class="form__input__title">Description</p>
                    <?= $form->field($model, 'description')->textarea(['class' => 'inputs'])->label(false)?>
                    <br>
                    <br>
                    <p class="form__input__title">Job Responsibilities</p>
                    <?= $form->field($model, 'responsibilities')->textarea(['placeholder' => '-...','class' => 'inputs', 'id' => 'responsibilities'])->label(false)?>
                    <br>
                    <br>
                    <p class="form__input__title">We offer</p>
                    <?= $form->field($model, 'offer')->textarea(['placeholder' => '-...','class' => 'inputs', 'id' => 'offer'])->label(false)?>
                    <br>
                    <br>


                <div class="form-group">
                        <?= Html::submitButton('Create', ['class' => 'button__to accent button__sumbit', 'name' => 'signup-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>