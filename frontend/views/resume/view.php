<?php
 /* @var $resume \frontend\models\Resume */
 /* @var $userData \frontend\models\User */
 /* @var $currentUser \frontend\models\User */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $resume->title;
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
                            <h1 class="user__profile__container__fullname"><?php echo $userData->username; ?></h1>
                        <?php endif; ?>

                        <?php if($userData->years): ?>
                            <p class="user__profile__container__age"><?php echo $userData->years; ?> years</p>
                        <?php endif; ?>
                        <p class="user__profile__container__minimum_salary">Minimum Salary: <?php echo $resume->salary ?>$</p>
                        <p class="user__createtime"><i class="pe pe-7s-clock"></i> <?php echo Yii::$app->formatter->asDateTime($resume->created_at, 'php:Y-m-d H:i:s') ?></p>
                        <?php if($userData->description):?>
                        <br>
                        <p class="user__profile__container__descr">
                            <?php echo $resume->description ?>
                        </p>
                        <?php endif; ?>

                        <?php if($resume || !$resume->isUserResume($currentUser)): ?>
                        <div class="user__profile__container__actions">
                            <a href="#" class="user__profile__container__contact button__to accent">Contact</a>
                            <a href="#" class="user__profile__container__report button__to grey reverse">Report</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
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