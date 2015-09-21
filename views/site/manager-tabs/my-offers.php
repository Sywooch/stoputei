<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row filter-tour">
    <span class="back-to-main-from-tour-manager" data-tab-class="manager-offers">
        <span class="text"><?=Yii::t('app', 'Close tab');?></span>
    </span>
    <div class="main-tab-container manager-offers-tab-container col-xs-12" data-tab-class="manager-offers">
        <div class="col-md-9 left-data">
            <div class="col-md-4 manager-offers-filter overflow-list">
                <?php $form = ActiveForm::begin([
                    'id' => 'manager-offers-form',
                    'action' => Url::toRoute(['/']),
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-xs-11 col-xs-offset-1 \">{input}</div>\n<div class=\"col-xs-11 col-xs-offset-1\">{error}</div>",
                        'labelOptions' => ['class' => 'col-xs-11 col-xs-offset-1 control-label label-get-tour'],
                    ],
                ]); ?>
                <?= $form->field($ManagerOffersForm, 'destination')->dropDownList($dropdownDestination,['prompt' => Yii::t('app','All destinations')]);?>

                <?= $form->field($ManagerOffersForm, 'resort')->dropDownList([],['prompt' => Yii::t('app','All resorts')]);?>

                <?= $form->field($ManagerOffersForm, 'id');?>

                <?php ActiveForm::end();?>
            </div>
            <div class="col-md-8 manager-offers overflow-list">
                <div class="loader-bg hide"><img src="/images/loader.gif"></div>
                <div id="manager-offers-response">
                    <?= Html::dropDownList('order-tour-list', 'id', [
                        //'a-to-z' => Yii::t('app','From A to Z'),
                        //'z-to-a' => Yii::t('app','From Z to A'),
                        '' => Yii::t('app','Order by'),
                        'cheap-to-expensive' => Yii::t('app','From cheap to expensive'),
                        'expensive-to-cheap' => Yii::t('app','From expensive to cheap'),
                        'new-to-old' => Yii::t('app','From new to old'),
                        'old-to-new' => Yii::t('app','From old to new')
                    ], ['class' => 'form-control col-xs-7 order-list', 'data-type' => 'my-offer']) ?>
                    <div class="list-data">
                    <?=$myOffers;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 right-data">
            <div class="main-data">
                <?= \app\components\ManagerTourStatisticsWidget::widget();?>
            </div>
            <div id="right-data-response-manager-offers">

            </div>
        </div>
    </div>
    <div class="col-xs-12 full-tour-information close-tab" data-tab-class="manager-offers">

    </div>
</div>
