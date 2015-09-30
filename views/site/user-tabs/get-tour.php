<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
?>
<div class="row filter-tour">
    <span class="back-to-main back-to-main-from-user-get-tour" data-tab-class="get-tour">
        <span class="text"><?=Yii::t('app', 'Close tab');?></span>
    </span>
    <div class="main-tab-container get-tour-tab-container col-xs-12" data-tab-class="get-tour">
    <div class="col-md-9 left-data">
        <div class="col-md-4 filter tour-container overflow-list">
            <?php $form = ActiveForm::begin([
                'id' => 'get-tour-form',
                'enableClientValidation' => false,
                'action' => Url::toRoute(['tour/submit-tour-user']),
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-xs-11 col-xs-offset-1 \">{input}</div>\n<div class=\"col-xs-11 col-xs-offset-1\">{error}</div>",
                    'labelOptions' => ['class' => 'col-xs-11 col-xs-offset-1 control-label label-get-tour'],
                ],
            ]); ?>

            <?= $form->field($GetTourForm, 'destination')->dropDownList($destinationDropdown,['prompt' => Yii::t('app','Choose destination')]);?>

            <?= $form->field($GetTourForm, 'resort')->dropDownList([],['prompt' => Yii::t('app','Choose destination')]);?>

            <?= $form->field($GetTourForm, 'hotel', ['template' => '{label}<div class="col-xs-11 col-xs-offset-1 ">{input}<i class="glyphicon glyphicon-remove-circle remove-hotel-name-user-request"></i></div>'])->input('text') ?>

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

            <!--LETTER FILTER-->
            <!--<?php echo $form->field($GetTourForm, 'letter_filter')->checkboxList(['a' => '', 'b' => '', 'c' => '', 'd' => '',
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


            <?= $form->field($GetTourForm, 'nutrition')->checkboxList([0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => ''],
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
                    }elseif($value == 7){
                        $span = Html::tag('span', Yii::t('app','Soft AL'), ['class' => 'line-name', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => Yii::t('app', 'Soft All Inclusive')]);
                    }
                    $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
                    return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one col-xs-6']);
                }]);?>
            <?= $form->field($GetTourForm, 'beach_line')->checkboxList([0 => '', 1 => '', 2 => '', 3 => ''],
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
                    $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
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
            <div class="form-group field-gettourform-nights">
                <label class="col-xs-11 col-xs-offset-1 control-label label-get-tour nights"><?=Yii::t('app', 'Night count');?></label>
                 <?= $form->field($GetTourForm, 'night_min')->dropDownList([1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21]);?>
                 <?= $form->field($GetTourForm, 'night_max')->dropDownList([1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21]);?>
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
            <?= $form->field($GetTourForm, 'adult_amount')->dropDownList([1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20]);?>
            <?= $form->field($GetTourForm, 'children_under_12_amount')->dropDownList([0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20]);?>
            <?= $form->field($GetTourForm, 'children_under_2_amount')->dropDownList([0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17, 18 => 18, 19 => 19, 20 => 20]);?>
            <?= $form->field($GetTourForm, 'room_count')->input('number', ['min' => 0, 'max' => 10, 'step' => 1, 'value' => '']);?>
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
                        //'startDate' => date('Y-M-d', strtotime('today')),
                    ]
                ]);?>
            <?= $form->field($GetTourForm, 'exactly_date')->dropDownList([0 => Yii::t('app', 'Exactly date'), 1 => Yii::t('app', 'Closest date')]);?>

            <?= $form->field($GetTourForm, 'budget', ['template' => "{label}\n<div class=\"col-xs-8 col-xs-offset-1 \">{input}</div>\n<div class=\"input-group-addon\">".Yii::$app->user->identity->city->country->currency->name."</div><div class=\"col-xs-8 col-xs-offset-1\">{error}</div>"])->input('number', ['min' => 0, 'max' => 99000000, 'step' => 1000, 'value' => '']);?>

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
        <?= \app\components\TopHotelsWidget::widget(['page' => 'user-hot-tours']);?>
    </div>
    </div>
    <div class="col-xs-12 full-hotel-information close-tab" data-tab-class="get-tour">

    </div>
</div>