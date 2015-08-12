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
if(Yii::$app->user->identity->role == 1){
    $filter_type = 'user-response';
    $userFavourite = new \app\models\UserTourFavourites();
    $favourite_class = ($userFavourite->isFavourite($tour->id))?'glyphicon-heart favourite':'glyphicon-heart-empty';
}else{
    $filter_type = 'manager-response';
    $favourite_class = '';
}
?>
<div class="user-tour-wrapper col-xs-12" data-tour-id="<?=$tour->id;?>">
    <div class="col-xs-12 header-info">
        <?php if($filter_type == 'user-response'):?>
            <a href="<?=\yii\helpers\Url::to(['tour/add-to-favourite', 'tour_id' => $tour->id]);?>" class="add-to-favourite">
                <span class="favourite-user-tour glyphicon <?=$favourite_class;?>" data-tour-id="<?=$tour->id;?>"></span>
            </a>
        <?php endif;?>
        <span class="count hide"><?=Yii::t('app', 'Offer').' № '.$tour->id;?></span>
        <span class="created hide"><?=$created;?></span>
        <?php if($tour->hotel):?>
            <div class="hotel-title">
                <?=$tour->hotel->name;?>
                <span class="hotel-rate">(<?= Yii::t('app', 'Rate').'  '.$tour->hotel->hotel_rate;?>)</span>
            </div>
        <?php endif;?>
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
            <?php if($tour->flight_included==1):?>
                <div class="data"><?=$flight_included;?></div>
                <?php if($tour->voyage_there == 1):?>
                    <div class="data"><?=Yii::t('app', 'Voyage');?></div>
                <?php else:?>
                    <div class="data"><?=Yii::t('app', 'Voyage is not direct');?></div>
                <?php endif;?>
            <?php else:?>
                <div class="data"><?=$flight_included;?></div>
            <?php endif;?>
            <div class="data"><?=Yii::t('app', '{n,nights}', ['n' => $tour->night_count]);?></div>
        </div>
    </div>
    <div class="col-xs-4 people offer">
        <div><span class="describe"><?=Yii::t('app', 'Location');?></span> : <span class="data"><?= Yii::t('app', \app\models\TourResponse::getLocationName($tour->location));?></span></div>
        <div><span class="describe"><?=Yii::t('app', 'Nutrition');?></span> : <span class="data"><?= Yii::t('app', \app\models\TourResponse::getNutritionName($tour->nutrition));?></span></div>
        <div><span class="describe"><?=Yii::t('app', 'Amount of adult');?></span> : <span class="data"><?= $tour->adult_amount;?></span></div>
        <div><span class="describe"><?=Yii::t('app', 'Amount of children (under 12 years old)');?></span> : <span class="data"><?= $tour->children_under_12_amount;?></span></div>
        <div><span class="describe"><?=Yii::t('app', 'Amount of children (under 2 years old)');?></span> : <span class="data"><?= $tour->children_under_2_amount;?></span></div>
        <div><span class="describe"><?=Yii::t('app', 'Medicine insurance');?></span> : <span class="data"><?= ($tour->medicine_insurance == 1)?Yii::t('app', 'Insurance included'):Yii::t('app', 'Insurance not included');?></span></div>
        <div><span class="describe"><?=Yii::t('app', 'Room type');?></span> : <span class="data"><?= Yii::t('app', \app\models\TourResponse::getRoomName($tour->room_view));?></span></div>
    </div>
    <div class="col-xs-2 buttons">
        <a href="#" class="tour-more-info btn btn-primary" data-tour-id="<?=$tour->id;?>" data-filter-type="<?=$filter_type;?>"><?= Yii::t('app', 'More');?></a>
    </div>
</div>
