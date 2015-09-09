<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="admin-panel">
    <div class="users">
        <div class="edit">
            <?php $form = ActiveForm::begin([
                'id' => 'admin-edit-user-form',
                'action' => Url::toRoute(['/admin/users/edit', 'id' => $user->id]),
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-xs-6 col-xs-offset-2 \">{input}</div>\n<div class=\"col-xs-6 col-xs-offset-2\">{error}</div>",
                    'labelOptions' => ['class' => 'col-xs-6 col-xs-offset-2 control-label label-payment'],
                ],
            ]); ?>
            <?= $form->field($model, 'email')->input('text', ['disabled' => true]);?>

            <?= $form->field($model, 'region_id')->input('text', ['disabled' => true]);?>

            <?= $form->field($model, 'role')->radioList([1 => '', 2 => ''],
                ['item' => function($index, $label, $name, $checked, $value){
                    if($value == 1){
                        $checked = true;
                        $span = Html::tag('span', Yii::t('app', 'tourist'));
                    }elseif($value == 2){
                        $span = Html::tag('span', Yii::t('app', 'manager'));
                    }
                    $checkbox = Html::radio($name, $checked, ['value' => $value]);
                    return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox']);
                }]);?>

            <?php if($user->role == 1):?>
                <?= $form->field($model, 'approved')->checkbox();?>
            <?php elseif($user->role == 2):?>
                <?= $form->field($model, 'single_region_paid')->checkbox();?>
                <?= $form->field($model, 'multiple_region_paid')->checkbox();?>
                <?= $form->field($model, 'company_name');?>
                <?= $form->field($model, 'company_city');?>
                <?= $form->field($model, 'company_phone');?>
                <?= $form->field($model, 'company_address');?>
                <?= $form->field($model, 'company_street');?>
            <?php endif;?>

            <div class="form-group buttons-action">
                <div class="col-xs-6 col-xs-offset-2">
                    <?= Html::submitButton(Yii::t('app','Edit profile'), ['class' => 'btn btn-success col-xs-5', 'name' => 'new-payment-button']) ?>
                    <?php if($model->role == 2):?>
                        <?= Html::a(Yii::t('app','Back to list'), Url::toRoute(['/admin/board/managers']), ['class' => 'btn btn-info col-xs-5 pull-right']);?>
                    <?php else:?>
                        <?= Html::a(Yii::t('app','Back to list'), Url::toRoute(['/admin/board/users']), ['class' => 'btn btn-info col-xs-5 pull-right']);?>
                    <?php endif;?>
                </div>
            </div>

            <?php ActiveForm::end();?>
        </div>
    </div>
</div>