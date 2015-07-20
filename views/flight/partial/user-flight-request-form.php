<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
?>

<?php $form = ActiveForm::begin([
    'id' => 'user-flight-form',
    'action' => Url::toRoute(['flight/submit-user-flight']),
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-xs-11 col-xs-offset-1 \">{input}</div>\n<div class=\"col-xs-11 col-xs-offset-1\">{error}</div>",
        'labelOptions' => ['class' => 'col-xs-11 col-xs-offset-1 control-label label-get-tour'],
    ],
]); ?>

<?= $form->field($UserFlightForm, 'destination')->dropDownList($destinationDropdown,['prompt' => Yii::t('app','Choose destination')]);?>

<?= $form->field($UserFlightForm, 'resort')->dropDownList([],['prompt' => Yii::t('app','Choose destination')]);?>

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

<?= $form->field($UserFlightForm, 'depart_city')->dropDownList($departCityDropdown);?>

<?= $form->field($UserFlightForm, 'date_city_to_since')->widget(
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

<?= $form->field($UserFlightForm, 'date_city_to_until')->widget(
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

<?= $form->field($UserFlightForm, 'date_city_from_since')->widget(
    DatePicker::className(), [
    'inline' => false,
    'options' => ['placeholder' => Yii::t('app', date('Y-M-d'))],
    'clientOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-m-d',
        'todayHighlight' => true,
        'startDate' => date('Y-M-d', strtotime('+5 days')),
    ]
]);?>

<?= $form->field($UserFlightForm, 'date_city_from_until')->widget(
    DatePicker::className(), [
    'inline' => false,
    'options' => ['placeholder' => Yii::t('app', 'To date')],
    'clientOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-m-d',
        'todayHighlight' => true,
        'startDate' => date('Y-M-d', strtotime('+7 days'))
    ]
]);?>

<?= $form->field($UserFlightForm, 'adult_count_senior_24')->dropDownList([1 => 1, 2 => 2, 3 => 3]);?>
<?= $form->field($UserFlightForm, 'adult_count_under_24')->dropDownList([0 => 0, 1 => 1, 2 => 2]);?>
<?= $form->field($UserFlightForm, 'children_under_12_amount')->dropDownList([0 => 0, 1 => 1, 2 => 2]);?>
<?= $form->field($UserFlightForm, 'children_under_2_amount')->dropDownList([0 => 0, 1 => 1, 2 => 2]);?>

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

<?= $form->field($UserFlightForm, 'direct_flight')->checkbox();?>
<?= $form->field($UserFlightForm, 'regular_flight')->checkbox();?>

<div class="form-group">
    <div class="col-xs-11 col-xs-offset-1">
        <?= Html::submitButton(Yii::t('app','Request flight'), ['class' => 'btn btn-success col-xs-12', 'name' => 'get-flight-button', 'id' => 'submit-flight']) ?>
    </div>
</div>

<?php ActiveForm::end();?>