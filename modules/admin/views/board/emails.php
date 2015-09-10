<?php
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="admin-panel">
    <?= \app\components\AdminNavbarWidget::widget(['active_link' => 'email']);?>
    <?php if(Yii::$app->session->getFlash('success')):?>
        <?php
        echo \yii\bootstrap\Alert::widget([
            'options' => [
                'class' => 'alert-success',
            ],
            'body' => Yii::t('app', 'Admin\'s subscribe was updated successful.'),
        ]);
        ?>
    <?php endif;?>
        <div class="emails">
            <div class="edit">
                <?php $form = ActiveForm::begin([
                    'id' => 'admin-edit-email-form',
                    'action' => Url::toRoute(['/admin/board/emails']),
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-xs-12 \">{input}</div>\n<div class=\"col-xs-12\">{error}</div>",
                        'labelOptions' => ['class' => 'col-xs-12 control-label label-emails'],
                    ],
                ]); ?>
                <?= $form->field($model, 'email_new_tourist')->checkbox();?>
                <?= $form->field($model, 'email_new_manager')->checkbox();?>
                <?= $form->field($model, 'email_single_region_pay')->checkbox();?>
                <?= $form->field($model, 'email_multiple_region_pay')->checkbox();?>

                <div class="form-group buttons-action">
                    <div class="col-xs-12">
                        <?= Html::submitButton(Yii::t('app','Edit'), ['class' => 'btn btn-success col-xs-3', 'name' => 'edit-emails-button']) ?>
                    </div>
                </div>

                <?php ActiveForm::end();?>
            </div>
        </div>
</div>