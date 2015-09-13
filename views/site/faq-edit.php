<?php
use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\ckeditor\CKEditor;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
$this->title = Yii::t('app','FAQ "Editing"');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about page">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'admin-edit-page-form',
        'action' => Url::toRoute(['/site/faq-edit']),
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-xs-12 \">{input}</div>\n<div class=\"col-xs-12\">{error}</div>",
            'labelOptions' => ['class' => 'col-xs-12 control-label edit-page'],
        ],
    ]); ?>
    <?= $form->field($model, 'title');?>
    <?= $form->field($model, 'body')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

    <div class="form-group buttons-action">
        <div class="col-xs-12">
            <?= Html::submitButton(Yii::t('app','Edit'), ['class' => 'btn btn-success col-xs-3', 'name' => 'edit-emails-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end();?>
</div>
