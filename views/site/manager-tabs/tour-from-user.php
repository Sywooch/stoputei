<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use dosamigos\datepicker\DatePicker;
use yii\web\JsExpression;
?>
<div class="row filter-tour">
    <div class="col-md-9 left-data">
        <div class="col-md-4 create-tour inactive">
            <span class="wrapper-words"><?=Yii::t('app', 'Please, choose one tour for answer');?></span>
            <?php $form = ActiveForm::begin([
                'id' => 'create-tour-form',
                'action' => Url::toRoute(['tour/create-tour-manager']),
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-xs-11 col-xs-offset-1 \">{input}</div>\n<div class=\"col-xs-11 col-xs-offset-1\">{error}</div>",
                    'labelOptions' => ['class' => 'col-xs-11 col-xs-offset-1 control-label label-get-tour'],
                ],
            ]); ?>


            <?= $form->field($CreateTourForm, 'destination')->dropDownList($destinationDropdown,['prompt' => Yii::t('app','Choose destination')]);?>

            <?= $form->field($CreateTourForm, 'resort')->dropDownList([],['prompt' => Yii::t('app','Choose destination')]);?>

            <?= $form->field($CreateTourForm, 'hotel')->widget(AutoComplete::classname(), [
                'clientOptions' => [
                    'source' => new JsExpression(" $('.ajax-hotel-autocomplete').attr('href')"),
                    'autoFill'=>true,
                    'minLength'=>'0',
                    'select' => new JsExpression("function( event, ui ) {
                            console.log(ui);
                          }")
                ],
            ])->input('text') ?>

            <?= Html::a('', Url::toRoute(['tour/ajax-hotels-autocomplete']), ['class' => 'ajax-hotel-autocomplete']);?>


            <?= $form->field($CreateTourForm, 'stars')->checkboxList([404 => '', 403 => '', 402 => '', 401 => '', 400 => ''],
                ['item' => function($index, $label, $name, $checked, $value){
                    if($value == 404){
                        $checked = true;
                        $span = Html::tag('span', '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>', ['class' => 'star']);
                    }elseif($value == 403){
                        $span = Html::tag('span', '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i>', ['class' => 'star']);
                    }elseif($value == 402){
                        $checked = true;
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
                        $checked = true;
                        $span = Html::tag('span', Yii::t('app','RO'), ['class' => 'type-name']);
                    }elseif($value == 1){
                        $span = Html::tag('span', Yii::t('app','BB'), ['class' => 'line-name']);
                    }elseif($value == 2){
                        $span = Html::tag('span', Yii::t('app','HB'), ['class' => 'line-name']);
                    }elseif($value == 3){
                        $span = Html::tag('span', Yii::t('app','HB+'), ['class' => 'line-name']);
                    }elseif($value == 4){
                        $span = Html::tag('span', Yii::t('app','FB+'), ['class' => 'line-name']);
                    }elseif($value == 5){
                        $span = Html::tag('span', Yii::t('app','AL'), ['class' => 'line-name']);
                    }elseif($value == 6){
                        $span = Html::tag('span', Yii::t('app','UAL'), ['class' => 'line-name']);
                    }
                    $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
                    return Html::tag('div', Html::label($span.$checkbox . $label), ['class' => 'checkbox-one col-xs-6']);
                }]);?>

            <?= Html::a('', Url::toRoute(['tour/ajax-resorts-dropdown']), ['class' => 'ajax-resort']);?>
            <?= Html::a('', Url::toRoute(['tour/get-user-tour-list']), ['class' => 'ajax-user-tour-list']);?>

            <div class="form-group">
                <div class="col-xs-11 col-xs-offset-1">
                    <?= Html::submitButton(Yii::t('app','Create a tour'), ['class' => 'btn btn-success col-xs-12 inactive', 'name' => 'create-tour-button', 'id' => 'create-tour-response']) ?>
                </div>
            </div>

            <?php ActiveForm::end() ;?>
        </div>
        <div class="col-md-8 user-tour-container">
            <div class="loader-bg hide"><img src="/images/loader.gif"></div>
            <div id="user-tour-response">
                <?=$userTours;?>
            </div>
            <?= Html::a('', Url::toRoute(['tour/get-user-tour-full-info']), ['class' => 'ajax-user-tour-full-info']);?>
        </div>
    </div>
    <div class="col-md-3 right-data">
        Statistics
    </div>
</div>