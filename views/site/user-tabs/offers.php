<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
?>
<div class="row filter-tour">
    <span class="back-to-main-from-tour" data-tab-class="user-offers">
        <i class="glyphicon glyphicon-menu-right hide"></i>
    </span>
    <div class="main-tab-container user-offers-tab-container col-xs-12" data-tab-class="user-offers">
    <div class="col-md-9 left-data">
        <div class="col-md-4 filter user-offers overflow-list">
            <?php $form = ActiveForm::begin([
                'id' => 'user-offers-tour-form',
                'action' => Url::toRoute(['']),
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-xs-11 col-xs-offset-1 \">{input}</div>\n<div class=\"col-xs-11 col-xs-offset-1\">{error}</div>",
                    'labelOptions' => ['class' => 'col-xs-11 col-xs-offset-1 control-label label-get-tour'],
                ],
            ]); ?>

            <?= $form->field($TourOffersForm, 'destination')->dropDownList($destinationDropdown,['prompt' => Yii::t('app','All destinations')]);?>

            <?= $form->field($TourOffersForm, 'resort')->dropDownList([],['prompt' => Yii::t('app','All resorts')]);?>

            <?= $form->field($TourOffersForm, 'stars')->checkboxList([404 => '', 403 => '', 402 => '', 401 => '', 400 => ''],
                ['item' => function($index, $label, $name, $checked, $value){
                    if($value == 404){
                        $span = Html::tag('span', '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>', ['class' => 'star']);
                    }elseif($value == 403){
                        $span = Html::tag('span', '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i>', ['class' => 'star']);
                    }elseif($value == 402){
                        $span = Html::tag('span', '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i>', ['class' => 'star']);
                    }elseif($value == 401){
                        $span = Html::tag('span', '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i>', ['class' => 'star']);
                    }elseif($value == 400){
                        $span = Html::tag('span', '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i>', ['class' => 'star']);
                    }
                    $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
                    return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox']);
                }]);?>

            <?= $form->field($TourOffersForm, 'depart_city')->dropDownList($cityDropdown,['prompt' => Yii::t('app','Choose destination')]);?>

            <?= $form->field($TourOffersForm, 'night_count')->dropDownList([0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10,
            11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21]);?>

            <?= Html::a('', Url::toRoute(['tour/get-hotel-list']), ['class' => 'ajax-tour-list']);?>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-8 user-offers overflow-list">
            <div class="loader-bg hide"><img src="/images/loader.gif"></div>
            <div id="user-tour-response-list">
                <?= Html::dropDownList('order-tour-list', 'id', [
                    //'a-to-z' => Yii::t('app','From A to Z'),
                    //'z-to-a' => Yii::t('app','From Z to A'),
                    '' => Yii::t('app','Order by'),
                    'cheap-to-expensive' => Yii::t('app','From cheap to expensive'),
                    'expensive-to-cheap' => Yii::t('app','From expensive to cheap'),
                    'new-to-old' => Yii::t('app','From new to old'),
                    'old-to-new' => Yii::t('app','From old to new')
                ], ['class' => 'form-control col-xs-7 order-list', 'data-type' => 'offer']) ?>
                <div class="list-data">
                    <?=$tourUserResponse;?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 right-data">
        <div class="main-data">
            <?= \app\components\TopHotelsWidget::widget(['page' => 'user-hot-tours']);?>
        </div>
        <div id="right-data-response-offers">

        </div>
        <div class="col-xs-12 full-tour-information close-tab" data-tab-class="user-offers">

        </div>
    </div>
    </div>
</div>