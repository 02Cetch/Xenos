<?php
 /* @var $userPosts array*/
    use yii\helpers\Html;
    $this->title = "$user->username | Xenos";
?>
</header>
<section class="user__profile">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="user__profile__container">
                    <?php if($user->isUserById($user->id)):?>
                        <img src="<?php echo $user->picture ? Yii::$app->storage->getFile($user->picture) : '/images/avatar.png' ?>" alt="nickname" class="user__profile__avatar">
                    <?php elseif($user->isCompanyById($user->id)):?>
                        <img src="<?php echo $user->picture ? Yii::$app->storage->getFile($user->picture) : '/images/company_logo.png' ?>" alt="nickname" class="user__profile__avatar">
                    <?php endif; ?>
                    <div class="user__profile__container__info">
                        <?php if($user->full_name): ?>
                            <h1 class="user__profile__container__fullname"><?php echo $user->full_name ?></h1>
                        <?php elseif ($user->username): ?>
                            <h1 class="user__profile__container__fullname"><?php echo Html::encode($user->username) ?></h1>
                        <?php endif; ?>
                        <?php if($user->years): ?>
                            <p class="user__profile__container__age"><?php echo Html::encode($user->years) ?> years</p>
                        <?php endif; ?>
                        <?php if($user->description): ?>
                        <br>
                        <p class="user__profile__container__descr">
                            <?php echo Html::encode($user->description); ?>
                        </p>
                        <?php endif; ?>
                        <br>

                        <?php if($currentUser && $currentUser->equals($user)): ?>
                        <a href="<?php echo \yii\helpers\Url::to(['/user/profile/edit'])?>" class="user__profile__container__edit button__to accent">Edit Profile</a>
                        <?php endif; ?>
                        <a href="#" class="user__profile__container__report button__to grey reverse">Report Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="user__resumes">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <?php if($user->isUserById($user->id)): ?>
                    <h2 class="user__resumes__title">Resumes:</h2>
                    <br>
                    <?php if($userPosts) :?>
                        <?php foreach ($userPosts as $item):?>
                        <p><a href="<?php echo \yii\helpers\Url::to(['/resume/view/', 'id' => $item['id']])?>" class="user__resumes__item"><?php echo $item['title'] ?></a></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php else: ?>
                    <h2 class="user__resumes__title">Vacancies:</h2>
                    <br>
                    <?php if($userPosts) :?>
                        <?php foreach ($userPosts as $item):?>
                            <p><a href="<?php echo \yii\helpers\Url::to(['/vacancy/view/', 'id' => $item['id']])?>" class="user__resumes__item"><?php echo $item['title'] ?></a></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
//FileUpload::widget([
//    'model' => $modelPicture,
//    'attribute' => 'picture',
//    'url' => ['/user/profile/upload-picture'], // your url, this is just for demo purposes,
//    'options' => ['accept' => 'image/*'],
//    'clientEvents' => [
//        'fileuploaddone' => 'function(e, data) {
//                                    if (data.result.success) {
//                                        $("#profile-image-success").show();
//                                        $("#profile-image-fail").hide();
//                                        $("#profile-picture").attr("src", data.result.pictureUri);
//                                    } else {
//                                        $("#profile-image-fail").html(data.result.errors.picture).show();
//                                        $("#profile-image-success").hide();
//                                    }
//                                }',
//    ],
//]);
//?>