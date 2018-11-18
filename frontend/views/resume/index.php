<?php
/* @var $this yii\web\View */
/* @var $resumes array */
/* @var $pagination \yii\data\Pagination */
use yii\widgets\LinkPager;

$this->title = 'Resume | Xenos';
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
                    <?php foreach ($resumes as $resume): ?>
                    <div class="content__item">
                        <div class="content__item__wrapper">
                            <h2 class="content__title"><a href="/resume/view/<?php echo $resume->id ?>"><?php echo $resume->title ?></a></h2>
                            <h3 class="payday"><span><?php echo $resume->salary ?>$/month</span></h3>
                        </div>
                        <p class="user__experiense">Experience: <br>  <?php echo $resume->experience ?> years</p>
                        <p class="user__createtime"><i class="pe pe-7s-clock"></i> <?php echo Yii::$app->formatter->asDateTime($resume->created_at, 'php:Y-m-d H:i:s') ?></p>
                        <p class="user__descr">
                            <?php echo $resume->description ?>
                        </p>
                    </div>
                        <?php endforeach; ?>
                </div>
                <section class="pagination">
                    <?= LinkPager::widget(['pagination' => $pagination, 'options' => ['class' => 'pagination__list'],]) ?>
                </section>
        </div>
    </div>
</section>
