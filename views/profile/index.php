<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Alert;
?>
<div class="row">
    <div class="col-xs-12 profile edit">
        <div class="col-xs-6 col-xs-offset-2  col-sm-6 col-sm-offset-2 title">
            <h1><?=Yii::t('app', 'Edit account information')?></h1>
        </div>
        <?php if(Yii::$app->session->getFlash('success')): ?>
                <?= Alert::widget([
                    'options' => [
                        'class' => 'col-xs-6 col-xs-offset-2  col-sm-6 col-sm-offset-2 alert-info',
                    ],
                    'body' => Yii::t('app', 'Profile information has been changed successful.'),
                ]);
                ?>
        <?php endif;?>

        <?php $form = ActiveForm::begin([
            'id' => 'edit-profile-form',
            'enableClientValidation' => true,
            'action' => Url::toRoute(['profile/index']),
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-xs-6 col-xs-offset-2  col-sm-6 col-sm-offset-2\">{input}</div>\n<div class=\"col-xs-6 col-xs-offset-2  col-sm-6 col-sm-offset-2\">{error}</div>",
                'labelOptions' => ['class' => 'col-xs-6 col-xs-offset-2  col-sm-6 col-sm-offset-2 control-label label-edit-profile'],
            ],
        ]); ?>

        <?= $form->field($model, 'email')->input('email', ['disabled' => true]);?>
        <?= $form->field($model, 'password')->input('password', ['disabled' => true]);?><input type="checkbox" name="bootstrap-switch-checkbox" data-on-text="<?=Yii::t('app', 'Editing');?>" data-off-text="<?=Yii::t('app', 'Locked');?>" data-size="small" data-type="password">
        <?= $form->field($model, 'password_repeat')->input('password', ['disabled' => true]);?>
        <?= $form->field($model, 'country')->dropDownList($dropdownCountries, ['prompt' => Yii::t('app', 'Choose country')]);?>
        <?= $form->field($model, 'region_id')->dropDownList($dropdownCities, ['prompt' => Yii::t('app', 'Choose region')]);?>

        <!--FOR USER-->
        <?php if(Yii::$app->user->identity->role == 1):?>
            <?= $form->field($model, 'email_about_tour')->checkbox();?>
            <?= $form->field($model, 'email_about_hot_tour')->checkbox();?>
            <?= $form->field($model, 'email_about_flight')->checkbox();?>
        <?php elseif(Yii::$app->user->identity->role == 2):?>
            <?= $form->field($model, 'company_name')->input('text', ['disabled' => true]);?><input type="checkbox" name="bootstrap-switch-checkbox" data-on-text="<?=Yii::t('app', 'Editing');?>" data-off-text="<?=Yii::t('app', 'Locked');?>" data-size="small" data-type="company_name">
            <?= $form->field($model, 'company_city')->input('text', ['disabled' => true]);?><input type="checkbox" name="bootstrap-switch-checkbox" data-on-text="<?=Yii::t('app', 'Editing');?>" data-off-text="<?=Yii::t('app', 'Locked');?>" data-size="small" data-type="company_city">
            <?= $form->field($model, 'company_phone')->input('text', ['disabled' => true]);?><input type="checkbox" name="bootstrap-switch-checkbox" data-on-text="<?=Yii::t('app', 'Editing');?>" data-off-text="<?=Yii::t('app', 'Locked');?>" data-size="small" data-type="company_phone">
            <?= $form->field($model, 'company_address');?>
            <?= $form->field($model, 'company_street');?>
            <?= $form->field($model, 'company_underground');?>
            <?= $form->field($model, 'email_about_user_tour')->checkbox();?>
            <?= $form->field($model, 'email_about_user_flight')->checkbox();?>
        <?php endif;?>
        <?= $form->field($model, 'role')->hiddenInput()->label('');?>

        <div class="form-group">
            <div class="col-xs-8 col-xs-offset-2  col-sm-6 col-sm-offset-3">
                <?= Html::submitButton(Yii::t('app','Edit profile'), ['class' => 'btn btn-success col-xs-5', 'name' => 'edit-profile-button']) ?>
                <?= Html::a(Yii::t('app','Back to offers'), Url::toRoute(['/']), ['class' => 'btn btn-info col-xs-5 pull-right']);?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
        <?= Html::a('', Url::toRoute(['site/get-city-dropdown']), ['class' => 'get-city-dropdown']);?>
    </div>
</div>