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
$created = date('d.m.Y H:i', $tour->created_at);
$flight_included = ($tour->flight_included==1)?Yii::t('app', 'Flight included'):Yii::t('app', 'Flight not included');
if(Yii::$app->user->identity->role == 1){
    $filter_type = 'user-response';
    $userFavourite = new \app\models\UserTourFavourites();
    $favourite_class = ($userFavourite->isFavourite($tour->id))?'glyphicon-heart favourite':'glyphicon-heart-empty';
}else{
    $filter_type = 'manager-response';
    $favourite_class = '';
}

$star = '';
switch($tour->hotel->star_id){
    case 400:
        $star .= '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i>';
        break;
    case 401:
        $star .= '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i>';
        break;
    case 402:
        $star .= '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i>';
        break;
    case 403:
        $star .= '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i>';
        break;
    case 404:
        $star .= '<i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>';
        break;
}
$tour_name = ($tour->is_hot_tour == 1)?Yii::t('app', 'Hot tour'):Yii::t('app', 'Offer');
$flight_data_from = date('d.m.Y H:m', strtotime($tour->from_date));
/*switch($tour_title){
    case 'user-favourites':
        $tour_name .= Yii::t('app', 'Favourite tour');
        break;
    case 'user-hot-tour':
        $tour_name .= Yii::t('app', 'Hot tour');
        break;
    case 'my-offer':
        $tour_name .= Yii::t('app', 'My offer');
        break;
    case 'my-hot-tour':
        $tour_name .= Yii::t('app', 'My hot tour');
        break;
    default:
        $tour_name .= Yii::t('app', 'Offer');
        break;
}*/
?>
<div class="user-tour-wrapper col-xs-12" data-tour-id="<?=$tour->id;?>">
    <div class="col-xs-12 header-info">
        <?php if($filter_type == 'user-response'):?>
            <a href="<?=\yii\helpers\Url::to(['tour/add-to-favourite', 'tour_id' => $tour->id]);?>" class="add-to-favourite" data-tour-id="<?=$tour->id;?>">
                <span class="favourite-user-tour glyphicon <?=$favourite_class;?>" data-tour-id="<?=$tour->id;?>"></span>
            </a>
        <?php endif;?>
        <span class="count"><?=$tour_name.' № '.$tour->id;?></span>
        <span class="created"><?=$created;?>(<?=Yii::t('app', 'capital time');?>)</span>
        <?php if($tour_title == 'my-hot-tour'):?>
            <a href="<?=\yii\helpers\Url::to(['tour/remove-hot-tour', 'tour_id' => $tour->id]);?>" class="remove-hot-tour" data-tour-id="<?=$tour->id;?>">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
        <?php endif;?>
        <?php if($tour->hotel):?>
            <div class="hotel-title <?=(Yii::$app->user->identity->role == 1)?'tour-full-info-user':'tour-full-info-manager';?>" data-tour-id="<?=$tour->id;?>">
                <?=$tour->hotel->name;?>
                <span class="hotel-rate">(<?= Yii::t('app', 'Rate').'  '.$tour->hotel->hotel_rate;?>)</span>
                <span class="hotel-star"><?=$star;?></span>
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
            <?php if($tour->flight_included==1):?>
                <?php if(!is_null($tour->departCityThere)):?>
                    <div><span class="describe"><?=Yii::t('app', 'Depart city there');?></span> : <span class="data"><?= $tour->departCityThere->name;?></span></div>
                <?php endif;?>
                <div class="data"><?=$flight_included;?></div>
                <div class="data"><?=$flight_data_from;?></div>
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
        <a href="#" class="<?=(Yii::$app->user->identity->role == 1)?'tour-full-info-user':'tour-full-info-manager';?> btn btn-primary" data-tour-id="<?=$tour->id;?>" data-filter-type="<?=$filter_type;?>"><?= Yii::t('app', 'More');?></a>
        <span class="tour-cost">
            <?=$tour->tour_cost;?> <span data-placement="bottom" data-toggle="tooltip" title="<?= $tour->owner->city->country->currency->hint;?>"><?= $tour->owner->city->country->currency->name;?></span>
        </span>
        <span class="company-name">
            <?=$tour->owner->company_name;?>
        </span>
    </div>
</div>
