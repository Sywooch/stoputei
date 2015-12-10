<?php
use app\models\FlightResponse;
$flight_class = '';
switch($flight->flight_class){
    case 0:
        $flight_class = Yii::t('app', 'Any class');
        break;
    case 1:
        $flight_class = Yii::t('app', 'Economy class');
        break;
    case 2:
        $flight_class = Yii::t('app', 'Business class');
        break;
}
$flight_way = ($flight->way_ticket == 1)?Yii::t('app', 'One way'):Yii::t('app', 'Two way');
$date_city_to_since = date('d.m.Y', strtotime($flight->date_city_to_since));
$date_city_from_since = date('d.m.Y', strtotime($flight->date_city_from_since));
$flightResponse = new FlightResponse();
$responseCount = $flightResponse->hasResponse($flight->id);
?>
<div class="col-xs-12 flight-wrapper" data-flight-id="<?=$flight->id;?>">
    <div class="col-xs-12 header">
        <span class="count"><?=Yii::t('app', 'Ticket').' № '.$flight->id;?>
        </span><span class="created"><?=date('d.m.Y H:i:s', $flight->created_at);?></span>
        <?php if($responseCount > 0):?>
            <span class="response">
                <i class="glyphicon glyphicon-ok-circle"></i>
                <span class="view-count">(<?=Yii::t('app', 'offers: {n}',['n' => $responseCount]);?>)</span>
            </span>
        <?php endif;?>
    </div>
    <div class="col-xs-12 body">
        <div class="col-xs-5">
            <div>
                <span class="describe"><?=Yii::t('app', 'Destination');?> : </span><span class="value"><?=$flight->country->name;?></span>
            </div>
            <?php if($flight->city):?>
            <div>
                <span class="describe"><?=Yii::t('app', 'Resort');?> : </span><span class="value"><?=$flight->city->name;?></span>
            </div>
            <?php endif;?>
            <div>
                <span class="value"><?=$flight_way;?></span>
            </div>
            <div>
                <span class="describe"><?=Yii::t('app', 'Flight class');?> : </span><span class="value"><?=$flight_class;?></span>
            </div>
        </div>
        <div class="col-xs-5">
            <div>
                <?php if(!is_null($flight->departCity)):?>
                    <span class="describe"><?=Yii::t('app', 'Depart city to');?> : </span><span class="value"><?=$flight->departCity->name;?>(<?=$flight->departCity->country->name;?>)</span>
                <?php endif;?>
            </div>
            <div>
                <span class="describe"><?=Yii::t('app', 'Since');?> </span><span class="value"><?=$date_city_to_since;?></span>
                <span class="value"><?=\app\models\UserFlight::getExactlyDate($flight->exactly_date_to_since);?></span>
            </div>
            <?php if($flight->way_ticket == 2):?>
            <div>
                <span class="describe"><?=Yii::t('app', 'Until');?> </span><span class="value"><?=$date_city_from_since;?></span>
                <span class="value"><?=\app\models\UserFlight::getExactlyDate($flight->exactly_date_from_since);?></span>
            </div>
            <?php endif;?>
        </div>
        <div class="col-xs-2 buttons">
            <a href="#" class="more-flight-info btn btn-primary" data-flight-id="<?=$flight->id;?>"><?= Yii::t('app', 'More');?></a>
        </div>
    </div>
</div>