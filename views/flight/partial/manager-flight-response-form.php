<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
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

<?= $form->field($ManagerFlightForm, 'depart_country_to')->dropDownList($departCountryDropdown,['prompt' => Yii::t('app','Choose destination')]);?>
<?= $form->field($ManagerFlightForm, 'depart_city_to')->dropDownList([]);?>

<?= $form->field($ManagerFlightForm, 'date_city_to')->widget(DateTimePicker::className(), [
    //'language' => Yii::$app->language,
    'size' => 'ms',
    'template' => '{input}',
    'pickButtonIcon' => 'glyphicon glyphicon-time',
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
    <?= $form->field($ManagerFlightForm, 'voyage_direct_country_to')->dropDownList($departCountryDropdown,['prompt' => Yii::t('app','Choose destination')]);?>
    <?= $form->field($ManagerFlightForm, 'voyage_direct_to')->dropDownList([]);?>
    <?= $form->field($ManagerFlightForm, 'date_docking_to_hours')->dropDownList([0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21, 22 => 22, 23 => 23, 24 => 24]);?>
    <?= $form->field($ManagerFlightForm, 'date_docking_to_minutes')->dropDownList([0 => 0, 5 => 5, 10 => 10, 15 => 15, 20 => 20, 25 => 25, 30 => 30, 35 => 35, 40 => 40, 45 => 45, 50 => 50, 55 => 55, 60 => 60]);?>
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
        <?= $form->field($ManagerFlightForm, 'voyage_direct_country_from')->dropDownList($departCountryDropdown,['prompt' => Yii::t('app','Choose destination')]);?>
        <?= $form->field($ManagerFlightForm, 'voyage_direct_from')->dropDownList([]);?>
        <?= $form->field($ManagerFlightForm, 'date_docking_from_hours')->dropDownList([0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21, 22 => 22, 23 => 23, 24 => 24]);?>
        <?= $form->field($ManagerFlightForm, 'date_docking_from_minutes')->dropDownList([0 => 0, 5 => 5, 10 => 10, 15 => 15, 20 => 20, 25 => 25, 30 => 30, 35 => 35, 40 => 40, 45 => 45, 50 => 50, 55 => 55, 60 => 60]);?>
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

<?= $form->field($ManagerFlightForm, 'adult_count_senior_24')->input('text', ['disabled' => true]);?>
<?= $form->field($ManagerFlightForm, 'adult_count_under_24')->input('text', ['disabled' => true]);?>
<?= $form->field($ManagerFlightForm, 'children_under_12_amount')->input('text', ['disabled' => true]);?>
<?= $form->field($ManagerFlightForm, 'children_under_2_amount')->input('text', ['disabled' => true]);?>

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
<?= $form->field($ManagerFlightForm, 'flight_cost')->input('number', ['min' => 0, 'max' => 99000, 'step' => 100]);?>

<?= $form->field($ManagerFlightForm, 'user_id')->hiddenInput()->label('');?>
<?= $form->field($ManagerFlightForm, 'from_flight_id')->hiddenInput()->label('');?>
<div class="form-group">
    <div class="col-xs-11 col-xs-offset-1">
        <?= Html::submitButton(Yii::t('app','Request answer'), ['class' => 'btn btn-success col-xs-12 inactive', 'name' => 'create-flight-button', 'id' => 'create-flight-response']) ?>
    </div>
</div>

<?php ActiveForm::end() ;?>