<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
?>
<div class="row filter-tour">
    <span class="back-to-main">
        <i class="glyphicon glyphicon-menu-right hide"></i>
    </span>
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

            <?= $form->field($TourOffersForm, 'destination')->dropDownList($destinationDropdown,['prompt' => Yii::t('app','Choose destination')]);?>

            <?= $form->field($TourOffersForm, 'resort')->dropDownList([],['prompt' => Yii::t('app','Choose destination')]);?>

            <?= $form->field($TourOffersForm, 'hotel', ['template' => '{label}<div class="col-xs-11 col-xs-offset-1 ">{input}<i class="glyphicon glyphicon-remove-circle remove-hotel-name"></i></div>'])->input('text') ?>

            <?= $form->field($TourOffersForm, 'hotel_id')->dropDownList([], ['multiple' => true])->label('');?>

            <?= Html::a('', Url::toRoute(['tour/ajax-hotels-autocomplete']), ['class' => 'ajax-hotel-autocomplete']);?>


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

            <?= $form->field($TourOffersForm, 'depart_city')->dropDownList($departCityDropdown);?>

            <?= $form->field($TourOffersForm, 'night_count')->dropDownList([0 => 0, 1 => 1, 2 => 2, 3 => 3]);?>

            <?= $form->field($TourOffersForm, 'from_date')->widget(
                DatePicker::className(), [
                'inline' => false,
                'options' => ['placeholder' => Yii::t('app', date('Y-M-d'))],
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-m-d',
                    'todayHighlight' => true,
                    'startDate' => date('Y-M-d', strtotime('+2 days')),
                ]
            ]);?>

            <?= $form->field($TourOffersForm, 'to_date')->widget(
                DatePicker::className(), [
                'inline' => false,
                'options' => ['placeholder' => Yii::t('app', 'To date')],
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-m-d',
                    'todayHighlight' => true,
                    'startDate' => date('Y-M-d', strtotime('+4 days'))
                ]
            ]);?>

            <?= $form->field($TourOffersForm, 'budget')->input('number', ['min' => 1000, 'max' => 90000000, 'step' => 200]);?>

            <?= Html::a('', Url::toRoute(['tour/get-hotel-list']), ['class' => 'ajax-tour-list']);?>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-8 user-offer-list overflow-list">
            <div class="loader-bg hide"><img src="/images/loader.gif"></div>
            <div id="user-tour-response-list">
                <?=$tourUserResponse;?>
            </div>
        </div>
    </div>
    <div class="col-md-3 right-data">
        <div class="main-data">
            TOP HOTELS
        </div>
        <div id="right-data-response-offers">

        </div>
    </div>
</div>