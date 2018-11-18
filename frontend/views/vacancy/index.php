<?php
/* @var $this yii\web\View */
use yii\widgets\LinkPager;
$this->title = 'Vacancy | Xenos';
?>
</header>
<section class="search">
    <div class="conteiner">
        <div class="row">
            <div class="col-md-2 col-md-offset-9">
                <div class="searchInput">
                    <input type="search" placeholder="Search...">
                    <span class="fa fa-search"></span>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content resumes">
    <div class="container">
        <div class="row">
            <div class="col-md-11">
                <div class="content__items">
                    <?php foreach ($vacancies as $vacancy): ?>
                    <div class="content__item">
                        <div class="content__item__wrapper">
                            <h2 class="content__title"><a href="<?php echo "/vacancy/view/$vacancy->id" ?>"><?php echo $vacancy->title ?></a></h2>
                            <h3 class="payday"><span><?php echo $vacancy->salary ?>$/month</span></h3>
                        </div>
                        <p class="user__experiense">Experience: <br>  <?php echo $vacancy->experience ?> years</p>
                        <p class="user__createtime"><i class="pe pe-7s-clock"></i> <?php echo Yii::$app->formatter->asDateTime($vacancy->created_at, 'php:Y-m-d H:i:s') ?></p>

                        <p class="user__descr">
                            <?php echo $vacancy->description ?>
                        </p>
                    </div>
                        <?php endforeach; ?>
                </div>
                <section class="pagination">
                    <?= LinkPager::widget(['pagination' => $pagination, 'options' => ['class' => 'pagination__list'],]) ?>
                </section>
            </div>
        </div>
    </div>
</section>
</div>