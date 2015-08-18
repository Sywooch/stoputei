<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row filter-tour">
    <div class="main-tab-container flights-manager-tab-container col-xs-12">
    <div class="col-md-9 left-data">
        <div class="col-md-4 create-flight overflow-list inactive">
            <?=$responseForm;?>
        </div>
        <div class="col-md-8 manager-flight-container overflow-list">
            <div class="loader-bg hide"><img src="/images/loader.gif"></div>
            <div id="manager-flight-response">
                <?= Html::dropDownList('order-flight-list', 'id', [
                    //'a-to-z' => Yii::t('app','From A to Z'),
                    //'z-to-a' => Yii::t('app','From Z to A'),
                    '' => Yii::t('app','Order by'),
                    //'cheap-to-expensive' => Yii::t('app','From cheap to expensive'),
                    //'expensive-to-cheap' => Yii::t('app','From expensive to cheap'),
                    'new-to-old' => Yii::t('app','From new to old'),
                    'old-to-new' => Yii::t('app','From old to new')
                ], ['class' => 'form-control col-xs-7']) ?>
                <div class="list-data">
                    <?=$userFlights;?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 right-data">
        <div class="main-data">
            Statistics
        </div>
        <div id="right-data-response-flight">

        </div>
    </div>
    </div>

</div>