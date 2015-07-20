<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use dosamigos\datetimepicker\DateTimePicker;
?>
<?php $form = ActiveForm::begin([
    'id' => 'manager-flight-response-form',
    'action' => Url::toRoute(['flight/create-flight-manager']),
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-xs-11 col-xs-offset-1 \">{input}</div>\n<div class=\"col-xs-11 col-xs-offset-1\">{error}</div>",
        'labelOptions' => ['class' => 'col-xs-11 col-xs-offset-1 control-label label-response-flight'],
    ],
]); ?>


<?= $form->field($ManagerFlightForm, 'destination')->dropDownList($dropdownDestination);?>

<?= $form->field($ManagerFlightForm, 'resort')->dropDownList($dropdownResort);?>

<?= $form->field($ManagerFlightForm, 'way_ticket')->radioList([1 => '', 2 => ''],
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

<?= $form->field($ManagerFlightForm, 'depart_city_to')->dropDownList($departCityDropdown);?>

<?= $form->field($ManagerFlightForm, 'date_city_to')->widget(DateTimePicker::className(), [
    //'language' => Yii::$app->language,
    'size' => 'ms',
    'template' => '{input}',
    //'pickButtonIcon' => 'glyphicon glyphicon-time',
    'inline' => false,
    'clientOptions' => [
        //'startView' => 1,
        'minView' => 0,
        'maxView' => 1,
        'autoclose' => true,
        //'linkFormat' => 'HH:ii P', // if inline = true
        'format' => 'yyyy-mm-dd hh:ii:ss', // if inline = false
        'todayBtn' => true
    ]
]);?>
<?= $form->field($ManagerFlightForm, 'voyage_is_direct_to')->checkbox();?>
<div class="voyage_is_direct_to hide">
    <?= $form->field($ManagerFlightForm, 'voyage_direct_to')->dropDownList($departCityDropdown);?>
    <?= $form->field($ManagerFlightForm, 'date_docking_to_hours')->dropDownList([0 => 0, 1 => 1, 2 => 2, 3 => 3]);?>
    <?= $form->field($ManagerFlightForm, 'date_docking_to_minutes')->dropDownList([0 => 0, 5 => 5, 10 => 10, 15 => 15, 20 => 20]);?>
</div>

<div class="way_ticket_two <?=($ManagerFlightForm->way_ticket==1)?'hide':'';?>">
    <?= $form->field($ManagerFlightForm, 'depart_city_from')->dropDownList($dropdownDepartCityFrom);?>

    <?= $form->field($ManagerFlightForm, 'date_city_from')->widget(DateTimePicker::className(), [
        //'language' => Yii::$app->language,
        'size' => 'ms',
        'template' => '{input}',
        //'pickButtonIcon' => 'glyphicon glyphicon-time',
        'inline' => false,
        'clientOptions' => [
            //'startView' => 1,
            'minView' => 0,
            'maxView' => 1,
            'autoclose' => true,
            //'linkFormat' => 'HH:ii P', // if inline = true
            'format' => 'yyyy-mm-dd hh:ii:ss', // if inline = false
            'todayBtn' => true
        ]
    ]);?>

    <?= $form->field($ManagerFlightForm, 'voyage_is_direct_from')->checkbox();?>
    <div class="voyage_is_direct_from hide">
        <?= $form->field($ManagerFlightForm, 'voyage_direct_from')->dropDownList($departCityDropdown);?>
        <?= $form->field($ManagerFlightForm, 'date_docking_from_hours')->dropDownList([0 => 0, 1 => 1, 2 => 2, 3 => 3]);?>
        <?= $form->field($ManagerFlightForm, 'date_docking_from_minutes')->dropDownList([0 => 0, 5 => 5, 10 => 10, 15 => 15, 20 => 20]);?>
    </div>
</div>

<?= $form->field($ManagerFlightForm, 'tickets_exist')->radioList([0 => '', 1 => ''],
    ['item' => function($index, $label, $name, $checked, $value){
        if($value == 0){
            $checked = true;
            $span = Html::tag('span', Yii::t('app','Little'), ['class' => 'line-name']);
        }elseif($value == 1){
            $span = Html::tag('span', Yii::t('app','Lot of'), ['class' => 'line-name']);
        }
        $checkbox = Html::radio($name, $checked, ['value' => $value]);
        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one type']);
    }]);?>

<?= $form->field($ManagerFlightForm, 'adult_count_senior_24')->dropDownList([1 => 1, 2 => 2, 3 => 3]);?>
<?= $form->field($ManagerFlightForm, 'adult_count_under_24')->dropDownList([0 => 0, 1 => 1, 2 => 2]);?>
<?= $form->field($ManagerFlightForm, 'children_under_12_amount')->dropDownList([0 => 0, 1 => 1, 2 => 2]);?>
<?= $form->field($ManagerFlightForm, 'children_under_2_amount')->dropDownList([0 => 0, 1 => 1, 2 => 2]);?>

<?= $form->field($ManagerFlightForm, 'flight_class')->checkboxList([1 => '', 2 => ''],
    ['item' => function($index, $label, $name, $checked, $value){
        if($value == 1){
            $span = Html::tag('span', Yii::t('app','Economy class'), ['class' => 'line-name']);
        }elseif($value == 2){
            $span = Html::tag('span', Yii::t('app','Business class'), ['class' => 'line-name']);
        }
        $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
        return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one type']);
    }]);?>

<?= $form->field($ManagerFlightForm, 'charter_flight')->checkbox();?>
<?= $form->field($ManagerFlightForm, 'regular_flight')->checkbox();?>
<?= $form->field($ManagerFlightForm, 'flight_cost')->input('number', ['min' => 0, 'max' => 99000000, 'step' => 100]);?>

<?= $form->field($ManagerFlightForm, 'user_id')->hiddenInput()->label('');?>
<?= $form->field($ManagerFlightForm, 'from_flight_id')->hiddenInput()->label('');?>
<div class="form-group">
    <div class="col-xs-11 col-xs-offset-1">
        <?= Html::submitButton(Yii::t('app','Request on flight'), ['class' => 'btn btn-success col-xs-12 inactive', 'name' => 'create-flight-button', 'id' => 'create-flight-response']) ?>
    </div>
</div>

<?php ActiveForm::end() ;?>