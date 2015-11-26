<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\date\DatePicker;
?>
<?php $form = \yii\widgets\ActiveForm::begin([
    'id' => 'manager-tour-response-form',
    'action' => Url::toRoute(['tour/create-tour-manager']),
    'enableClientValidation' => false,
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-xs-11 col-xs-offset-1 \">{input}</div>\n<div class=\"col-xs-11 col-xs-offset-1\">{error}</div>",
        'labelOptions' => ['class' => 'col-xs-11 col-xs-offset-1 control-label label-get-tour'],
    ],
]); ?>


<?= $form->field($CreateTourForm, 'destination')->dropDownList($dropdownDestination);?>

<?= $form->field($CreateTourForm, 'resort')->dropDownList($dropdownResort);?>

<?php if(!empty($dropdownHotel)):?>
    <?= $form->field($CreateTourForm, 'hotel', ['template' => '{label}<div class="col-xs-11 col-xs-offset-1 create-tour-response">{input}</div><div class="col-xs-11 col-xs-offset-1">{error}</div>'])->input('text', ['disabled' => "disabled"]) ?>
<?php else:?>
    <?= $form->field($CreateTourForm, 'hotel', ['template' => '{label}<div class="col-xs-11 col-xs-offset-1 create-tour-response">{input}<i class="glyphicon glyphicon-remove-circle remove-hotel-name-manager"></i></div><div class="col-xs-11 col-xs-offset-1">{error}</div>'])->input('text') ?>
<?php endif;?>
<?= $form->field($CreateTourForm, 'hotel_id')->dropDownList($dropdownHotel, ['multiple' => true])->label('');?>

<?= $form->field($CreateTourForm, 'hotel_star')->hiddenInput()->label('');?>

<?php if(!empty($dropdownHotel)):?>
<?= $form->field($CreateTourForm, 'stars')->checkboxList([404 => '', 403 => '', 402 => '', 401 => '', 400 => ''],
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
        $checkbox = Html::checkbox($name, $checked, ['value' => $value, 'disabled' => 'disabled']);
        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox']);
    }]);?>
<?php else:?>
    <?= $form->field($CreateTourForm, 'stars')->checkboxList([404 => '', 403 => '', 402 => '', 401 => '', 400 => ''],
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
<?php endif;?>

    <!--LETTER FILTER-->
<!--<?= $form->field($CreateTourForm, 'letter_filter')->checkboxList(['a' => '', 'b' => '', 'c' => '', 'd' => '',
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

<?= $form->field($CreateTourForm, 'nutrition')->radioList([0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => '', 8 => ''],
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

<?= $form->field($CreateTourForm, 'night_count')->input('number', ['min' => 1, 'max' => 99, 'step' => 1, 'value' => '']);?>
<?= $form->field($CreateTourForm, 'location')->radioList([0 => '', 1 => '', 2 => '', 3 => ''],
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
<?= $form->field($CreateTourForm, 'room_type')->radioList([1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => '', 8 => '', 9 => '', 10 => '', 11 => '', 12 => ''],
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

<?= $form->field($CreateTourForm, 'hotel_type')->radioList([0 => '', 1 => '', 2 => '', 3 => '', 4 => ''],
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

<?= $form->field($CreateTourForm, 'beach_line')->radioList([0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => ''],
    ['item' => function($index, $label, $name, $checked, $value){
        if($value == 0){
            $checked = true;
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

<?= $form->field($CreateTourForm, 'room_view')->radioList([0 => '', 1 => '', 2 => '', 3 => '', 4 => ''],
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

<?= $form->field($CreateTourForm, 'adult_amount')->input('text', ['class' => 'form-control disabled']);?>
<?= $form->field($CreateTourForm, 'children_under_12_amount')->input('text', ['class' => 'form-control disabled']);?>
<?= $form->field($CreateTourForm, 'children_under_2_amount')->input('text', ['class' => 'form-control disabled']);?>
<?= $form->field($CreateTourForm, 'room_count')->dropDownList([1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21]);?>
<?= $form->field($CreateTourForm, 'flight_included')->checkbox(['readonly' => true]);?>

<div class="flight-included <?=($CreateTourForm->flight_included==0)?'hide':'';?>">
    <?= $form->field($CreateTourForm, 'depart_country_there')->dropDownList($dropdownDepartCountries, ['prompt' => Yii::t('app','Choose destination')]);?>
    <?= $form->field($CreateTourForm, 'depart_city_there')->dropDownList($destinationCityDropdown, ['prompt' => Yii::t('app','Airport location')]);?>


    <?=$form->field($CreateTourForm, 'from_date')->widget(DatePicker::classname(), [
        'options' => [
            'placeholder' => Yii::t('app', date('Y-m-d'))
        ],
        'removeButton' => false,
        'pluginOptions' => [
            'autoclose'=>true,
            'todayHighlight' => true,
            'todayBtn' => true,
            'format' => 'yyyy-m-dd',
        ]
    ]);?>

    <?= $form->field($CreateTourForm, 'voyage_there')->checkbox();?>
    <!--<div class="voyage_through_there">
        <?= $form->field($CreateTourForm, 'voyage_through_city_there')->dropDownList($departCityThereDropdown);?>
    </div>
    <?= $form->field($CreateTourForm, 'depart_city_from_there')->dropDownList($dropdownResort);?>-->

    <?=$form->field($CreateTourForm, 'to_date')->widget(DatePicker::classname(), [
        'options' => [
            'placeholder' => Yii::t('app', date('Y-m-d'))
        ],
        'removeButton' => false,
        'pluginOptions' => [
            'autoclose'=>true,
            'todayHighlight' => true,
            'todayBtn' => true,
            'format' => 'yyyy-m-dd',
        ]
    ]);?>

    <?= $form->field($CreateTourForm, 'voyage_from_there')->checkbox();?>
    <!--<div class="voyage_through_from_there">
        <?= $form->field($CreateTourForm, 'voyage_through_city_from_there')->dropDownList($destinationCityDropdown);?>
    </div>-->
</div>

    <div>
        <label class="col-xs-11 col-xs-offset-1 control-label label-add-paymnet" for="createtourform-add-payment"><?=Yii::t('app', 'Add payment');?></label>
        <?= $form->field($CreateTourForm, 'visa', ['template' => "{label}\n<div class=\"col-xs-8 col-xs-offset-1 \">{input}</div>\n<div class=\"input-group-addon\">".Yii::$app->user->identity->city->country->currency->name."</div><div class=\"col-xs-8 col-xs-offset-1\">{error}</div>"])->input('number', ['min' => 0, 'max' => 99000, 'step' => 100, 'value' => '']);?>
        <?= $form->field($CreateTourForm, 'oil_tax', ['template' => "{label}\n<div class=\"col-xs-8 col-xs-offset-1 \">{input}</div>\n<div class=\"input-group-addon\">".Yii::$app->user->identity->city->country->currency->name."</div><div class=\"col-xs-8 col-xs-offset-1\">{error}</div>"])->input('number', ['min' => 0, 'max' => 99000, 'step' => 100, 'value' => '']);?>
        <?= $form->field($CreateTourForm, 'add_payment')->checkbox();?>
    </div>
<?= $form->field($CreateTourForm, 'tickets_exist')->radioList([0 => '', 1 => ''],
    ['item' => function($index, $label, $name, $checked, $value){
        if($value == 0){
            $checked = true;
            $span = Html::tag('span', Yii::t('app','Little'), ['class' => 'line-name']);
        }elseif($value == 1){
            $span = Html::tag('span', Yii::t('app','Lot of'), ['class' => 'type-name']);
        }
        $checkbox = Html::radio($name, $checked, ['value' => $value]);
        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one type']);
    }]);?>
<?= $form->field($CreateTourForm, 'medicine_insurance')->checkbox();?>
<?= $form->field($CreateTourForm, 'charge_manager')->checkbox();?>
<?= $form->field($CreateTourForm, 'tour_cost', ['template' => "{label}\n<div class=\"col-xs-8 col-xs-offset-1 \">{input}</div>\n<div class=\"input-group-addon\">".Yii::$app->user->identity->city->country->currency->name."</div><div class=\"col-xs-8 col-xs-offset-1\">{error}</div>"])->input('number', ['min' => 0, 'max' => 99999999, 'step' => 100, 'value' => '']);?>
<?= $form->field($CreateTourForm, 'user_id')->hiddenInput()->label('');?>
<?= $form->field($CreateTourForm, 'from_tour_id')->hiddenInput()->label('');?>
<?= $form->field($CreateTourForm, 'is_hot_tour')->hiddenInput()->label('');?>

<?= Html::a('', Url::toRoute(['tour/ajax-resorts-dropdown']), ['class' => 'ajax-resort']);?>
<?= Html::a('', Url::toRoute(['tour/get-user-tour-list']), ['class' => 'ajax-user-tour-list']);?>

<div class="form-group">
    <div class="col-xs-11 col-xs-offset-1">
        <?= Html::submitButton(Yii::t('app','Submit Offer'), ['class' => 'btn btn-success col-xs-12', 'name' => 'create-tour-button', 'id' => 'create-tour-response']) ?>
    </div>
</div>

<?php  \yii\widgets\ActiveForm::end() ;?>