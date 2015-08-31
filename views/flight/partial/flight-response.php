<?php
$date_city_to = new DateTime($flight->date_city_to);
$date_to = $date_city_to->format('d.m.Y H:i');
?>
<div class="col-xs-12 flight-wrapper" data-flight-id="<?=$flight->id;?>">
    <div class="col-xs-12 header">
        <span class="count"><?=Yii::t('app', 'Ticket').' № '.$flight->id;?>
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
            <?php if($flight->way_ticket == 2):?>
                <span class="value"><?=Yii::t('app', 'Two way');?></span>
                <?php if($flight->departCity):?>
                    <div>
                        <span class="describe"><?=Yii::t('app', 'Depart city to');?> : </span><span class="value"><?=$flight->departCity->name;?></span>
                    </div>
                <?php endif;?>
                <div>
                    <span class="describe"><?=Yii::t('app', 'Flight start time');?> : </span><span class="value"><?=$date_to;?></span>
                </div>

                <?php if($flight->departCityFrom):?>
                    <div>
                        <span class="describe"><?=Yii::t('app', 'Depart city from');?> : </span><span class="value"><?=$flight->departCityFrom->name;?></span>
                    </div>
                <?php endif;?>
                <div>
                    <span class="describe"><?=Yii::t('app', 'Flight start time');?> : </span><span class="value"><?=$date_to;?></span>
                </div>
            <?php else:?>
                <span class="value"><?=Yii::t('app', 'One way');?></span>

                <?php if($flight->departCity):?>
                    <div>
                        <span class="describe"><?=Yii::t('app', 'Depart city');?> : </span><span class="value"><?=$flight->departCity->name;?></span>
                    </div>
                <?php endif;?>
                <div>
                    <span class="describe"><?=Yii::t('app', 'Flight start time');?> : </span><span class="value"><?=$date_to;?></span>
                </div>
            <?php endif;?>
        </div>
        <div class="col-xs-4">
            <div>
                <span class="value"><?=$flight->owner->company_name;?></span>
            </div>
            <div>
                <span class="describe"><?=Yii::t('app', 'Phone');?> : </span><span class="value"><?=$flight->owner->company_phone;?></span>
            </div>
            <div>
                <span class="describe"><?=Yii::t('app', 'Company address');?> : </span><span class="value"><?=$flight->owner->company_address;?></span>
            </div>
            <div>
                <span class="describe"><?=Yii::t('app', 'email');?> : </span><span class="value"><?=$flight->owner->email;?></span>
            </div>
        </div>
        <div class="col-xs-2 buttons">
            <div class="cost"><?=$flight->flight_cost;?></div>
            <a href="<?=\yii\helpers\Url::to(['flight/ajax-show-flight-full-info-user', 'id' => $flight->id]);?>" class="more-flight-response-info-user btn btn-primary" data-flight-id="<?=$flight->id;?>"><?= Yii::t('app', 'More');?></a>
        </div>
    </div>
</div>