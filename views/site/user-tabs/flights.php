<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
?>
<div class="row filter-tour">
    <span class="back-to-main back-to-main-from-user-flight" data-tab-class="user-flights">
        <span class="text"><?=Yii::t('app', 'Rollback');?></span>
    </span>
    <div class="main-tab-container user-flights-tab-container col-xs-12" data-tab-class="user-flights">
    <div class="col-md-9 left-data">
        <div class="col-md-4 filter flight-container overflow-list">
            <?php $form = ActiveForm::begin([
                'id' => 'user-flight-form',
                'action' => Url::toRoute(['flight/submit-user-flight']),
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-xs-11 col-xs-offset-1 \">{input}</div>\n<div class=\"col-xs-11 col-xs-offset-1\">{error}</div>",
                    'labelOptions' => ['class' => 'col-xs-11 col-xs-offset-1 control-label label-get-tour'],
                ],
            ]); ?>

            <?= $form->field($UserFlightForm, 'destination')->dropDownList($destinationDropdown,['prompt' => Yii::t('app','All destinations')]);?>

            <?= $form->field($UserFlightForm, 'resort')->dropDownList([],['prompt' => Yii::t('app','All cities')]);?>

            <?= $form->field($UserFlightForm, 'depart_country')->dropDownList($departCountryDropdown,['prompt' => Yii::t('app','Choose country')]);?>
            <?= $form->field($UserFlightForm, 'depart_city')->dropDownList([],['prompt' => Yii::t('app','Departure town')]);?>

            <?= $form->field($UserFlightForm, 'way_ticket')->radioList([1 => '', 2 => ''],
                ['item' => function($index, $label, $name, $checked, $value){
                    if($value == 1){
                        $checked = true;
                        $span = Html::tag('span', Yii::t('app','One way'), ['class' => 'line-name']);
                    }elseif($value == 2){
                        $span = Html::tag('span', Yii::t('app','Two way'), ['class' => 'type-name']);
                    }
                    $checkbox = Html::radio($name, $checked, ['value' => $value]);
                    return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one type']);
                }]);?>

            <?= $form->field($UserFlightForm, 'date_city_to_since')->widget(
                DatePicker::className(), [
                'inline' => false,
                'options' => ['placeholder' => Yii::t('app', date('Y-M-d'))],
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-m-d',
                    'todayHighlight' => true,
                    //'startDate' => date('Y-M-d', strtotime('today')),
                ]
            ]);?>

            <?= $form->field($UserFlightForm, 'exactly_date_to_since')->dropDownList([0 => Yii::t('app', 'Exactly date'), 1 => Yii::t('app', '+-1 day'), 2 => Yii::t('app', '+-2 days'), 3 => Yii::t('app', '+-3 days')]);?>

            <?= $form->field($UserFlightForm, 'date_city_from_since')->widget(
                DatePicker::className(), [
                'inline' => false,
                'options' => [
                    'placeholder' => Yii::t('app', date('Y-M-d')),
                    'disabled' => true
                ],
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-m-d',
                    'todayHighlight' => true,
                    //'startDate' => date('Y-M-d', strtotime('today')),
                ]
            ]);?>
            <?= $form->field($UserFlightForm, 'exactly_date_from_since')->dropDownList([0 => Yii::t('app', 'Exactly date'), 1 => Yii::t('app', '+-1 day'), 2 => Yii::t('app', '+-2 days'), 3 => Yii::t('app', '+-3 days')],['disabled' => true]);?>

            <?= $form->field($UserFlightForm, 'adult_count_senior_24')->input('number', ['min' => 0, 'max' => 99, 'step' => 1, 'value' => '']);?>
            <?= $form->field($UserFlightForm, 'adult_count_under_24')->input('number', ['min' => 0, 'max' => 99, 'step' => 1, 'value' => '']);?>
            <?= $form->field($UserFlightForm, 'children_under_12_amount')->input('number', ['min' => 0, 'max' => 99, 'step' => 1, 'value' => '']);?>
            <?= $form->field($UserFlightForm, 'children_under_2_amount')->input('number', ['min' => 0, 'max' => 99, 'step' => 1, 'value' => '']);?>

            <?= $form->field($UserFlightForm, 'flight_class')->radioList([0 => '', 1 => '', 2 => ''],
                ['item' => function($index, $label, $name, $checked, $value){
                    if($value == 0){
                        $checked = true;
                        $span = Html::tag('span', Yii::t('app','Any class'), ['class' => 'line-name']);
                    }elseif($value == 1){
                        $span = Html::tag('span', Yii::t('app','Economy class'), ['class' => 'line-name']);
                    }elseif($value == 2){
                        $span = Html::tag('span', Yii::t('app','Business class'), ['class' => 'line-name']);
                    }
                    $checkbox = Html::radio($name, $checked, ['value' => $value]);
                    return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one type']);
                }]);?>

            <?= $form->field($UserFlightForm, 'flight_types')->checkboxList([0 => '', 1 => ''],
                ['item' => function($index, $label, $name, $checked, $value){
                    if($value == 0){
                        $span = Html::tag('span', Yii::t('app','Direct flight'), ['class' => 'line-name']);
                    }elseif($value == 1){
                        $span = Html::tag('span', Yii::t('app','Regular flight'), ['class' => 'line-name']);
                    }
                    $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
                    return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one type']);
                }]);?>

            <div class="form-group">
                <div class="col-xs-11 col-xs-offset-1">
                    <?= Html::submitButton(Yii::t('app','Request flight'), ['class' => 'btn btn-success col-xs-12', 'name' => 'get-flight-button', 'id' => 'submit-flight']) ?>
                </div>
            </div>

            <?php ActiveForm::end();?>
        </div>
        <div class="col-md-8 flights-container overflow-list">
            <div class="loader-bg hide"><img src="/images/loader.gif"></div>
            <div id="flight-response">
                <?= Html::dropDownList('order-flight-list', 'id', [
                    //'a-to-z' => Yii::t('app','From A to Z'),
                    //'z-to-a' => Yii::t('app','From Z to A'),
                    '' => Yii::t('app','Order by'),
                    'cheap-to-expensive' => Yii::t('app','From cheap to expensive'),
                    'expensive-to-cheap' => Yii::t('app','From expensive to cheap'),
                    'new-to-old' => Yii::t('app','From old to new'),
                    'old-to-new' => Yii::t('app','From new to old')
                ], ['class' => 'form-control col-xs-7 order-list']) ?>
                <div class="list-data col-xs-12">
                    <?=$userFlights;?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 right-data">
        <?= \app\components\TopHotelsWidget::widget(['page' => 'user-hot-tours']);?>
    </div>
    </div>
    <div class="col-xs-12 full-flights-information close-tab hide" data-tab-class="user-flights">

    </div>
    <div class="col-xs-12 full-hotel-information close-tab" data-tab-class="user-flights">

    </div>
</div>