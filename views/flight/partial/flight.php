<?php
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
$date_city_to_until = date('d.m.Y', strtotime($flight->date_city_to_until));
$date_city_from_since = date('d.m.Y', strtotime($flight->date_city_from_since));
$date_city_from_until = date('d.m.Y', strtotime($flight->date_city_from_until));
?>
<div class="col-xs-12 flight-wrapper">
    <div class="col-xs-12 header">
        <span class="count"><?=Yii::t('app', 'Order').' № '.$flight->id;?>
        </span><span class="created"><?=date('d.m.Y H:i:s', $flight->created_at);?></span>
    </div>
    <div class="col-xs-12 body">
        <div class="col-xs-5">
            <div>
                <span class="describe"><?=Yii::t('app', 'Destination');?> : </span><span class="value"><?=$flight->country->name;?></span>
            </div>
            <div>
                <span class="describe"><?=Yii::t('app', 'Resort');?> : </span><span class="value"><?=$flight->city->name;?></span>
            </div>
            <div>
                <span class="value"><?=$flight_way;?></span>
            </div>
            <div>
                <span class="describe"><?=Yii::t('app', 'Flight class');?> : </span><span class="value"><?=$flight_class;?></span>
            </div>
        </div>
        <div class="col-xs-5">
            <div>
                <span class="describe"><?=Yii::t('app', 'Depart city to');?> : </span><span class="value"><?=$flight->departCity->name;?></span>
            </div>
            <div>
                <span class="describe"><?=Yii::t('app', 'Since');?> </span><span class="value"><?=$date_city_to_since;?></span>
                <span class="describe"><?=Yii::t('app', 'Until');?> </span><span class="value"><?=$date_city_to_until;?></span>
            </div>
            <div>
                <span class="describe"><?=Yii::t('app', 'Depart city from');?> : </span>
            </div>
            <div>
                <span class="describe"><?=Yii::t('app', 'Since');?> </span><span class="value"><?=$date_city_from_since;?></span>
                <span class="describe"><?=Yii::t('app', 'Until');?> </span><span class="value"><?=$date_city_from_until;?></span>
            </div>
        </div>
        <div class="col-xs-2 buttons">
            <a href="#" class="more-flight-info btn btn-primary" data-hotel-id="<?=$flight->id;?>"><?= Yii::t('app', 'More');?></a>
        </div>
    </div>
</div>