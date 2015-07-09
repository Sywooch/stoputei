<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = Yii::t('app','Login');
$this->params['breadcrumbs'][] = $this->title;
$verify_success = Yii::$app->request->get('verify_success', null);
?>
<div class="bg-wrap">
    <img src="/images/bg-login.jpg">
</div>
<div class="site-login">
    <h1 class="col-xs-offset-1"><?= Yii::t('app','Login');?></h1>

    <p class="col-xs-offset-1"><?=Yii::t('app','Please fill out the following fields to login');?>:</p>

    <?php if(!empty($verify_code)):?>
        <p class="col-xs-offset-1 error-field"><?=Yii::t('app', 'You have not verify your account.');?></p>
    <?php endif;?>

    <?php if(!empty($not_approved)):?>
        <p class="col-xs-offset-1 error-field"><?=Yii::t('app', 'Your account has been not approved by Administration.');?></p>
    <?php endif;?>

    <?php if(!empty($verify_success)):?>
        <p class="col-xs-offset-1 success-field"><?=Yii::t('app', 'Now you can log in into your account.');?></p>
    <?php endif;?>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-10 col-xs-offset-1\">{input}</div>\n<div class=\"col-xs-10 col-xs-offset-1\">{error}</div>",
            'labelOptions' => ['class' => 'col-xs-10 col-xs-offset-1 control-label label-login'],
        ],
    ]); ?>

    <?= $form->field($model, 'email')->input('email', ['autofocus' => 'true', 'placeholder' => 'me@mail.com']) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe', [
        'template' => "<div class=\"col-xs-10 col-xs-offset-1\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ])->checkbox() ?>

    <div class="form-group">
        <div class="col-xs-10 col-xs-offset-1">
            <?= Html::submitButton(Yii::t('app','Login'), ['class' => 'btn btn-primary col-xs-6', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="col-xs-offset-1">
        <span class="switch"><?=Yii::t('app', 'Don\'t have an account?');?></span><a class="switch-link" href="<?= Url::to(['site/registration']);?>"><?= Yii::t('app','Sign up');?></a>
    </div>
</div>
