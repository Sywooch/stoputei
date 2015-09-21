<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\CustomMailer;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = Yii::t('app','Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-registration">
    <h1 class="col-xs-offset-1"><?= Yii::t('app','Sign up');?></h1>

    <p class="col-xs-offset-1"><?=Yii::t('app','Please fill out the following fields to registration');?>:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'sign-up-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-10 col-xs-offset-1\">{input}</div>\n<div class=\"col-xs-10 col-xs-offset-1\">{error}</div>",
            'labelOptions' => ['class' => 'col-xs-10 col-xs-offset-1 control-label label-login'],
        ],
    ]); ?>

    <?= $form->field($model, 'email')->input('email', ['autofocus' => 'true', 'placeholder' => 'me@mail.com']) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'password_repeat')->passwordInput() ?>
    <?= $form->field($model, 'country')->dropDownList($dropdown,['prompt' => Yii::t('app','Choose country')]);?>
    <?= $form->field($model, 'region_id')->dropDownList([],['prompt' => Yii::t('app','Choose region')]);?>
    <?= $form->field($model, 'role')->radioList([1 => 'user', 2 => 'manager'],
        ['item' => function ($index, $label, $name, $checked, $value) {
        return '<label class="col-xs-6"><span class="radio-wrapper '.(($index==0)?'left':'right').'">'.(($index==0)?Yii::t('app', 'User'):Yii::t('app', 'Manager')).'<span class="icon glyphicon glyphicon-'.(($index==0)?'check':'unchecked').'"></span></span> ' .
        Html::radio($name, $checked, ['value' => $value]) . $label . '</label>';
    },]);?>
    <div class="user-radio">
        <?= $form->field($model, 'consent')->checkbox();?>
    </div>
    <div class="manager-radio hidden">
        <?= $form->field($model, 'company_name')->input('text',['placeholder' => Yii::t('app', 'Awesome company')]);?>
        <?= $form->field($model, 'company_city')->input('text',['placeholder' => Yii::t('app', 'City')]);?>
        <?= $form->field($model, 'company_phone')->input('text',['placeholder' => '(+380)-XXX-X-XXX '. Yii::t('app', 'or').' (+79)-XXX-X-XXX)']);?>
        <?= $form->field($model, 'company_address');?>
        <?= $form->field($model, 'company_street');?>
        <?= $form->field($model, 'company_underground');?>
    </div>

    <?= Html::a('', Url::toRoute(['site/get-city-dropdown']), ['class' => 'get-city-dropdown']);?>

    <div class="form-group">
        <div class="col-xs-10 col-xs-offset-1">
            <?= Html::submitButton(Yii::t('app','Sign up'), ['class' => 'btn btn-primary col-xs-6', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="col-xs-10 col-xs-offset-1">
        <span class="switch"><?=Yii::t('app', 'Already have account?');?></span><a class="switch-link" href="<?= Url::to(['site/login']);?>"><?= Yii::t('app','Login');?></a>
    </div>
</div>
