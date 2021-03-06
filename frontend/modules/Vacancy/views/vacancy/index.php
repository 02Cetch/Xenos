<?php
/* @var $this yii\web\View */
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use frontend\helpers\HighLightHelper;
use yii\helpers\Url;

$this->title = 'Vacancy | Xenos';
?>
</header>
<section class="search">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-10 col-sm-6 col-sm-offset-6">
                <div class="searchInput">
                    <?php $form = ActiveForm::begin(
                        ['options' => [
                            'class'=> 'loginForm',
                            'id' => 'form-edit',
                        ]]); ?>
                    <?= $form->field($model, 'keyword')->textInput(['type' => 'search', 'placeholder' => 'Search...','class' => 'inputs'])->label(false) ?>
                    <span class="fa fa-search"></span>
                </div>
                <?php ActiveForm::end(); ?>
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
                            <h2 class="content__title"><a href="<?php echo Url::to(['/vacancy/vacancy/view', 'id' => $vacancy['id']]); ?>"><?php echo HighLightHelper::process($keyword, $vacancy['title']) ?></a></h2>
                            <h3 class="payday"><span><?php echo HighLightHelper::process($keyword, $vacancy['salary']) ?>$/month</span></h3>
                        </div>
                        <p class="user__experiense">Experience: <br>  <?php echo HighLightHelper::process($keyword, $vacancy['experience']) ?> years</p>
                        <p class="user__createtime"><i class="pe pe-7s-clock"></i> <?php echo Yii::$app->formatter->asDateTime($vacancy['created_at'], 'php:Y-m-d H:i:s') ?></p>

                        <p class="user__descr">
                            <?php echo HighLightHelper::process($keyword, $vacancy['description']) ?>
                        </p>
                    </div>
                        <?php endforeach; ?>
                </div>
                <section class="pagination">
                    <?php if($pagination): ?>
                        <?= LinkPager::widget(['pagination' => $pagination, 'options' => ['class' => 'pagination__list'],]) ?>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>
</section>
</div>