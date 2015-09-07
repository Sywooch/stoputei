<?php
use yii\helpers\Html;
?>

<div class="actions-header">
    <?= Html::a(Yii::t('app', 'Create new payment'), ['/admin/payments/new'], ['class' => 'btn btn-success']);?>
</div>