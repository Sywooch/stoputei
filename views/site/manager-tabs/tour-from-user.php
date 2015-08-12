<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row filter-tour">
    <span class="back-to-main" data-tab-class="manager-response">
        <i class="glyphicon glyphicon-menu-right hide"></i>
    </span>
    <div class="main-tab-container tour-from-user-tab-container col-xs-12" data-tab-class="manager-response">
    <div class="col-md-9 left-data">
        <div class="col-md-4 create-tour overflow-list inactive">
        <?=$responseForm;?>
        </div>
        <div class="col-md-8 user-tour-container overflow-list">
            <div class="loader-bg hide"><img src="/images/loader.gif"></div>
            <div id="user-tour-response">
                <div class="list-data">
                    <?=$userTours;?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 right-data">
        <div class="main-data">
            Statistics
        </div>
        <div id="right-data-response">

        </div>
    </div>
    </div>
    <div class="col-xs-12 full-hotel-information" data-tab-class="manager-response">

    </div>

</div>