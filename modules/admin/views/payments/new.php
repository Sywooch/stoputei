<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="admin-panel">
    <div class="payments">
        <div class="new">
            <?php $form = ActiveForm::begin([
                'id' => 'admin-create-payment-form',
                'action' => Url::toRoute(['/admin/payments/new']),
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-xs-6 col-xs-offset-2 \">{input}</div>\n<div class=\"col-xs-6 col-xs-offset-2\">{error}</div>",
                    'labelOptions' => ['class' => 'col-xs-6 col-xs-offset-2 control-label label-payment'],
                ],
            ]); ?>
            <?= $form->field($paymentsForm, 'country_id')->dropDownList($countries,['prompt' => Yii::t('app','Choose country')]);?>

            <?= $form->field($paymentsForm, 'single_region_cost');?>

            <?= $form->field($paymentsForm, 'multiple_region_cost');?>

            <div class="form-group buttons-action">
                <div class="col-xs-6 col-xs-offset-2">
                    <?= Html::submitButton(Yii::t('app','Create payment'), ['class' => 'btn btn-success col-xs-5', 'name' => 'new-payment-button']) ?>
                    <?= Html::a(Yii::t('app','Back to list'), Url::toRoute(['/admin/board/payments']), ['class' => 'btn btn-info col-xs-5 pull-right']);?>
                </div>
            </div>

            <?php ActiveForm::end();?>
        </div>
    </div>
</div>