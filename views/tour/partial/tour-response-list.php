<?php
use yii\helpers\Html;
?>
<?= Html::dropDownList('order-tour-list', 'id', [
    //'a-to-z' => Yii::t('app','From A to Z'),
    //'z-to-a' => Yii::t('app','From Z to A'),
    '' => Yii::t('app','Order by'),
    'cheap-to-expensive' => Yii::t('app','From cheap to expensive'),
    'expensive-to-cheap' => Yii::t('app','From expensive to cheap'),
    'new-to-old' => Yii::t('app','From new to old'),
    'old-to-new' => Yii::t('app','From old to new')
], ['class' => 'form-control col-xs-6']) ?>
<?php foreach($tours as $tour):?>
    <?= $this->renderAjax('user-tour-response', ['tour' => $tour]);?>
<?php endforeach;?>