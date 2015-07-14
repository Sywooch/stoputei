<?php
$date = date(('d.m.Y H:i:s'), $tour->created_at);
$from_date = date('d.m.Y', strtotime($tour->from_date));
$to_date = date('d.m.Y', strtotime($tour->to_date));
?>
<div class="col-xs-12 user-tour-full-info">
    <div class="col-xs-12 header">
        <span><?=Yii::t('app', 'Order').' № '.$tour->id;?></span>
        <span><?=$date;?></span>
    </div>
    <div class="col-xs-12 body">
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Budget');?> : </span>
            <span class="value"><?=$tour->budget;?></span>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Destination');?> : </span>
            <span class="value"><?=$tour->country->name;?></span>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Resort');?> : </span>
            <span class="value"><?=$tour->city->name;?></span>
        </div>

        <?php if(!is_null($tour->hotel_id)):?>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Hotel');?> : </span>
            <span class="value"><?=$tour->hotel->name;?></span>
        </div>
        <?php endif;?>

        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Depart city');?> : </span>
            <span class="value"><?=$tour->departCity->name;?></span>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'From');?> </span>
            <span class="value"><?=$from_date;?></span>
            <span class="describe"><?=Yii::t('app', 'To');?> </span>
            <span class="value"><?=$to_date;?></span>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Flight');?> : </span>
            <?php if($tour->flight_included == 1):?>
            <span class="value"><?=Yii::t('app', 'Included');?></span>
            <?php else:?>
                <span class="value"><?=Yii::t('app', 'not included');?></span>
            <?php endif;?>
        </div>

        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Amount of adult');?> : </span>
            <span class="value"><?=$tour->adult_amount;?></span>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Amount of children (under 12 years old)');?> : </span>
            <span class="value"><?=$tour->children_under_12_amount;?></span>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Amount of children (under 2 years old)');?> : </span>
            <span class="value"><?=$tour->children_under_2_amount;?></span>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Amount of room');?> : </span>
            <span class="value"><?=Yii::t('app', 'From');?> <?=$tour->night_min;?> <?=Yii::t('app', 'To');?> <?=$tour->night_max;?></span>
        </div>
        <?php if(!empty($tour->add_info)):?>
            <div class="field">
                <span class="describe"><?=Yii::t('app', 'Add information');?> : </span>
                <span class="value"><?=$tour->add_info;?></span>
            </div>
        <?php endif;?>
    </div>
    <div class="col-xs-6 buttons">
        <a href="#" class="close-tour-full-info btn btn-primary"><?= Yii::t('app', 'Close');?></a>
    </div>
</div>