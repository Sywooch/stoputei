<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="admin-panel">
    <div class="emails">
        <div class="edit">
            <?php $form = ActiveForm::begin([
                'id' => 'admin-edit-email-form',
                'action' => Url::toRoute(['/admin/emails/edit']),
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-xs-6 col-xs-offset-2 \">{input}</div>\n<div class=\"col-xs-6 col-xs-offset-2\">{error}</div>",
                    'labelOptions' => ['class' => 'col-xs-6 col-xs-offset-2 control-label label-payment'],
                ],
            ]); ?>
            <?= $form->field($model, 'email_new_tourist')->checkbox();?>
            <?= $form->field($model, 'email_new_manager')->checkbox();?>
            <?= $form->field($model, 'email_single_region_pay')->checkbox();?>
            <?= $form->field($model, 'email_multiple_region_pay')->checkbox();?>

            <div class="form-group buttons-action">
                <div class="col-xs-6 col-xs-offset-2">
                    <?= Html::submitButton(Yii::t('app','Editing'), ['class' => 'btn btn-success col-xs-5', 'name' => 'new-payment-button']) ?>
                    <?= Html::a(Yii::t('app','Back to list'), Url::toRoute(['/admin/board/emails']), ['class' => 'btn btn-info col-xs-5 pull-right']);?>
                </div>
            </div>

            <?php ActiveForm::end();?>
        </div>
    </div>
</div>