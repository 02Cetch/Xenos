<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
$user = Yii::$app->user->identity;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<body>
<body>
<div id="my-page">
    <header>
        <nav class="navbar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="navbar__wrap">
                            <div class="navbar__brand">
                                <label for="">
                                    <span class="navbar__brand__title">Xenos</span>
                                </label>
                            </div>
                            <div class="navbar__wrap__list">
                                <?php
                                    $menuItems = [
                                        ['label' => 'Home', 'url' => ['/site/index'],'options'=>['class'=>'navbar__list__item']],
                                        ['label' => 'Vacancy', 'url' => ['/vacancy/index'],'options'=>['class'=>'navbar__list__item']],
                                        ['label' => 'Resume', 'url' => ['/resume/index'],'options'=>['class'=>'navbar__list__item']],
                                    ];
                                    if (Yii::$app->user->isGuest) {
                                        $menuItems[] = ['label' =>  'Signup', 'url' => [Url::to(['/user/default/signup'])],'options'=>['class'=>'navbar__list__item'] ];
                                        $menuItems[] = ['label' => 'Login', 'url' => [Url::to(['/user/default/login'])],'options'=>['class'=>'navbar__list__item']];
                                    } else {
                                        $menuItems[] = ['label' => 'My page','options'=>['class'=>'navbar__list__item'], 'url' => [Url::to(['/user/profile/view/']), 'id' => Yii::$app->user->identity->getId()]];
                                        $menuItems[] = ['label' => $user->isUser() ? 'Create Resume' : 'Create Vacancy' , 'url' => [$user->isUser() ? '/create-resume/index' : '/create-vacancy/index'],'options'=>['class'=>'navbar__list__item']];
                                        $menuItems[] = '<a href="/notifications/default" class="fa fa-bell">'
                                            . Html::beginTag('div', ['class' => 'notifications__count'])
                                                . Html::beginTag('span', ['class' => 'notifications__count__value'])
                                                    . '9+'
                                                .Html::endTag('span')
                                            .Html::endTag('div')
                                            . '</a>';

                                        $menuItems[] = '<li class="navbar__list__item">'
                                            . Html::beginForm([Url::to(['/user/default/logout'])], 'post')
                                            . Html::submitButton(
                                                'Logout' . '(' . Yii::$app->user->identity->username . ')  </i>',
                                                ['class' => 'navbar__list__item__logout']
                                            )
                                            . Html::endForm()
                                            . '</li>';
                                    }
                                    echo Nav::widget([
                                        'options' => ['class' => 'navbar__list'],
                                        'items' => $menuItems,
                                    ]);
                                ?>
                                <a href="#my-menu" class="hamburger hamburger--emphatic">
                                    <span class="hamburger-box"><span class="hamburger-inner"></span></span>
                                </a>
                                <nav id="my-menu">
                                    <?php
                                    $menuItems = [
                                        ['label' => 'Home', 'url' => ['/site/index'],'options'=>['class'=>'navbar__list__item']],
                                        ['label' => 'Vacancy', 'url' => ['/vacancy/index'],'options'=>['class'=>'navbar__list__item']],
                                        ['label' => 'Resume', 'url' => ['/resume/index'],'options'=>['class'=>'navbar__list__item']],
                                    ];
                                    if (Yii::$app->user->isGuest) {
                                        $menuItems[] = ['label' =>  'Signup', 'url' => [Url::to(['/user/default/signup'])],'options'=>['class'=>'navbar__list__item'] ];
                                        $menuItems[] = ['label' => 'Login', 'url' => [Url::to(['/user/default/login'])],'options'=>['class'=>'navbar__list__item']];
                                    } else {
                                        $menuItems[] = ['label' => 'My page','options'=>['class'=>'navbar__list__item'], 'url' => [Url::to(['/user/profile/view/']), 'id' => Yii::$app->user->identity->getId()]];
                                        $menuItems[] = ['label' => $user->isUser() ? 'Create Resume' : 'Create Vacancy' , 'url' => [$user->isUser() ? '/create-resume/index' : '/create-vacancy/index'],'options'=>['class'=>'navbar__list__item']];

                                        $menuItems[] = '<li class="navbar__list__item">'
                                            . Html::beginForm([Url::to(['/user/default/logout'])], 'post')
                                            . Html::submitButton(
                                                'Logout' . '(' . Yii::$app->user->identity->username . ')  </i>',
                                                ['class' => 'navbar__list__item__logout']
                                            )
                                            . Html::endForm()
                                            . '</li>';
                                    }
                                    echo Nav::widget([
                                        'options' => ['class' => ''],
                                        'items' => $menuItems,
                                    ]);
                                    ?>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <?= Alert::widget() ?>
        <?= $content ?>
</div>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="footer__wrapper">
                    <span class="footer__title">Xenos, Inc.</span>
                    <p class="footer_descr">© 2018 Xenos. All rights reserved.</p>
                    <p>Developed by Cetch.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--<div class="preloader__wrapper">-->
<!--    <div class="loading">-->
<!--        <div class="bounceball"></div>-->
<!--        <div class="text">LOADING</div>-->
<!--    </div>-->
<!--</div>-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

