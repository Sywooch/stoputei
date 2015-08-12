<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row user-favourite-tours">
    <span class="back-to-main" data-tab-class="user-favourite-tours">
        <i class="glyphicon glyphicon-menu-right hide"></i>
    </span>
    <div class="main-tab-container user-favourites-tours-tab-container col-xs-12" data-tab-class="user-favourite-tours">
        <div class="col-md-9 left-data">
            <div class="col-md-4 user-favourite-tours overflow-list">
                <?php $form = ActiveForm::begin([
                    'id' => 'user-favourite-tours-form',
                    'action' => Url::toRoute(['/']),
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-xs-11 col-xs-offset-1 \">{input}</div>\n<div class=\"col-xs-11 col-xs-offset-1\">{error}</div>",
                        'labelOptions' => ['class' => 'col-xs-11 col-xs-offset-1 control-label label-get-tour'],
                    ],
                ]); ?>
                <?= $form->field($UserFavouriteForm, 'destination')->dropDownList($destinationDropdown,['prompt' => Yii::t('app','All destinations')]);?>

                <?php ActiveForm::end();?>
            </div>
            <div class="col-md-8 user-hot-tours overflow-list">
                <div class="loader-bg hide"><img src="/images/loader.gif"></div>
                <div id="user-favourite-tours-response">
                    <?=$userFavouriteToursList;?>
                </div>
            </div>
        </div>
        <div class="col-md-3 right-data">
            <div class="main-data">
                Statistics
            </div>
            <div id="right-data-response-user-favourite-tours">

            </div>
        </div>
    </div>
    <div class="col-xs-12 full-tour-information close-tab" data-tab-class="user-favourite-tours">

    </div>
</div>
