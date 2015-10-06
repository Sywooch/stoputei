<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row user-favourite-tours">
    <span class="back-to-main back-to-main-from-tour to-right" data-tab-class="user-favourite-tours">
        <span class="text"><?=Yii::t('app', 'Rollback');?></span>
    </span>
    <div class="main-tab-container user-favourites-tours-tab-container col-xs-12" data-tab-class="user-favourite-tours">
        <div class="col-md-9 left-data">
            <div class="col-md-4 user-favourite-tours overflow-list filter">
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
            <div class="col-md-8 user-favourite-tours overflow-list">
                <div class="loader-bg hide"><img src="/images/loader.gif"></div>
                <div id="user-favourite-tours-response">
                    <div class="list-data">
                        <?=$userFavouriteToursList;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 right-data">
            <div class="main-data">
                <?= \app\components\TopHotelsWidget::widget(['page' => 'user-hot-tours']);?>
            </div>
            <div id="right-data-response-user-favourite-tours">

            </div>
            <div class="col-xs-12 full-tour-information close-tab" data-tab-class="user-favourite-tours">

            </div>
        </div>
    </div>
    <div class="col-xs-12 full-hotel-information close-tab" data-tab-class="user-favourite-tours">

    </div>
</div>
