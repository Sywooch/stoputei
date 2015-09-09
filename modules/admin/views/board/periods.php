<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="admin-panel">
    <?= \app\components\AdminNavbarWidget::widget(['active_link' => 'periods']);?>
    <?php if(Yii::$app->session->getFlash('success')):?>
        <?php
        echo \yii\bootstrap\Alert::widget([
            'options' => [
                'class' => 'alert-success',
            ],
            'body' => Yii::t('app', 'Time cycles was updated successful.'),
        ]);
        ?>
    <?php endif;?>
    <div class="periods">
        <div class="edit">
            <?php $form = ActiveForm::begin([
                'id' => 'admin-edit-time-cycles-form',
                'action' => Url::toRoute(['/admin/board/periods']),
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-xs-3 \">{input}</div>\n<div class=\"col-xs-12\">{error}</div>",
                    'labelOptions' => ['class' => 'col-xs-12 control-label label-emails'],
                ],
            ]); ?>
            <?= $form->field($model, 'tour_request_life');?>
            <?= $form->field($model, 'tour_response_life');?>
            <?= $form->field($model, 'flight_response_life');?>

            <div class="form-group buttons-action">
                <div class="col-xs-12">
                    <?= Html::submitButton(Yii::t('app','Editing'), ['class' => 'btn btn-success col-xs-3', 'name' => 'edit-emails-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end();?>
        </div>
    </div>
</div>