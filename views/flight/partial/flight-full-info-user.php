<?php
$created = date('d.m.Y H:i', time($flight->created_at));
$depart_to_date = date('d.m.Y H:i', strtotime($flight->date_city_to));
$depart_to_from = date('d.m.Y H:i', strtotime($flight->date_city_from));
?>
<div class="row">
    <div class="col-xs-6 col-xs-offset-3 full-flight">
        <div class="col-xs-12 flight-info">
            <div class="header">
                <span class="number">№ <?=$flight->id;?></span>
                <span class="created"><?=$created;?></span>
            </div>
            <div class="title"><?=Yii::t('app', 'Flight information');?></div>
            <div class="group-field">
                <div>
                    <span class="field"><?=Yii::t('app', 'Destination');?> : </span>
                    <span class="value"><?=$flight->country->name;?></span>
                </div>
                <?php if(!is_null($flight->city)):?>
                <div>
                    <span class="field"><?=Yii::t('app', 'Resort');?> : </span>
                    <span class="value"><?=$flight->city->name;?></span>
                </div>
                <?php endif;?>
                <div>
                    <?php if($flight->way_ticket == 2):?>
                        <span class="value"><?=Yii::t('app', 'Two way');?></span>
                    <?php else:?>
                        <span class="value"><?=Yii::t('app', 'One way');?></span>
                    <?php endif;?>
                </div>
            </div>

            <div class="group-field">
                <div>
                    <span class="field"><?=Yii::t('app','Amount of adult senior 24 years old');?> : </span>
                    <span class="value"><?=$flight->adult_count_senior_24;?></span>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app','Amount of adult under 24 years old');?> : </span>
                    <span class="value"><?=$flight->adult_count_under_24;?></span>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app','Amount of children (under 12 years old)');?> : </span>
                    <span class="value"><?=$flight->children_under_12_amount;?></span>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app','Amount of children (under 2 years old)');?> : </span>
                    <span class="value"><?=$flight->children_under_2_amount;?></span>
                </div>
            </div>

            <div class="group-field">
                <div>
                    <span class="field"><?=Yii::t('app','Flight class');?> : </span>
                    <?php if($flight->flight_class == 1):?>
                        <span class="value"><?=Yii::t('app', 'Business class');?></span>
                    <?php else: ?>
                        <span class="value"><?=Yii::t('app', 'Economy class');?></span>
                    <?php endif;?>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app','Flight type');?> : </span>
                    <?php if($flight->regular_flight == 1):?>
                        <span class="value"><?=Yii::t('app', 'Regular');?></span>
                    <?php else: ?>
                        <span class="value"><?=Yii::t('app', 'Charter');?></span>
                    <?php endif;?>
                </div>
            </div>

            <div class="group-field">
                <div>
                    <span class="field"><?=Yii::t('app','Depart city to');?> : </span>
                    <?php if(!is_null($flight->departCity)):?>
                        <span class="value"><?=$flight->departCity->name;?></span>
                    <?php endif;?>
                </div>
                <div>
                    <span class="value"><?=$depart_to_date;?></span>
                </div>
                <?php if($flight->voyage_is_direct_to == 1):?>
                    <div>
                        <span class="field"><?=Yii::t('app','Voyage is not direct');?> : </span>
                        <?php if(!is_null($flight->voyageCityTo)):?>
                            <span class="value"><?=$flight->voyageCityTo->name;?></span>
                        <?php endif;?>
                    </div>
                    <div>
                        <span class="field"><?=Yii::t('app','Date docking');?> : </span>
                        <span class="value"><?=$flight->date_docking_to_hours.' '.Yii::t('app','Hours');?> <?=$flight->date_docking_to_minutes.' '.Yii::t('app','Minutes');?> </span>
                    </div>
                <?php else:?>
                    <div>
                        <span class="value"><?=Yii::t('app','Voyage');?></span>
                    </div>
                <?php endif;?>
            </div>

            <div class="group-field">
                <?php if($flight->voyage_is_direct_from == 1 and $flight->way_ticket == 2):?>
                    <div>
                        <span class="field"><?=Yii::t('app','Depart city from');?> : </span>
                        <?php if(!is_null($flight->voyageCityFrom)):?>
                            <span class="value"><?=$flight->voyageCityFrom->name;?></span>
                        <?php endif;?>
                    </div>
                    <div>
                        <span class="value"><?=$depart_to_from;?></span>
                    </div>
                    <div>
                        <span class="field"><?=Yii::t('app','Date docking');?> : </span>
                        <span class="value"><?=$flight->date_docking_from_hours.' '.Yii::t('app','Hours');?> <?=$flight->date_docking_from_minutes.' '.Yii::t('app','Minutes');?> </span>
                    </div>
                <?php endif;?>
            </div>

            <div class="group-field">
                <div>
                    <span class="field"><?=Yii::t('app','Tickets exist');?> : </span>
                    <?php if($flight->tickets_exist == 1):?>
                        <span class="value"><?=Yii::t('app','Lot of');?></span>
                    <?php else:?>
                        <span class="value"><?=Yii::t('app','Little');?></span>
                    <?php endif;?>
                </div>
            </div>

            <div class="group-field">
                <div>
                    <span class="field"><?=Yii::t('app','Company name');?> : </span><br>
                    <span class="value"><?=$flight->owner->company_name;?></span>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app','Company address');?> : </span><br>
                    <span class="value"><?=($flight->owner->company_address)?$flight->owner->company_address:Yii::t('app','Is absent');?></span>
                </div>
                <div>
                    <span class="field"><?=Yii::t('app','Email');?> : </span><br>
                    <a href="mailto:<?=$flight->owner->email;?>" <span class="value"><?=$flight->owner->email;?></span>
                </div>
            </div>
        </div>
        <div class="col-xs-4 company-info">

        </div>
    </div>
</div>