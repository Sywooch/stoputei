<?php
$date_city_to = new DateTime($flight->date_city_to);
$date_to = $date_city_to->format('d.m.Y H:i');
?>
<div class="col-xs-12 flight-wrapper">
    <div class="col-xs-12 header">
        <span class="count"><?=Yii::t('app', 'Offer').' № '.$flight->id;?>
        </span><span class="created"><?=date('d.m.Y H:i', $flight->created_at);?></span>
    </div>
    <div class="col-xs-12 body">
        <div class="col-xs-6">
            <div>
                <span class="describe"><?=Yii::t('app', 'Destination');?> : </span><span class="value"><?=$flight->country->name;?></span>
            </div>
            <?php if($flight->city):?>
            <div>
                <span class="describe"><?=Yii::t('app', 'Resort');?> : </span><span class="value"><?=$flight->city->name;?></span>
            </div>
            <?php endif;?>
            <div>
                <span class="value"></span>
            </div>

            <div>
                <span class="describe"><?=Yii::t('app', 'Flight cost');?> : </span><span class="value"><?=$flight->flight_cost;?></span>
            </div>
            <?php if($flight->departCity):?>
            <div>
                <span class="describe"><?=Yii::t('app', 'Depart city');?> : </span><span class="value"><?=$flight->departCity->name;?></span>
            </div>
            <?php endif;?>
            <div>
                <span class="describe"><?=Yii::t('app', 'Flight start time');?> : </span><span class="value"><?=$date_to;?></span>
            </div>
        </div>
        <div class="col-xs-4">

        </div>
        <div class="col-xs-2 buttons">
            <a href="#" class="more-flight-response-info btn btn-primary" data-flight-id="<?=$flight->id;?>"><?= Yii::t('app', 'More');?></a>
        </div>
    </div>
</div>