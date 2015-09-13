<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = Yii::t('app', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <div class="col-xs-12">
        <h1 class="col-xs-6 col-xs-offset-2"><?= Html::encode($this->title) ?></h1>

        <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="col-xs-6 col-xs-offset-2 alert alert-success">
            <?= Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible.');?>
        </div>
        <div class="col-xs-6 col-xs-offset-2">
            <?= Html::a(Yii::t('app', 'Submit one more mail'), Url::toRoute(['/site/contact']), ['class' => 'btn btn-success col-xs-5', 'name' => 'contact-button']) ?>
            <?= Html::a(Yii::t('app','Back to main page'), Url::toRoute(['/']), ['class' => 'btn btn-info col-xs-5 pull-right']);?>
        </div>

        <?php else: ?>

        <p class="col-xs-6 col-xs-offset-2">
            <?= Yii::t('app', 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.');?>
        </p>
                <?php $form = ActiveForm::begin([
                    'id' => 'contact-form',
                    'action' => Url::toRoute(['/site/contact']),
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-xs-6 col-xs-offset-2 \">{input}</div>\n<div class=\"col-xs-6 col-xs-offset-2\">{error}</div>",
                        'labelOptions' => ['class' => 'col-xs-6 col-xs-offset-2 control-label label-contact'],
                    ],
                ]); ?>

                    <?= $form->field($model, 'name') ?>
                    <?= $form->field($model, 'email') ?>
                    <?= $form->field($model, 'subject') ?>
                    <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>
                    <div class="form-group buttons-action">
                        <div class="col-xs-6 col-xs-offset-2">
                            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success col-xs-5', 'name' => 'contact-button']) ?>
                            <?= Html::a(Yii::t('app','Back to main page'), Url::toRoute(['/']), ['class' => 'btn btn-info col-xs-5 pull-right']);?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
        <?php endif; ?>
    </div>
</div>
