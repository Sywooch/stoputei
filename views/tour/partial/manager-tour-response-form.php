<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
?>
<?php $form = ActiveForm::begin([
    'id' => 'manager-tour-response-form',
    'action' => Url::toRoute(['tour/create-tour-manager']),
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-xs-11 col-xs-offset-1 \">{input}</div>\n<div class=\"col-xs-11 col-xs-offset-1\">{error}</div>",
        'labelOptions' => ['class' => 'col-xs-11 col-xs-offset-1 control-label label-get-tour'],
    ],
]); ?>


<?= $form->field($CreateTourForm, 'destination')->dropDownList($dropdownDestination);?>

<?= $form->field($CreateTourForm, 'resort')->dropDownList($dropdownResort);?>

<?= $form->field($CreateTourForm, 'hotel', ['template' => '{label}<div class="col-xs-11 col-xs-offset-1 create-tour-response">{input}<i class="glyphicon glyphicon-remove-circle remove-hotel-name-manager"></i></div>'])->input('text') ?>

<?= $form->field($CreateTourForm, 'hotel_id')->dropDownList([], ['multiple' => true])->label('');?>

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
<?= $form->field($CreateTourForm, 'nutrition')->checkboxList([0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => ''],
    ['item' => function($index, $label, $name, $checked, $value){
        if($value == 0){
            $span = Html::tag('span', Yii::t('app','RO'), ['class' => 'type-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Room only')]);
        }elseif($value == 1){
            $span = Html::tag('span', Yii::t('app','BB'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Bed & Breakfast')]);
        }elseif($value == 2){
            $span = Html::tag('span', Yii::t('app','HB'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Half Board (Breakfast and Dinner normally)')]);
        }elseif($value == 3){
            $span = Html::tag('span', Yii::t('app','HB+'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Half Board plus')]);
        }elseif($value == 4){
            $span = Html::tag('span', Yii::t('app','FB+'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Full Board plus')]);
        }elseif($value == 5){
            $span = Html::tag('span', Yii::t('app','AL'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'All Inclusive')]);
        }elseif($value == 6){
            $span = Html::tag('span', Yii::t('app','UAL'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Ultra All Inclusive')]);
        }
        $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one col-xs-6']);
    }]);?>

<?= $form->field($CreateTourForm, 'night_count')->dropDownList([1 => 1, 2 => 2, 3 => 3]);?>
<?= $form->field($CreateTourForm, 'location')->checkboxList([0 => '', 1 => '', 2 => '', 3 => ''],
    ['item' => function($index, $label, $name, $checked, $value){
        if($value == 0){
            $span = Html::tag('span', Yii::t('app','RO'), ['class' => 'location-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Single')]);
        }elseif($value == 1){
            $span = Html::tag('span', Yii::t('app','BB'), ['class' => 'location-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Double')]);
        }elseif($value == 2){
            $span = Html::tag('span', Yii::t('app','HB'), ['class' => 'location-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Triple')]);
        }elseif($value == 3){
            $span = Html::tag('span', Yii::t('app','HB+'), ['class' => 'location-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Quadriple')]);
        }
        $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one col-xs-6']);
    }]);?>
<?= $form->field($CreateTourForm, 'room_type')->checkboxList([0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => ''],
    ['item' => function($index, $label, $name, $checked, $value){
        if($value == 0){
            $span = Html::tag('span', Yii::t('app','Standart'), ['class' => 'type-name']);
        }elseif($value == 1){
            $span = Html::tag('span', Yii::t('app','Family'), ['class' => 'line-name']);
        }elseif($value == 2){
            $span = Html::tag('span', Yii::t('app','Deluxe'), ['class' => 'line-name']);
        }elseif($value == 3){
            $span = Html::tag('span', Yii::t('app','Suite'), ['class' => 'line-name']);
        }elseif($value == 4){
            $span = Html::tag('span', Yii::t('app','Villa'), ['class' => 'line-name']);
        }elseif($value == 5){
            $span = Html::tag('span', Yii::t('app','Apartments'), ['class' => 'line-name']);
        }elseif($value == 6){
            $span = Html::tag('span', Yii::t('app','Economy'), ['class' => 'line-name']);
        }elseif($value == 7){
            $span = Html::tag('span', Yii::t('app','Club'), ['class' => 'line-name']);
        }
        $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one col-xs-6']);
    }]);?>

<?= $form->field($CreateTourForm, 'hotel_type')->checkboxList([0 => '', 1 => '', 2 => '', 3 => ''],
    ['item' => function($index, $label, $name, $checked, $value){
        if($value == 0){
            $span = Html::tag('span', Yii::t('app','Teen'), ['class' => 'type-name']);
        }elseif($value == 1){
            $span = Html::tag('span', Yii::t('app','Family'), ['class' => 'line-name']);
        }elseif($value == 2){
            $span = Html::tag('span', Yii::t('app','Urban'), ['class' => 'line-name']);
        }elseif($value == 3){
            $span = Html::tag('span', Yii::t('app','Health'), ['class' => 'line-name']);
        }
        $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one type']);
    }]);?>

<?= $form->field($CreateTourForm, 'beach_line')->checkboxList([0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => ''],
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
        $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one col-xs-6']);
    }]);?>

<?= $form->field($CreateTourForm, 'room_view')->checkboxList([0 => '', 1 => '', 2 => '', 3 => ''],
    ['item' => function($index, $label, $name, $checked, $value){
        if($value == 0){
            $span = Html::tag('span', Yii::t('app','Land view'), ['class' => 'type-name']);
        }elseif($value == 1){
            $span = Html::tag('span', Yii::t('app','Sea view'), ['class' => 'line-name']);
        }elseif($value == 2){
            $span = Html::tag('span', Yii::t('app','Pool view'), ['class' => 'line-name']);
        }elseif($value == 3){
            $span = Html::tag('span', Yii::t('app','Garden view'), ['class' => 'line-name']);
        }
        $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one type']);
    }]);?>
<?= $form->field($CreateTourForm, 'adult_amount')->dropDownList([1 => 1, 2 => 2, 3 => 3]);?>
<?= $form->field($CreateTourForm, 'children_under_12_amount')->dropDownList([0 => 0, 1 => 1, 2 => 2, 3 => 3]);?>
<?= $form->field($CreateTourForm, 'children_under_2_amount')->dropDownList([0 => 0, 1 => 1, 2 => 2, 3 => 3]);?>
<?= $form->field($CreateTourForm, 'room_count')->dropDownList([1 => 1, 2 => 2, 3 => 3]);?>
<?= $form->field($CreateTourForm, 'flight_included')->checkbox();?>

<div class="flight-included hide">
    <?= $form->field($CreateTourForm, 'depart_city_there')->dropDownList($departCityThereDropdown);?>
    <?= $form->field($CreateTourForm, 'from_date')->widget(
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
    <?= $form->field($CreateTourForm, 'voyage_there')->checkbox();?>
    <div class="voyage_through_there">
        <?= $form->field($CreateTourForm, 'voyage_through_city_there')->dropDownList($departCityThereDropdown);?>
    </div>
    <?= $form->field($CreateTourForm, 'depart_city_from_there')->dropDownList($dropdownResort);?>
    <?= $form->field($CreateTourForm, 'to_date')->widget(
        DatePicker::className(), [
        'inline' => false,
        'options' => ['placeholder' => Yii::t('app', date('Y-M-d'))],
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-m-d',
            'todayHighlight' => true,
            'startDate' => date('Y-M-d', strtotime('+4 days')),
        ]
    ]);?>
    <?= $form->field($CreateTourForm, 'voyage_from_there')->checkbox();?>
    <div class="voyage_through_from_there">
        <?= $form->field($CreateTourForm, 'voyage_through_city_from_there')->dropDownList($departCityThereDropdown);?>
    </div>
</div>

<?= $form->field($CreateTourForm, 'add_payment')->checkbox();?>
    <div class="add-payment hide">
        <?= $form->field($CreateTourForm, 'visa')->input('number', ['min' => 0, 'max' => 99000, 'step' => 100]);?>
        <?= $form->field($CreateTourForm, 'oil_tax')->input('number', ['min' => 0, 'max' => 99000, 'step' => 100]);?>
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
<?= $form->field($CreateTourForm, 'tour_cost')->input('number', ['min' => 0, 'max' => 99000000, 'step' => 100]);?>
<?= $form->field($CreateTourForm, 'user_id')->hiddenInput()->label('');?>
<?= $form->field($CreateTourForm, 'from_tour_id')->hiddenInput()->label('');?>

<?= Html::a('', Url::toRoute(['tour/ajax-resorts-dropdown']), ['class' => 'ajax-resort']);?>
<?= Html::a('', Url::toRoute(['tour/get-user-tour-list']), ['class' => 'ajax-user-tour-list']);?>

<div class="form-group">
    <div class="col-xs-11 col-xs-offset-1">
        <?= Html::submitButton(Yii::t('app','Create a tour'), ['class' => 'btn btn-success col-xs-12 inactive', 'name' => 'create-tour-button', 'id' => 'create-tour-response']) ?>
    </div>
</div>

<?php ActiveForm::end() ;?>