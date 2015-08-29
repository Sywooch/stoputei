<?php
$date = date(('d.m.Y H:i:s'), $flight->created_at);
$date_city_to_since = date('d.m.Y', strtotime($flight->date_city_to_since));
$date_city_from_since = date('d.m.Y', strtotime($flight->date_city_from_since));
$flight_way = ($flight->way_ticket == 1)?Yii::t('app', 'One way'):Yii::t('app', 'Two way');
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
?>
<div class="col-xs-12 user-flight-full-info">
    <div class="col-xs-12 header">
        <span><?=Yii::t('app', 'Ticket').' № '.$flight->id;?></span>
        <span><?=$date;?></span>
    </div>
    <div class="col-xs-12 body">
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Destination');?> : </span>
            <span class="value"><?=$flight->country->name;?></span>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Resort');?> : </span>
            <span class="value"><?=$flight->city->name;?></span>
        </div>
        <div class="field">
            <span class="value"><?=$flight_way;?></span>
        </div>

        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Amount of adult senior 24 years old');?> </span>
            <span class="value"><?=$flight->adult_count_senior_24;?></span>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Amount of adult under 24 years old');?> </span>
            <span class="value"><?=$flight->adult_count_under_24;?></span>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Amount of children (under 12 years old)');?> </span>
            <span class="value"><?=$flight->children_under_12_amount;?></span>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Amount of children (under 2 years old)');?> </span>
            <span class="value"><?=$flight->children_under_2_amount;?></span>
        </div>

        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Flight class');?> : </span>
            <span class="value"><?=$flight_class;?></span>
        </div>

        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Depart city to');?> : </span>
            <span class="value"><?=($flight->departCity)?$flight->departCity->name:'---';?></span>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Since');?> </span>
            <span class="value"><?=$date_city_to_since;?></span>
            <span class="value">(<?=\app\models\UserFlight::getExactlyDate($flight->exactly_date_to_since);?>)</span>
        </div>

        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Depart city from');?></span>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Since');?> </span>
            <span class="value"><?=$date_city_from_since;?></span>
            <span class="value">(<?=\app\models\UserFlight::getExactlyDate($flight->exactly_date_from_since);?>)</span>
        </div>

        <?php if($flight->regular_flight == 1):?>
            <div class="field">
                <span class="describe"><?=Yii::t('app', 'Only regular flight');?></span>
            </div>
        <?php else:?>
            <div class="field">
                <span class="describe"><?=Yii::t('app', 'Only direct flight');?></span>
            </div>
        <?php endif;?>
    </div>
    <div class="col-xs-6 buttons">
        <a href="#" class="close-flight-full-info btn btn-primary"><?= Yii::t('app', 'Close');?></a>
    </div>
</div>