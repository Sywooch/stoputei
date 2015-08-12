<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row user-hot-tours">
    <span class="back-to-main" data-tab-class="user-hot-tours">
        <i class="glyphicon glyphicon-menu-right hide"></i>
    </span>
    <div class="main-tab-container user-hot-tours-tab-container col-xs-12" data-tab-class="user-hot-tours">
        <div class="col-md-9 left-data">
            <div class="col-md-4 user-hot-tours overflow-list">
                <?php $form = ActiveForm::begin([
                    'id' => 'user-hot-tours-form',
                    'action' => Url::toRoute(['/']),
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-xs-11 col-xs-offset-1 \">{input}</div>\n<div class=\"col-xs-11 col-xs-offset-1\">{error}</div>",
                        'labelOptions' => ['class' => 'col-xs-11 col-xs-offset-1 control-label label-get-tour'],
                    ],
                ]); ?>
                <?= $form->field($UserHotTourForm, 'destination')->dropDownList($destinationDropdown,['prompt' => Yii::t('app','All destinations')]);?>

                <?= $form->field($UserHotTourForm, 'resort')->dropDownList([],['prompt' => Yii::t('app','All resorts')]);?>

                <?php ActiveForm::end();?>
            </div>
            <div class="col-md-8 user-hot-tours overflow-list">
                <div class="loader-bg hide"><img src="/images/loader.gif"></div>
                <div id="user-hot-tours-response">
                    <?= Html::dropDownList('order-tour-list', 'id', [
                        //'a-to-z' => Yii::t('app','From A to Z'),
                        //'z-to-a' => Yii::t('app','From Z to A'),
                        '' => Yii::t('app','Order by'),
                        'cheap-to-expensive' => Yii::t('app','From cheap to expensive'),
                        'expensive-to-cheap' => Yii::t('app','From expensive to cheap'),
                        'new-to-old' => Yii::t('app','From new to old'),
                        'old-to-new' => Yii::t('app','From old to new')
                    ], ['class' => 'form-control col-xs-7']) ?>
                    <div class="list-data">
                        <?=$userHotToursList;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 right-data">
            <div class="main-data">
                Statistics
            </div>
            <div id="right-data-response-user-hot-tours">

            </div>
        </div>
    </div>
    <div class="col-xs-12 full-tour-information close-tab" data-tab-class="user-hot-tours">

    </div>
</div>
