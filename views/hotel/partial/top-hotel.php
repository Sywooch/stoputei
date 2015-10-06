<?php
use yii\helpers\BaseFileHelper;
use yii\helpers\Html;
$star = '';
switch($hotel->star_id){
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

//hotel images
$path_to_images = 'uploads/hotel/images/';
$photos_dir = 'uploads/hotel/images/small/'.$hotel->hotel_id;
$photos = [];
if(file_exists($photos_dir) && is_dir($photos_dir)){
    $photos = BaseFileHelper::findFiles($photos_dir);
}else{
    $photos = [];
}
$photo_count = count($photos) -1;

if(!empty($photos)){
    $big_photo = '<img src="'.$photos[0].'" class="img-responsive big-photo">';
}else{
    $big_photo = '<span class="empty-img"><i class="glyphicon glyphicon-camera"></i></span>';
}

?>
<div class="hotel-top-wrapper col-xs-12">
    <div class="name col-xs-12">
        <?=$hotel->name;?>
    </div>
    <div class="col-xs-6 left">
        <div class="stars">
            <?=$star;?>
        </div>
        <div class="photo">
            <?=$big_photo;?>
        </div>
    </div>
    <div class="col-xs-6 right">
        <div class="country">
            <?=$hotel->country_name;?>
        </div>
        <div class="city">
            <?=$hotel->resort;?>
        </div>
        <div>
            <?= Html::a(Yii::t('app', 'More'), '#', ['class' => (Yii::$app->user->identity->role == 1)?'more-hotel-info-user btn btn-primary':'more-hotel-info-manager btn btn-primary', 'data-tab-class' => $type, 'data-hotel-id' => $hotel->hotel_id]);?>
        </div>
        <div class="rate">
            <?=Yii::t('app', 'Rate').' '.$hotel->hotel_rate;?>
        </div>
    </div>
</div>