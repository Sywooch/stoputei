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
        <div class="col-md-4 filter tour-container overflow-list">
            <?php $form = ActiveForm::begin([
                'id' => 'get-tour-form',
                'action' => Url::toRoute(['tour/submit-tour-user']),
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-xs-11 col-xs-offset-1 \">{input}</div>\n<div class=\"col-xs-11 col-xs-offset-1\">{error}</div>",
                    'labelOptions' => ['class' => 'col-xs-11 col-xs-offset-1 control-label label-get-tour'],
                ],
            ]); ?>

            <?= $form->field($GetTourForm, 'destination')->dropDownList($destinationDropdown,['prompt' => Yii::t('app','Choose destination')]);?>

            <?= $form->field($GetTourForm, 'resort')->dropDownList([],['prompt' => Yii::t('app','Choose destination')]);?>

            <?= $form->field($GetTourForm, 'hotel', ['template' => '{label}<div class="col-xs-11 col-xs-offset-1 ">{input}<i class="glyphicon glyphicon-remove-circle remove-hotel-name"></i></div>'])->input('text') ?>

            <?= $form->field($GetTourForm, 'hotel_id')->dropDownList([], ['multiple' => true])->label('');?>

            <?= Html::a('', Url::toRoute(['tour/ajax-hotels-autocomplete']), ['class' => 'ajax-hotel-autocomplete']);?>


            <?= $form->field($GetTourForm, 'stars')->checkboxList([404 => '', 403 => '', 402 => '', 401 => '', 400 => ''],
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
            <?= $form->field($GetTourForm, 'nutrition')->checkboxList([0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => ''],
                ['item' => function($index, $label, $name, $checked, $value){
                    if($value == 0){
                        $span = Html::tag('span', Yii::t('app','Any nutrition'), ['class' => 'type-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Any nutrition')]);
                    }elseif($value == 1){
                        $span = Html::tag('span', Yii::t('app','RO'), ['class' => 'type-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Room only')]);
                    }elseif($value == 2){
                        $span = Html::tag('span', Yii::t('app','BB'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Bed & Breakfast')]);
                    }elseif($value == 3){
                        $span = Html::tag('span', Yii::t('app','HB'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Half Board (Breakfast and Dinner normally)')]);
                    }elseif($value == 4){
                        $span = Html::tag('span', Yii::t('app','HB+'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Half Board plus')]);
                    }elseif($value == 5){
                        $span = Html::tag('span', Yii::t('app','FB+'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Full Board plus')]);
                    }elseif($value == 6){
                        $span = Html::tag('span', Yii::t('app','AL'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'All Inclusive')]);
                    }elseif($value == 7){
                        $span = Html::tag('span', Yii::t('app','UAL'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Ultra All Inclusive')]);
                    }
                    $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
                    return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one col-xs-6']);
                }]);?>
            <?= $form->field($GetTourForm, 'beach_line')->radioList([0 => '', 1 => '', 2 => '', 3 => ''],
                ['item' => function($index, $label, $name, $checked, $value){
                    if($value == 0){
                        $span = Html::tag('span', Yii::t('app','Any line'), ['class' => 'line-name']);
                    }elseif($value == 1){
                        $span = Html::tag('span', Yii::t('app','First'), ['class' => 'line-name']);
                    }elseif($value == 2){
                        $span = Html::tag('span', Yii::t('app','Second'), ['class' => 'line-name']);
                    }elseif($value == 3){
                        $span = Html::tag('span', Yii::t('app','Third'), ['class' => 'line-name']);
                    }
                    $checkbox = Html::radio($name, $checked, ['value' => $value]);
                    return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one type']);
                }]);?>
            <?= $form->field($GetTourForm, 'hotel_type')->radioList([0 => '', 1 => '', 2 => '', 3 => '', 4 => ''],
                ['item' => function($index, $label, $name, $checked, $value){
                    if($value == 0){
                        $span = Html::tag('span', Yii::t('app','Any type'), ['class' => 'type-name']);
                    }elseif($value == 1){
                        $span = Html::tag('span', Yii::t('app','Teen'), ['class' => 'line-name']);
                    }elseif($value == 2){
                        $span = Html::tag('span', Yii::t('app','Family type'), ['class' => 'line-name']);
                    }elseif($value == 3){
                        $span = Html::tag('span', Yii::t('app','Urban'), ['class' => 'line-name']);
                    }elseif($value == 4){
                        $span = Html::tag('span', Yii::t('app','Health'), ['class' => 'line-name']);
                    }
                    $checkbox = Html::radio($name, $checked, ['value' => $value]);
                    return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one type']);
                }]);?>
            <div class="form-group">
                <label class="col-xs-11 col-xs-offset-1 control-label label-get-tour" for="gettourform-hotel_type"><?=Yii::t('app', 'Amount of nights');?></label>
                <?= $form->field($GetTourForm, 'night_min', ['options' => ['class' => 'col-xs-6']], ['template' => '{label}<div class="col-xs-5">{input}</div>', 'labelOptions' => ['class' => 'col-xs-2 control-label label-night']])->dropDownList([1 => 1, 2 => 2]);?>
                <?= $form->field($GetTourForm, 'night_max', ['options' => ['class' => 'col-xs-6']], ['template' => '{label}<div class="col-xs-5">{input}</div>', 'labelOptions' => ['class' => 'col-xs-2 control-label label-night']])->dropDownList([1 => 1, 2 => 2]);?>
            </div>
             <?= $form->field($GetTourForm, 'room_type')->checkboxList([0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => '', 8 => '', 9 => '', 10 => '', 11 => ''],
                ['item' => function($index, $label, $name, $checked, $value){
                    if($value == 0){
                        $span = Html::tag('span', Yii::t('app','Any type'), ['class' => 'type-name']);
                    }elseif($value == 1){
                        $span = Html::tag('span', Yii::t('app','Standart'), ['class' => 'type-name']);
                    }elseif($value == 2){
                        $span = Html::tag('span', Yii::t('app','Family'), ['class' => 'line-name']);
                    }elseif($value == 3){
                        $span = Html::tag('span', Yii::t('app','Deluxe'), ['class' => 'line-name']);
                    }elseif($value == 4){
                        $span = Html::tag('span', Yii::t('app','Suite'), ['class' => 'line-name']);
                    }elseif($value == 5){
                        $span = Html::tag('span', Yii::t('app','Villa'), ['class' => 'line-name']);
                    }elseif($value == 6){
                        $span = Html::tag('span', Yii::t('app','Club'), ['class' => 'line-name']);
                    }elseif($value == 7){
                        $span = Html::tag('span', Yii::t('app','Apartments'), ['class' => 'line-name']);
                    }elseif($value == 8){
                        $span = Html::tag('span', Yii::t('app','Duplex'), ['class' => 'line-name']);
                    }elseif($value == 9){
                        $span = Html::tag('span', Yii::t('app','Studio'), ['class' => 'line-name']);
                    }elseif($value == 10){
                        $span = Html::tag('span', Yii::t('app','Bungalow'), ['class' => 'line-name']);
                    }elseif($value == 11){
                        $span = Html::tag('span', Yii::t('app','Eco'), ['class' => 'line-name']);
                    }
                    $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
                    return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one col-xs-6']);
                }]);?>
            <?= $form->field($GetTourForm, 'adult_amount')->input('number', ['min' => 1, 'max' => 10, 'step' => 1, 'value' => 1]);?>
            <?= $form->field($GetTourForm, 'children_under_12_amount')->input('number', ['min' => 0, 'max' => 10, 'step' => 1, 'value' => 0]);?>
            <?= $form->field($GetTourForm, 'children_under_2_amount')->input('number', ['min' => 0, 'max' => 10, 'step' => 1, 'value' => 0]);?>
            <?= $form->field($GetTourForm, 'room_count')->input('number', ['min' => 0, 'max' => 10, 'step' => 1, 'value' => 0]);?>
            <?= $form->field($GetTourForm, 'flight_included')->checkbox();?>

            <?= $form->field($GetTourForm, 'depart_country')->dropDownList($departCountryDropdown, ['prompt' => Yii::t('app','Choose destination')]);?>
            <?= $form->field($GetTourForm, 'depart_city')->dropDownList([], ['prompt' => Yii::t('app','Choose destination')]);?>

                <?= $form->field($GetTourForm, 'from_date')->widget(
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

                <?= $form->field($GetTourForm, 'to_date')->widget(
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

            <?= $form->field($GetTourForm, 'budget')->input('number', ['min' => 0, 'max' => 99000000, 'step' => 1000, 'value' => 0]);?>

            <?= $form->field($GetTourForm, 'add_info')->textarea(['class' => 'add-info', 'placeholder' => Yii::t('app', 'Max length - 200')]);?>

            <?= Html::a('', Url::toRoute(['tour/get-hotel-list']), ['class' => 'ajax-tour-list']);?>

            <div class="form-group">
                <div class="col-xs-11 col-xs-offset-1">
                    <?= Html::submitButton(Yii::t('app','Get a tour'), ['class' => 'btn btn-success col-xs-12', 'name' => 'get-tour-button', 'id' => 'submit-tour']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-8 hotels-container overflow-list">
            <div class="loader-bg hide"><img src="/images/loader.gif"></div>
            <div id="hotel-response">

            </div>
        </div>
    </div>
    <div class="col-md-3 right-data">
        TOP HOTELS
    </div>
</div>