<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\CustomMailer;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = Yii::t('app','Restore password');
?>

<div class="site-registration">
    <h1 class="col-xs-offset-1"><?= Yii::t('app','Restore password');?></h1>

    <?php if(!empty($success)):?>
        <p class="col-xs-offset-1"><?=Yii::t('app','Checkout your email to reset tour password');?></p>
    <?php else:?>
    <p class="col-xs-offset-1"><?=Yii::t('app','We will send you instructions about restore password on email which you enter bellow');?>:</p>

        <?php $form = ActiveForm::begin([
            'id' => 'email-reset-password-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-xs-10 col-xs-offset-1\">{input}</div>\n<div class=\"col-xs-10 col-xs-offset-1\">{error}</div>",
                'labelOptions' => ['class' => 'col-xs-10 col-xs-offset-1 control-label label-login'],
            ],
        ]); ?>

        <?= $form->field($model, 'email'); ?>

        <div class="form-group">
            <div class="col-xs-10 col-xs-offset-1">
                <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'btn btn-primary col-xs-12', 'name' => 'email-reset-password-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    <?php endif;?>
</div>
