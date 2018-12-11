<?php
/* @var $resume \frontend\models\Resume */
/* @var $userData \frontend\models\User */
/* @var $currentUser \frontend\models\User */

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\web\JqueryAsset;

$this->title = $resume->title . " | Xenos";

AppAsset::register($this);

$this->registerJsFile('@web/js/reports.js', [
    'depends' => JqueryAsset::className(),
]);
$this->registerJsFile('@web/js/deletion.js', [
    'depends' => JqueryAsset::className(),
]);

$this->registerJsFile('@web/js/notification.js', [
    'depends' => JqueryAsset::className(),
]);

?>

</header>
<section class="user__profile">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="user__profile__container">
                    <div class="user__profile__container__info no_margin_left">
                        <?php if($userData->full_name): ?>
                            <h1 class="user__profile__container__fullname"><a href="<?php echo Url::to(['/user/profile/view', 'id' => $userData->id]) ?>"><?php echo $userData->full_name; ?></a></h1>
                        <?php elseif ($userData->username):?>
                            <h1 class="user__profile__container__fullname"><a href="<?php echo Url::to(['/user/profile/view', 'id' => $userData->id]) ?>"><?php echo $userData->username; ?></a></h1>
                        <?php endif; ?>

                        <?php if($userData->years): ?>
                            <p class="user__profile__container__age"><?php echo $userData->years; ?> years</p>
                        <?php endif; ?>
                        <p class="user__profile__container__minimum_salary">Minimum Salary: <?php echo $resume->salary ?>$</p>
                        <p class="user__createtime"><i class="pe pe-7s-clock"></i> <?php echo Yii::$app->formatter->asDateTime($resume->created_at, 'php:Y-m-d H:i:s') ?></p>
                        <?php if($userData->description):?>
                            <br>
                            <p class="user__profile__container__descr">
                                <?php echo $userData->description ?>
                            </p>
                        <?php endif; ?>

                        <?php if(!Yii::$app->user->isGuest): ?>
                            <?php if($resume || !$resume->isUserResume($currentUser)): ?>
                                <div class="user__profile__container__actions">
                                    <?php if($currentUser->isCompany()): ?>
                                        <?php if(!$notifications->isAlreadyNotify($currentUser->getId(), $resume->getId())): ?>
                                            <a href="#" class="user__profile__container__contact resume__report button__to accent" data-id="<?php echo $resume->id ?>"">Contact</a>
                                        <?php else: ?>
                                            <a href="#" class="user__profile__container__contact resume__report button__to accent disabled"">Success</a>
                                        <?php endif;?>
                                    <?php endif;?>
                                    <?php if($resume->user_id != $currentUser->getId()):?>
                                        <?php if(!$resume->isReported($currentUser)): ?>
                                            <a href="#" class="user__profile__container__report button__to grey reverse" data-id="<?php echo $resume->id ?>">Report</a>
                                        <?php else: ?>
                                            <a href="#" class="user__profile__container__report button__to grey reverse disabled" data-id="<?php echo $resume->id ?>">Resume has been reported</a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="#" class="resume__delete button__to red reverse" data-id="<?php echo $resume->id ?>">Delete</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="resume">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <br><br><br>
                <h1 class="resume__title"><?php echo $resume->title ?></h1>
                <h2 class="resume__title__description">Description:</h2>
                <p class="resume__description"><?php echo $resume->description ?></p>
                <br>
                <h2 class="resume__title__experience">Experience:</h2>
                <p class="resume__description"><?php echo $resume->experience ?> years</p>
            </div>
        </div>
    </div>
</section>
<section class="experiense">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="experiense__title">Working experiense:</h2>
                <p class="experiense__descr">
                    <?php echo Html::encode($resume->working_experience) ?>
                </p>
            </div>
        </div>
    </div>
</section>