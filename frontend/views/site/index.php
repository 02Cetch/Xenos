<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
$this->title = 'Home | Xenos';
?>
<section class="view">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="view__column">
                    <div class="view__column__wrapper">
                        <h1 class="title">Resume</h1>
                        <p class="title__descr">
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsam,
                            blanditiis odit laudantium eum deserunt error vitae doloremque nam optio itaque reprehenderit,
                        </p>
                        <a href="<?php echo Url::to(['/resume/index']); ?>" class="button__to accent">See All</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="view__column">
                    <div class="view__column__wrapper">
                        <h1 class="title">Vacancy</h1>
                        <p class="title__descr">
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsam,
                            blanditiis odit laudantium eum deserunt error vitae doloremque nam optio itaque reprehenderit,
                        </p>
                        <a href="<?php echo Url::to(['/vacancy/index']); ?>" class="button__to grey">See All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</header>
<section class="services">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="services__item">
                    <div class="pe pe-7s-diamond"></div>
                    <h3 class="services__item__title">UI/UX Designers</h3>
                    <p class="services__item__descr">Be set fourth land god darkness make it wherein own</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="services__item">
                    <div class="pe pe-7s-arc"></div>
                    <h3 class="services__item__title">Web Developers</h3>
                    <p class="services__item__descr">A she'd them bring void moving third she'd kind fill</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="services__item">
                    <div class="pe pe-7s-phone"></div>
                    <h3 class="services__item__title">App / Mobile</h3>
                    <p class="services__item__descr">Dominion man second spirit he, earth they're creeping</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="services__item">
                    <div class="pe pe-7s-joy"></div>
                    <h3 class="services__item__title">Game Dev</h3>
                    <p class="services__item__descr">Morning his saying moveth it multiply appear life be</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="services__item">
                    <div class="pe pe-7s-plane"></div>
                    <h3 class="services__item__title">SEO / Marketing</h3>
                    <p class="services__item__descr">Give won't after land fill creeping meat you, may</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="services__item">
                    <div class="pe pe-7s-star"></div>
                    <h3 class="services__item__title">Photography</h3>
                    <p class="services__item__descr">Creepeth one seas cattle grass give moving saw give</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="services__item">
                    <div class="pe pe-7s-magic-wand"></div>
                    <h3 class="services__item__title">Graphic Designers</h3>
                    <p class="services__item__descr">Open, great whales air rule for, fourth life whales</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="services__item">
                    <div class="pe pe-7s-paint-bucket"></div>
                    <h3 class="services__item__title">Illustrators</h3>
                    <p class="services__item__descr">Whales likeness hath, man kind for them air two won't</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="register">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="title">Sign Up Now</h1>
                <a href="#" class="button__to accent reverse">Sign Up</a>
            </div>
        </div>
    </div>
</section>
