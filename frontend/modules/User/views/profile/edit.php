<?php
    /* @var $currentUser \frontend\models\User */
    /* @var $model \frontend\modules\User\models\EditForm */
    /* @var $modelPicture \frontend\modules\user\models\forms\PictureForm */

    use dosamigos\fileupload\FileUpload;
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;

    $this->title = "Account Settings | Xenos";
?>
</header>
<section class="login__form">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="formHeading">Edit Profile </div>
                    <?php $form = ActiveForm::begin(
                        ['options' => [
//                        'enableAjaxValidation' => true,
                        'class'=> 'loginForm',
                        'id' => 'form-edit',
                        ]]); ?>

                    <p class="form__input__title">E-mail</p>
                    <?= $form->field($model, 'email')->textInput(['value' => $currentUser->email, 'class' => 'inputs'])->label(false) ?>
                    <?php if($currentUser->isUser()): ?>
                    <br>
                    <p class="form__input__title">Full Name</p>
                    <?= $form->field($model, 'full_name')->textInput(['value' => Html::encode($currentUser->full_name),'class' => 'inputs'])->label(false) ?>
                    <br>
                    <br>
                    <p class="form__input__title">Years</p>
                    <?= $form->field($model, 'years')->textInput(['value' => Html::encode($currentUser->years),'class' => 'inputs'])->label(false) ?>
                    <?php endif; ?>
                    <br>
                    <p class="form__input__title">Photo</p>
                    <?=
                    FileUpload::widget([
                        'model' => $modelPicture,
                        'attribute' => 'picture',
                        'url' => ['/user/profile/upload-picture'], // your url, this is just for demo purposes,
                        'options' => ['accept' => 'image/*'],
                        'clientEvents' => [
                            'fileuploaddone' => 'function(e, data) {
                                                        if (data.result.success) {
                                                            $("#profile-image-success").show();
                                                            $("#profile-image-fail").hide();
                                                            $("#profile-picture").attr("src", data.result.pictureUri);
                                                        } else {
                                                            $("#profile-image-fail").html(data.result.errors.picture).show();
                                                            $("#profile-image-success").hide();
                                                        }
                                                    }',
                        ],
                    ]);
                    ?>
                    <br>
                    <br>
                    <p class="form__input__title">Description</p>
                    <?= $form->field($model, 'description')->textarea(['value' => Html::encode($currentUser->description),'class' => 'inputs'])->label(false)?>
                    <br>
                    <p class="form__input__title">Phone</p>
                    <?= $form->field($model, 'phone')->textInput(['value' => Html::encode($currentUser->phone),'class' => 'inputs'])->label(false) ?>
                    <br>
                    <br>
                    <p class="form__input__title">Address</p>
                    <?= $form->field($model, 'address')->textInput(['value' => Html::encode($currentUser->address),'class' => 'inputs'])->label(false) ?>
                    <br>
                    <div class="form-group">
                        <?= Html::submitButton('Edit', ['class' => 'button__to accent button__sumbit', 'name' => 'signup-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>
