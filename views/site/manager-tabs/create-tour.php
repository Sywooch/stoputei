<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row filter-tour">
    <span class="back-to-main" data-tab-class="hot-tour">
        <span class="text"><?=Yii::t('app', 'Rollback');?></span>
    </span>
    <div class="main-tab-container create-hot-tour-tab-container col-xs-12" data-tab-class="hot-tour">
        <div class="col-md-9 left-data">
            <div class="col-md-4 create-hot-tour-manager overflow-list inactive">
                <?php $form = ActiveForm::begin([
                    'id' => 'manager-hot-tour-create-form',
                    'action' => Url::toRoute(['tour/create-hot-tour-manager']),
                    'options' => ['class' => 'form-horizontal'],
                    'enableClientValidation' => false,
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-xs-11 col-xs-offset-1 \">{input}</div>\n<div class=\"col-xs-11 col-xs-offset-1\">{error}</div>",
                        'labelOptions' => ['class' => 'col-xs-11 col-xs-offset-1 control-label label-get-tour'],
                    ],
                ]); ?>


                <?= $form->field($CreateHotTourForm, 'destination')->dropDownList($dropdownDestination,['prompt' => Yii::t('app','Choose destination')]);?>

                <?= $form->field($CreateHotTourForm, 'resort')->dropDownList([]);?>

                <?= $form->field($CreateHotTourForm, 'hotel', ['template' => '{label}<div class="col-xs-11 col-xs-offset-1 create-tour-response">{input}<i class="glyphicon glyphicon-remove-circle remove-hotel-hot-tour"></i></div><div class="col-xs-11 col-xs-offset-1">{error}</div>'])->input('text') ?>

                <?= $form->field($CreateHotTourForm, 'hotel_id')->dropDownList([], ['multiple' => true])->label('');?>

                <?= $form->field($CreateHotTourForm, 'stars')->checkboxList([404 => '', 403 => '', 402 => '', 401 => '', 400 => ''],
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

                <!--LETTER FILTER-->
                <!--<?= $form->field($CreateHotTourForm, 'letter_filter')->checkboxList(['a' => '', 'b' => '', 'c' => '', 'd' => '',
                    'e' => '', 'f' => '', 'g' => '', 'h' => '', 'i' => '', 'j' => '', 'k' => '', 'l' => '', 'm' => '', 'n' => '', 'o' => '',
                    'p' => '', 'q' => '', 'r' => '', 's' => '', 't' => '', 'u' => '', 'v' => '', 'w' => '', 'x' => '', 'y' => '', 'z' => '',
                    '1' => '', '2' => '', '3' => '', '4' => '', '5' => '', '6' => '', '7' => '', '8' => '', '9' => ''],
                    ['item' => function($index, $label, $name, $checked, $value){
                        if($value == 'a'){
                            $span = Html::tag('span', 'A', ['class' => 'line-name']);
                        }elseif($value == 'b'){
                            $span = Html::tag('span', 'B', ['class' => 'line-name']);
                        }elseif($value == 'c'){
                            $span = Html::tag('span', 'C', ['class' => 'line-name']);
                        }elseif($value == 'd'){
                            $span = Html::tag('span', 'D', ['class' => 'line-name']);
                        }elseif($value == 'e'){
                            $span = Html::tag('span', 'E', ['class' => 'line-name']);
                        }elseif($value == 'f'){
                            $span = Html::tag('span', 'F', ['class' => 'line-name']);
                        }elseif($value == 'g'){
                            $span = Html::tag('span', 'G', ['class' => 'line-name']);
                        }elseif($value == 'h'){
                            $span = Html::tag('span', 'H', ['class' => 'line-name']);
                        }elseif($value == 'i'){
                            $span = Html::tag('span', 'I', ['class' => 'line-name']);
                        }elseif($value == 'j'){
                            $span = Html::tag('span', 'J', ['class' => 'line-name']);
                        }elseif($value == 'k'){
                            $span = Html::tag('span', 'K', ['class' => 'line-name']);
                        }elseif($value == 'l'){
                            $span = Html::tag('span', 'L', ['class' => 'line-name']);
                        }elseif($value == 'm'){
                            $span = Html::tag('span', 'M', ['class' => 'line-name']);
                        }elseif($value == 'n'){
                            $span = Html::tag('span', 'N', ['class' => 'line-name']);
                        }elseif($value == 'o'){
                            $span = Html::tag('span', 'O', ['class' => 'line-name']);
                        }elseif($value == 'p'){
                            $span = Html::tag('span', 'P', ['class' => 'line-name']);
                        }elseif($value == 'q'){
                            $span = Html::tag('span', 'Q', ['class' => 'line-name']);
                        }elseif($value == 'r'){
                            $span = Html::tag('span', 'R', ['class' => 'line-name']);
                        }elseif($value == 's'){
                            $span = Html::tag('span', 'S', ['class' => 'line-name']);
                        }elseif($value == 't'){
                            $span = Html::tag('span', 'T', ['class' => 'line-name']);
                        }elseif($value == 'u'){
                            $span = Html::tag('span', 'U', ['class' => 'line-name']);
                        }elseif($value == 'v'){
                            $span = Html::tag('span', 'V', ['class' => 'line-name']);
                        }elseif($value == 'w'){
                            $span = Html::tag('span', 'W', ['class' => 'line-name']);
                        }elseif($value == 'x'){
                            $span = Html::tag('span', 'X', ['class' => 'line-name']);
                        }elseif($value == 'y'){
                            $span = Html::tag('span', 'Y', ['class' => 'line-name']);
                        }elseif($value == 'z'){
                            $span = Html::tag('span', 'Z', ['class' => 'line-name']);
                        }elseif($value == '0'){
                            $span = Html::tag('span', '0', ['class' => 'line-name']);
                        }elseif($value == '1'){
                            $span = Html::tag('span', '1', ['class' => 'line-name']);
                        }elseif($value == '2'){
                            $span = Html::tag('span', '2', ['class' => 'line-name']);
                        }elseif($value == '3'){
                            $span = Html::tag('span', '3', ['class' => 'line-name']);
                        }elseif($value == '4'){
                            $span = Html::tag('span', '4', ['class' => 'line-name']);
                        }elseif($value == '5'){
                            $span = Html::tag('span', '5', ['class' => 'line-name']);
                        }elseif($value == '6'){
                            $span = Html::tag('span', '6', ['class' => 'line-name']);
                        }elseif($value == '7'){
                            $span = Html::tag('span', '7', ['class' => 'line-name']);
                        }elseif($value == '8'){
                            $span = Html::tag('span', '8', ['class' => 'line-name']);
                        }elseif($value == '9'){
                            $span = Html::tag('span', '9', ['class' => 'line-name']);
                        }
                        $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
                        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one type col-xs-2']);
                    }]);?>-->
                <!--END LETTER FILTER-->

                <?= $form->field($CreateHotTourForm, 'nutrition')->radioList([0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => '', 8 => ''],
                    ['item' => function($index, $label, $name, $checked, $value){
                        if($value == 0){
                            $span = Html::tag('span', Yii::t('app','RO'), ['class' => 'type-name', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => Yii::t('app', 'Room only')]);
                        }elseif($value == 1){
                            $span = Html::tag('span', Yii::t('app','BB'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => Yii::t('app', 'Bed & Breakfast')]);
                        }elseif($value == 2){
                            $span = Html::tag('span', Yii::t('app','HB'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => Yii::t('app', 'Half Board (Breakfast and Dinner normally)')]);
                        }elseif($value == 3){
                            $span = Html::tag('span', Yii::t('app','HB+'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => Yii::t('app', 'Half Board plus')]);
                        }elseif($value == 4){
                            $span = Html::tag('span', Yii::t('app','FB'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => Yii::t('app', 'Full Board')]);
                        }elseif($value == 5){
                            $span = Html::tag('span', Yii::t('app','FB+'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => Yii::t('app', 'Full Board plus')]);
                        }elseif($value == 6){
                            $span = Html::tag('span', Yii::t('app','AL'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => Yii::t('app', 'All Inclusive')]);
                        }elseif($value == 7){
                            $span = Html::tag('span', Yii::t('app','UAL'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => Yii::t('app', 'Ultra All Inclusive')]);
                        }elseif($value == 8){
                            $span = Html::tag('span', Yii::t('app','Soft AL'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => Yii::t('app', 'Soft All Inclusive')]);
                        }
                        $checkbox = Html::radio($name, $checked, ['value' => $value]);
                        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one col-xs-6']);
                    }]);?>

                <?= $form->field($CreateHotTourForm, 'night_count')->input('number', ['min' => 0, 'max' => 99, 'step' => 1, 'value' => 0]);?>
                <?= $form->field($CreateHotTourForm, 'location')->radioList([0 => '', 1 => '', 2 => '', 3 => ''],
                    ['item' => function($index, $label, $name, $checked, $value){
                        if($value == 0){
                            $span = Html::tag('span', Yii::t('app','SGL'), ['class' => 'location-name', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => Yii::t('app', 'Single')]);
                        }elseif($value == 1){
                            $span = Html::tag('span', Yii::t('app','DBL'), ['class' => 'location-name', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => Yii::t('app', 'Double')]);
                        }elseif($value == 2){
                            $span = Html::tag('span', Yii::t('app','TRP'), ['class' => 'location-name', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => Yii::t('app', 'Triple')]);
                        }elseif($value == 3){
                            $span = Html::tag('span', Yii::t('app','QTRL'), ['class' => 'location-name', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => Yii::t('app', 'Quadriple')]);
                        }
                        $checkbox = Html::radio($name, $checked, ['value' => $value]);
                        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one col-xs-6']);
                    }]);?>
                <?= $form->field($CreateHotTourForm, 'room_type')->radioList([1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => '', 8 => '', 9 => '', 10 => '', 11 => '', 12 => ''],
                    ['item' => function($index, $label, $name, $checked, $value){
                        if($value == 1){
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
                            $span = Html::tag('span', Yii::t('app','Economy'), ['class' => 'line-name']);
                        }elseif($value == 7){
                            $span = Html::tag('span', Yii::t('app','Apartments'), ['class' => 'line-name']);
                        }elseif($value == 8){
                            $span = Html::tag('span', Yii::t('app','Club'), ['class' => 'line-name']);
                        }elseif($value == 9){
                            $span = Html::tag('span', Yii::t('app','Studio'), ['class' => 'line-name']);
                        }elseif($value == 10){
                            $span = Html::tag('span', Yii::t('app','Bungalow'), ['class' => 'line-name']);
                        }elseif($value == 11){
                            $span = Html::tag('span', Yii::t('app','Superior'), ['class' => 'line-name']);
                        }elseif($value == 12){
                            $span = Html::tag('span', Yii::t('app','Eco'), ['class' => 'line-name']);
                        }
                        $checkbox = Html::radio($name, $checked, ['value' => $value]);
                        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one col-xs-6']);
                    }]);?>

                <?= $form->field($CreateHotTourForm, 'hotel_type')->radioList([0 => '', 1 => '', 2 => '', 3 => '', 4 => ''],
                    ['item' => function($index, $label, $name, $checked, $value){
                        if($value == 0){
                            $span = Html::tag('span', Yii::t('app','Teen'), ['class' => 'type-name']);
                        }elseif($value == 1){
                            $span = Html::tag('span', Yii::t('app','Family type'), ['class' => 'line-name']);
                        }elseif($value == 2){
                            $span = Html::tag('span', Yii::t('app','Urban'), ['class' => 'line-name']);
                        }elseif($value == 3){
                            $span = Html::tag('span', Yii::t('app','Health'), ['class' => 'line-name']);
                        }elseif($value == 4){
                            $span = Html::tag('span', Yii::t('app','For everyone'), ['class' => 'line-name']);
                        }
                        $checkbox = Html::radio($name, $checked, ['value' => $value]);
                        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one type']);
                    }]);?>

                <?= $form->field($CreateHotTourForm, 'beach_line')->radioList([0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => ''],
                    ['item' => function($index, $label, $name, $checked, $value){
                        if($value == 0){
                            $span = Html::tag('span', Yii::t('app','First'), ['class' => 'line-name']);
                        }elseif($value == 1){
                            $span = Html::tag('span', Yii::t('app','Second'), ['class' => 'line-name']);
                        }elseif($value == 2){
                            $span = Html::tag('span', Yii::t('app','Third'), ['class' => 'line-name']);
                        }elseif($value == 3){
                            $span = Html::tag('span', Yii::t('app','Fourth'), ['class' => 'line-name']);
                        }elseif($value == 4){
                            $span = Html::tag('span', Yii::t('app','Fifth'), ['class' => 'line-name']);
                        }elseif($value == 5){
                            $span = Html::tag('span', Yii::t('app','Other'), ['class' => 'line-name']);
                        }
                        $checkbox = Html::radio($name, $checked, ['value' => $value]);
                        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one col-xs-6']);
                    }]);?>

                <?= $form->field($CreateHotTourForm, 'room_view')->radioList([0 => '', 1 => '', 2 => '', 3 => '', 4 => ''],
                    ['item' => function($index, $label, $name, $checked, $value){
                        if($value == 0){
                            $span = Html::tag('span', Yii::t('app','Land view'), ['class' => 'type-name']);
                        }elseif($value == 1){
                            $span = Html::tag('span', Yii::t('app','Sea view'), ['class' => 'line-name']);
                        }elseif($value == 2){
                            $span = Html::tag('span', Yii::t('app','Pool view'), ['class' => 'line-name']);
                        }elseif($value == 3){
                            $span = Html::tag('span', Yii::t('app','Garden view'), ['class' => 'line-name']);
                        }elseif($value == 4){
                            $span = Html::tag('span', Yii::t('app','Other view'), ['class' => 'line-name']);
                        }
                        $checkbox = Html::radio($name, $checked, ['value' => $value]);
                        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one type']);
                    }]);?>
                <?= $form->field($CreateHotTourForm, 'adult_amount')->input('number', ['min' => 0, 'max' => 99, 'step' => 1, 'value' => 1]);?>
                <?= $form->field($CreateHotTourForm, 'room_count')->input('number', ['min' => 0, 'max' => 99, 'step' => 1, 'value' => '']);?>
                <?= $form->field($CreateHotTourForm, 'flight_included')->checkbox();?>

                <div class="hot-tour flight-included <?=($CreateHotTourForm->flight_included==0)?'hide':'';?>">
                    <?= $form->field($CreateHotTourForm, 'depart_country_to')->dropDownList($departCountryDropdown,['prompt' => Yii::t('app','Choose destination')]);?>
                    <?= $form->field($CreateHotTourForm, 'depart_city_there')->dropDownList([]);?>

                    <?= $form->field($CreateHotTourForm, 'from_date')->widget(
                        \dosamigos\datepicker\DatePicker::className(), [
                        'inline' => false,
                        'options' => ['placeholder' => Yii::t('app', date('Y-M-d'))],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-m-d',
                            'todayHighlight' => true,
                            'startDate' => date('Y-M-d', strtotime('today'))
                        ]
                    ]);?>

                    <?= $form->field($CreateHotTourForm, 'voyage_there')->radioList([0 => '', 1 => ''],
                        ['item' => function($index, $label, $name, $checked, $value){
                            if($value == 0){
                                $checked = true;
                                $span = Html::tag('span', Yii::t('app','Voyage'), ['class' => 'type-name']);
                            }elseif($value == 1){
                                $span = Html::tag('span', Yii::t('app','Voyage is not direct'), ['class' => 'line-name']);
                            }
                            $checkbox = Html::radio($name, $checked, ['value' => $value]);
                            return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one type']);
                        }])->label('');?>
                    <!--<div class="voyage_through_there">
                    <?= $form->field($CreateHotTourForm, 'voyage_through_city_there')->dropDownList($departCityThereDropdown);?>
                </div>
                <?= $form->field($CreateHotTourForm, 'depart_country_from')->dropDownList($dropdownDestination,['prompt' => Yii::t('app','Choose destination')]);?>
                <?= $form->field($CreateHotTourForm, 'depart_city_from_there')->dropDownList([]);?>-->

                    <?= $form->field($CreateHotTourForm, 'to_date')->widget(
                        \dosamigos\datepicker\DatePicker::className(), [
                        'inline' => false,
                        'options' => ['placeholder' => Yii::t('app', date('Y-M-d'))],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-m-d',
                            'todayHighlight' => true,
                            'startDate' => date('Y-M-d', strtotime('today')),
                        ]
                    ]);?>

                    <!--<?= $form->field($CreateHotTourForm, 'voyage_from_there')->checkbox();?>
                <div class="voyage_through_from_there">
                    <?= $form->field($CreateHotTourForm, 'voyage_through_city_from_there')->dropDownList($departCityThereDropdown);?>
                </div>-->

                    <?= $form->field($CreateHotTourForm, 'tickets_exist')->radioList([0 => '', 1 => ''],
                        ['item' => function($index, $label, $name, $checked, $value){
                            if($value == 0){
                                $span = Html::tag('span', Yii::t('app','Little'), ['class' => 'line-name']);
                            }elseif($value == 1){
                                $span = Html::tag('span', Yii::t('app','Lot of'), ['class' => 'type-name']);
                            }
                            $checkbox = Html::radio($name, $checked, ['value' => $value]);
                            return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one type']);
                        }]);?>
                </div>
                <div>
                    <label class="col-xs-11 col-xs-offset-1 control-label label-add-paymnet" for="createhottourform-add-payment"><?=Yii::t('app', 'Add payment');?></label>
                    <?= $form->field($CreateHotTourForm, 'visa')->input('number', ['min' => 0, 'max' => 99000, 'step' => 100, 'value' => '']);?>
                    <?= $form->field($CreateHotTourForm, 'oil_tax')->input('number', ['min' => 0, 'max' => 99000, 'step' => 100, 'value' => '']);?>
                    <?= $form->field($CreateHotTourForm, 'add_payment')->checkbox();?>
                </div>



                <?= $form->field($CreateHotTourForm, 'deadline')->widget(
                    \dosamigos\datepicker\DatePicker::className(), [
                    'inline' => false,
                    'options' => ['placeholder' => Yii::t('app', date('Y-M-d'))],
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-m-d',
                        'todayHighlight' => true,
                        'startDate' => date('Y-M-d', strtotime('today')),
                        'endDate' => '+14d',
                    ]
                ]);?>


                <?php $CreateHotTourForm->medicine_insurance = 1;?>
                <?= $form->field($CreateHotTourForm, 'medicine_insurance')->checkbox();?>
                <?= $form->field($CreateHotTourForm, 'charge_manager')->checkbox();?>
                <?= $form->field($CreateHotTourForm, 'tour_cost', ['template' => "{label}\n<div class=\"col-xs-8 col-xs-offset-1 \">{input}</div>\n<div class=\"input-group-addon\">".Yii::$app->user->identity->city->country->currency->name."</div><div class=\"col-xs-8 col-xs-offset-1\">{error}</div>"])->input('number', ['min' => 0, 'max' => 99000, 'step' => 500, 'value' => '']);?>

                <?php $CreateHotTourForm->is_hot_tour = 1;?>
                <?= $form->field($CreateHotTourForm, 'is_hot_tour')->hiddenInput()->label('');?>

                <?= Html::a('', Url::toRoute(['tour/ajax-resorts-dropdown']), ['class' => 'ajax-resort']);?>
                <?= Html::a('', Url::toRoute(['tour/get-user-tour-list']), ['class' => 'ajax-user-tour-list']);?>

                <div class="form-group">
                    <div class="col-xs-11 col-xs-offset-1">
                        <?= Html::submitButton(Yii::t('app','Create a hot tour'), ['class' => 'btn btn-success col-xs-12 inactive', 'name' => 'create-tour-button', 'id' => 'create-hot-tour']) ?>
                    </div>
                </div>

                <?php ActiveForm::end() ;?>
            </div>
            <div class="col-md-8 manager-hot-tour-container overflow-list">
                <div class="loader-bg hide"><img src="/images/loader.gif"></div>
                <div id="create-hot-tour-response">

                </div>
            </div>
        </div>
        <div class="col-md-3 right-data">
            <div class="main-data">
                <?= \app\components\ManagerTourStatisticsWidget::widget();?>
            </div>
            <div id="right-data-response-hot-tour">

            </div>
        </div>
    </div>
    <div class="col-xs-12 full-hotel-information close-tab" data-tab-class="hot-tour">

    </div>
    <?= Html::a('', Url::toRoute(['tour/ajax-hotels-autocomplete-manager']), ['class' => 'ajax-hotel-autocomplete-manager']);?>
</div>