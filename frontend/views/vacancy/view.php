<?php
    /* @var $resume \frontend\models\Resume; */
    /* @var $userData array */
    /* @var $user \frontend\models\User */
    /* @var $currentUser \frontend\models\User */

    use yii\helpers\Html;
    use yii\helpers\Url;

    $this->title = $vacancy->title;
?>


</header>

<?php if(!$vacancy): ?>
    <h3 class="title">
        Not Found
    </h3>
<?php else: ?>
    <section class="vacancy">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="vacancy__title"><?php echo $vacancy->title ?></h1>
                    <?php if($vacancy || !$vacancy->isUserVacancy($currentUser)): ?>
                        <a href="#" class="vacancy__contact button__to accent">Contact</a>
                    <?php endif; ?>
                    <p class="vacancy__payday"><?php echo $vacancy->salary ?>$/month</p>
                    <p class="user__createtime"><i class="pe pe-7s-clock"></i> <?php echo Yii::$app->formatter->asDateTime($vacancy->created_at, 'php:Y-m-d H:i:s') ?></p>
                    <p class="vacancy__company"><a href="<?php echo Url::to(['/user/profile/view/', 'id' => $userData->id]) ?>"><?php echo $userData->username ?></a></p>
                    <?php if($vacancy || !$vacancy->isUserVacancy($currentUser)): ?>
                        <a href="#" class="vacancy__report button__to grey reverse">Report</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="responsibilities">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="responsibilities__title">Job Responsibilities:</h2>
                    <ul class="responsibilities__items">
                        <li class="responsibilities__item"><?php echo Html::encode($vacancy->nl2br2($vacancy->responsibilities)) ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="offer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="offer__title">We offer :</h2>
                    <div class="offer__items">
                        <p class="offer__item"><?php echo Html::encode($vacancy->nl2br2($vacancy->offer)) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>