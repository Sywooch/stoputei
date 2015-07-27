<?php
use yii\helpers\BaseFileHelper;
$photos_dir = 'uploads/hotel/images/small/'.$tour->hotel_id;
$photos = [];
$stop_photo = 0;
if(file_exists($photos_dir) && is_dir($photos_dir)){
    $photos = BaseFileHelper::findFiles($photos_dir);
}else{
    $photos = [];
}
foreach($photos as $key => $one){
    $hotel_img = '/'.$one;
    if($key == $stop_photo){break;};
}
$empty_photo = '<span class="empty-img-offer"><i class="glyphicon glyphicon-camera"></i></span>';
$created = date('d.m.Y H:i:s', $tour->created_at);
$flight_included = ($tour->flight_included==1)?Yii::t('app', 'Flight included'):Yii::t('app', 'Flight not included');

?>
<div class="user-tour-wrapper col-xs-12">
    <div class="col-xs-12 header-info">
        <span class="count hide"><?=Yii::t('app', 'Offer').' № '.$tour->id;?></span>
        <span class="created hide"><?=$created;?></span>
        <div class="hotel-title">
            <?=$tour->hotel->name;?>
            <span class="hotel-rate">(<?= Yii::t('app', 'Rate').'  '.$tour->hotel->hotel_rate;?>)</span>
        </div>
    </div>
    <div class="col-xs-6 body">
        <div class="col-xs-5 hotel-photo">
        <?php if(count($photos)):?>
            <img src="<?=$hotel_img;?>" class="img-responsive hotel-img">
        <?php else:?>
            <?=$empty_photo;?>
        <?php endif;?>
        </div>
        <div class="col-xs-7 tour-info">
            <div class="data"><?=$tour->country->name;?></div>
            <div class="data"><?=$tour->city->name;?></div>
            <?php if(!is_null($tour->departCityThere)):?>
                <div><span class="describe"><?=Yii::t('app', 'Depart city from');?></span> : <span class="data"><?= $tour->departCityThere->name;?></span></div>
            <?php endif;?>
            <div class="data"><?=$flight_included;?></div>
        </div>
    </div>
    <div class="col-xs-4 people offer">
        <div><span class="describe"><?=Yii::t('app', 'Amount of adult');?></span> : <span class="data"><?= $tour->adult_amount;?></span></div>
        <div><span class="describe"><?=Yii::t('app', 'Amount of children (under 12 years old)');?></span> : <span class="data"><?= $tour->children_under_12_amount;?></span></div>
        <div><span class="describe"><?=Yii::t('app', 'Amount of children (under 2 years old)');?></span> : <span class="data"><?= $tour->children_under_2_amount;?></span></div>
    </div>
    <div class="col-xs-2 buttons">
        <a href="#" class="tour-more-info btn btn-primary" data-tour-id="<?=$tour->id;?>"><?= Yii::t('app', 'More');?></a>
    </div>
</div>
