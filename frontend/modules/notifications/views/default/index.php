<?php

    use yii\helpers\Url;
    $this->title = "Notifications | Xenos"
?>

</header>

<section class="notification__container">
    <div class="container">
        <div class="col-md-12">
            <div class="notifications">
                <?php foreach ($notifications as $notification):?>
                    <?php if ($notification->typeLikedResumeByCompany()):?>
                        <div class="notification__item <?= $notification->isSeenByUser() ? " seen" : '' ?>">
                            <div class="marker">
                                <div class="pe pe-7s-volume"></div>
                            </div>
                            <div class="notification__item__text">
                                <h3 class="notification__item__text__title">The company <a href="<?php echo Url::to(['/user/profile/view', 'id' => $model->getUserById($notification->sender_id)->id]); ?>"><?php echo $model->getUserById($notification->sender_id)->username; ?></a> liked your <a href="<?php echo Url::to(['/resume/view', 'id' => $notification->resume_id]); ?>">resume</a>.</h3>
                            </div>
                            <div class="date">
                                <i class="pe pe-7s-clock"></i>
                                <span class="datetime"><?php echo Yii::$app->formatter->asDateTime($notification->created_at, 'php:Y-m-d H:i:s') ?></span>
                            </div>
                        </div>
                        <?php elseif ($notification->typeUpdateUserData()):?>
                            <div class="notification__item <?= $notification->isSeenByUser() ? " seen" : '' ?>">
                                <div class="marker">
                                    <div class="pe pe-7s-shield"></div>
                                </div>
                                <div class="notification__item__text">
                                    <h3 class="notification__item__text__title">You reset the password</h3>
                                </div>
                                <div class="date">
                                    <i class="pe pe-7s-clock"></i>
                                    <span class="datetime"><?php echo Yii::$app->formatter->asDateTime($notification->created_at, 'php:Y-m-d H:i:s') ?></span>
                                </div>
                            </div>
                        <?php elseif ($notification->typeResetPassword()):?>
                            <div class="notification__item <?= $notification->isSeenByUser() ? " seen" : '' ?>">
                                <div class="marker">
                                    <div class="pe pe-7s-pen"></div>
                                </div>
                                <div class="notification__item__text">
                                    <h3 class="notification__item__text__title">You have updated your account details.</h3>
                                </div>
                                <div class="date">
                                    <i class="pe pe-7s-clock"></i>
                                    <span class="datetime"><?php echo Yii::$app->formatter->asDateTime($notification->created_at, 'php:Y-m-d H:i:s') ?></span>
                                </div>
                            </div>
                    <?php endif;?>
                    <?php $notification->setSeenByUser(); ?>
                <?php endforeach; ?>

<!--                <div class="notification__item seen">-->
<!--                    <div class="marker">-->
<!--                        <div class="pe pe-7s-shield"></div>-->
<!--                    </div>-->
<!--                    <div class="notification__item__text">-->
<!--                        <h3 class="notification__item__text__title">You reset the password</h3>-->
<!--                    </div>-->
<!--                    <div class="date">-->
<!--                        <i class="pe pe-7s-clock"></i>-->
<!--                        <span class="datetime">30 nov 2018 15:30</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="notification__item seen">-->
<!--                    <div class="marker">-->
<!--                        <div class="pe pe-7s-pen"></div>-->
<!--                    </div>-->
<!--                    <div class="notification__item__text">-->
<!--                        <h3 class="notification__item__text__title">You have updated your account details.</h3>-->
<!--                    </div>-->
<!--                    <div class="date">-->
<!--                        <i class="pe pe-7s-clock"></i>-->
<!--                        <span class="datetime">30 nov 2018 15:30</span>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</section>
