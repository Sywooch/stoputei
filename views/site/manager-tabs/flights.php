<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row filter-tour">
    <div class="col-md-9 left-data">
        <div class="col-md-4 create-flight overflow-list inactive">
            <?=$responseForm;?>
        </div>
        <div class="col-md-8 manager-flight-container overflow-list">
            <div class="loader-bg hide"><img src="/images/loader.gif"></div>
            <div id="manager-flight-response">
                <?=$userFlights;?>
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