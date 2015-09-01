<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="col-xs-12 widget-manager-stat">
    <?php $form = ActiveForm::begin([
        'id' => 'manager-tour-statistics-form',
        'action' => Url::toRoute(['/']),
        'options' => ['class' => 'form-horizontal widget-tour-stat-manager'],
    ]); ?>
    <?= $form->field($ManagerTourStatisticsForm, 'country_id', [
        'template' => "{label}\n<div class=\"col-xs-4 value-field\">$all_requests</div><div class=\"col-xs-8 select-field\" data-type=\"destination\">{input}</div>\n<div class=\"col-xs-7\">{error}</div>",
        'labelOptions' => ['class' => 'col-xs-12 control-label label-manager-stat'],
    ])->dropDownList($destinationDropdown,['prompt' => Yii::t('app','All destinations')]);?>

    <?= $form->field($ManagerTourStatisticsForm, 'request_tour_count', [
        'template' => "{label}\n<div class=\"col-xs-4 value-field\">$all_requests</div><div class=\"col-xs-8 select-field\" data-type=\"user-request\">{input}</div>\n<div class=\"col-xs-7\">{error}</div>",
        'labelOptions' => ['class' => 'col-xs-12 control-label label-manager-stat'],
    ])->dropDownList($periodDropdown);?>

    <?= $form->field($ManagerTourStatisticsForm, 'response_tour_count', [
        'template' => "{label}\n<div class=\"col-xs-4 value-field\">$all_responses</div><div class=\"col-xs-8 select-field\" data-type=\"manager-offer\">{input}</div>\n<div class=\"col-xs-7\">{error}</div>",
        'labelOptions' => ['class' => 'col-xs-12 control-label label-manager-stat'],
    ])->dropDownList($periodDropdown);?>

    <?= $form->field($ManagerTourStatisticsForm, 'hot_tour_count', [
        'template' => "{label}\n<div class=\"col-xs-4 value-field\">$all_hot_tours</div><div class=\"col-xs-8 select-field\" data-type=\"hot-tour\">{input}</div>\n<div class=\"col-xs-7\">{error}</div>",
        'labelOptions' => ['class' => 'col-xs-12 control-label label-manager-stat'],
    ])->dropDownList($periodDropdown);?>

    <?php ActiveForm::end();?>
    <?= Html::a('', Url::toRoute(['statistic/get-manager-tour-statistic']), ['class' => 'ajax-manager-tour-stat-destination']);?>
</div>