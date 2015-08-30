<?php
$date = date(('d.m.Y H:i:s'), $tour->created_at);
if($tour->from_date) {
    $from_date = date('d.m.Y', strtotime($tour->from_date));
}
if($tour->hotel_id){
    $hotel_category = '';
    switch($tour->hotel->star_id){
        case 400:
            $hotel_category .= '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i>';
            break;
        case 401:
            $hotel_category .= '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i>';
            break;
        case 402:
            $hotel_category .= '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i>';
            break;
        case 403:
            $hotel_category .= '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i>';
            break;
        case 404:
            $hotel_category .= '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>';
            break;
    }
}
//hotel's categories
if($tour->categories){
    $hotel_categories = [];
    foreach($tour->categories as $one){
        $hotel_categories[] = Yii::t('app', $one->hint);
    }
    $hotel_categories = implode(',', $hotel_categories);
}else{
    $hotel_categories = '1*,2*,3*,4*,5*';
}
//hotel's room type
if(!empty($tour->rooms)){
    $hotel_rooms = [];
    foreach($tour->rooms as $one){
        $hotel_rooms[] = '<span class="value">'.Yii::t('app', $one->name).'</span>';
    }
    $hotel_rooms = implode(',', $hotel_rooms);
}else{
    $hotel_rooms = '';
}
//hotel's nutrition
if(!empty($tour->nutritions)){
    $hotel_nutritions = [];
    foreach($tour->nutritions as $one){
        $hotel_nutritions[] = '<span class="value">'.\app\models\UserTour::getNutritionName($one->nutrition_id).'</span>';
    }
    $hotel_nutritions = implode(',', $hotel_nutritions);
}else{
    $hotel_nutritions = Yii::t('app', 'Any nutrition');
}
//hotel's beach line
if(!empty($tour->beachLine)){
    $hotel_beach_lines = [];
    foreach($tour->beachLine as $one){
        $hotel_beach_lines[] = Yii::t('app', $one->name);
    }
    $hotel_beach_lines = implode(',', $hotel_beach_lines);
}else{
    $hotel_beach_lines = Yii::t('app', 'Any line');
}
//hotel's beach line
if(!empty($tour->nutritions)){
    $hotel_beach_nutritions = [];
    foreach($tour->nutritions as $one){
        $hotel_beach_nutritions[] = Yii::t('app', $one->name);
    }
    $hotel_beach_nutritions = implode(',', $hotel_beach_nutritions);
}else{
    $hotel_beach_nutritions = '';
}
?>
<div class="col-xs-12 user-tour-full-info">
    <div class="col-xs-12 header">
        <span><?=Yii::t('app', 'Order').' № '.$tour->id;?></span>
        <span><?=$date;?></span>
    </div>
    <div class="col-xs-12 body">
        <?php if($tour->budget > 0):?>
            <div class="field">
                <span class="describe"><?=Yii::t('app', 'Budget');?> : </span>
                <span class="value"><?=$tour->budget;?></span>
            </div>
        <?php endif;?>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Destination');?> : </span>
            <span class="value"><?=$tour->country->name;?></span>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Resort');?> : </span>
            <span class="value"><?=$tour->city->name;?></span>
        </div>

        <br>

        <?php if($tour->flight_included == 1):?>
            <div class="field">
               <span class="describe"><?=Yii::t('app', 'Flight');?> : </span>
               <span class="value"><?=Yii::t('app', 'Included');?></span>
            </div>
            <div class="field">
                <span class="describe"><?=Yii::t('app', 'Depart city');?> : </span>
                <span class="value">
                    <?php if(!is_null($tour->departCity)):?>
                        <?=$tour->departCity->name;?>
                    <?php else:?>
                        <?= Yii::t('app', 'Not selected');?>
                    <?php endif;?>
                </span>
            </div>
            <div class="field">
                <span class="describe"><?=Yii::t('app', 'Since');?> </span>
                <span class="value"><?=$from_date;?></span>
                <span class="value">(<?=\app\models\UserTour::getExactlyDate($tour->exactly_date);?>)</span>
            </div>
        <?php else :?>
            <div class="field">
                <span class="describe"><?=Yii::t('app', 'Flight');?> : </span>
                <span class="value"><?=Yii::t('app', 'not included');?></span>
            </div>
        <?php endif;?>

        <br>

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

        <br>

        <?php if(!is_null($tour->hotel_id)):?>
            <div class="field">
                <span class="describe"><?=Yii::t('app', 'Hotel');?> : </span>
                <span class="value"><?=$tour->hotel->name;?></span>
            </div>
            <div class="field">
                <span class="describe"><?=Yii::t('app', 'Hotel category');?> : </span>
                <span class="value"><?=$hotel_category;?></span>
            </div>
        <?php else:?>
            <div class="field">
                <span class="describe"><?=Yii::t('app', 'Hotel');?> : </span>
                <span class="value"><?=Yii::t('app', 'Not selected');?></span>
            </div>
            <div class="field">
                <span class="describe"><?=Yii::t('app', 'Hotel category');?> : </span>
                <span class="value">
                    <?=$hotel_categories;?>
                </span>
            </div>
        <?php endif;?>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Amount of room');?> : </span>
            <span class="value">
                <?= ($tour->room_count == 0)?1:$tour->room_count;?>
            </span>
        </div>
        <?php if(!empty($tour->rooms)):?>
            <div class="field">
                <span class="describe"><?=Yii::t('app', 'Room type');?> : </span>
                <?=$hotel_rooms;?>
            </div>
        <?php else :?>
            <div class="field">
                <span class="describe"><?=Yii::t('app', 'Room type');?> : </span>
                <span class="value"><?=Yii::t('app', 'Not selected');?></span>
            </div>
        <?php endif;?>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Nutrition');?> : </span>
            <?= $hotel_nutritions;?>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Beach line');?> : </span>
            <?= $hotel_beach_lines;?>
        </div>

        <br>

        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Night count');?> : </span>
            <span class="describe"><?=Yii::t('app', 'From');?></span>
            <span class="value"><?=$tour->night_min;?></span>
            <span class="describe"><?=Yii::t('app', 'To');?> </span>
            <span class="value"><?=$tour->night_max;?></span>
        </div>

        <br>

        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Hotel type');?> : </span>
            <span class="value">
                <?= \app\models\UserTour::getHotelType($tour->hotel_type);?>
            </span>
        </div>
        <div class="field">
            <span class="describe"><?=Yii::t('app', 'Add information');?> : </span>
            <span class="value">
                <?php if(!empty($tour->add_info)):?>
                    <?= $tour->add_info;?>
                <?php else:?>
                    <?=Yii::t('app', 'Is absent');?>
                <?php endif;?>
            </span>
        </div>
    </div>
    <div class="col-xs-6 buttons">
        <a href="#" class="close-tour-full-info btn btn-primary"><?= Yii::t('app', 'Close');?></a>
    </div>
</div>