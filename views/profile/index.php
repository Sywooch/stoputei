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
                'template' => "{label}\n<div class=\"col-xs-6 col-xs-offset-2\">{input}</div>\n<div class=\"col-xs-6 col-xs-offset-2\">{error}</div>",
                'labelOptions' => ['class' => 'col-xs-6 col-xs-offset-2 control-label label-edit-profile'],
            ],
        ]); ?>

        <?php if(Yii::$app->user->identity->role == 2):?>
            <div class="form-group payment-btns">
                <div class="col-xs-6 col-xs-offset-2">
                <?php if(Yii::$app->user->identity->single_region_paid == 0):?>
                    <?= Html::a(Yii::t('app', 'Payment package "Region"'), ['site/payment', 'type' => 'single'], ['id' => 'license-region', 'class' => 'license btn btn-success col-xs-5']);?>
                <?php else:?>
                    <?= Html::a(Yii::t('app', 'Payment package "Region"'), ['/'], ['id' => 'license-region', 'class' => 'license-paid btn btn-default col-xs-5', 'disabled' => true]);?>
                <?php endif;?>
                <?php if(Yii::$app->user->identity->multiple_region_paid == 0):?>
                    <?= Html::a(Yii::t('app', 'Payment package "Country"'), ['site/payment', 'type' => 'multiple'], ['id' => 'license-country', 'class' => 'license btn btn-success col-xs-5 pull-right']);?>
                <?php else:?>
                    <?= Html::a(Yii::t('app', 'Payment package "Country"'), ['/'], ['id' => 'license-country', 'class' => 'license-paid btn btn-default col-xs-5 pull-right', 'disabled' => true]);?>
                <?php endif;?>
                </div>
            </div>
        <?php endif;?>

        <?= $form->field($model, 'email')->input('email', ['disabled' => true]);?>
        <?= $form->field($model, 'password')->input('password', ['disabled' => true]);?><input type="checkbox" name="bootstrap-switch-checkbox" data-on-text="<?=Yii::t('app', 'Editing');?>" data-off-text="<?=Yii::t('app', 'Locked');?>" data-size="small" data-type="password">
        <?= $form->field($model, 'password_repeat')->input('password', ['disabled' => true]);?>
        <?= $form->field($model, 'country')->dropDownList($dropdownCountries, ['disabled' => true, 'prompt' => Yii::t('app', 'Choose country')]);?>
        <?= $form->field($model, 'region_id')->dropDownList($dropdownCities, ['disabled' => true, 'prompt' => Yii::t('app', 'Choose region')]);?><!--<input type="checkbox" name="bootstrap-switch-checkbox" data-on-text="<?//=Yii::t('app', 'Editing');?>" data-off-text="<?//=Yii::t('app', 'Locked');?>" data-size="small" data-type="region_id">-->

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

        <div class="form-group buttons-action">
            <div class="col-xs-6 col-xs-offset-2">
                <?= Html::submitButton(Yii::t('app','Save changes'), ['class' => 'btn btn-success col-xs-5', 'name' => 'edit-profile-button']) ?>
                <?= Html::a(Yii::t('app','Back to offers'), Url::toRoute(['/']), ['class' => 'btn btn-info col-xs-5 pull-right']);?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
        <?= Html::a('', Url::toRoute(['site/get-city-dropdown']), ['class' => 'get-city-dropdown']);?>
    </div>
</div>