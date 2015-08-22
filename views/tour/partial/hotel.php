<?php
use yii\helpers\BaseFileHelper;
$photos_dir = 'uploads/hotel/images/small/'.$hotel->hotel_id;
$photos = [];
$photos_show = [];
$stop_photo = 2;
if(file_exists($photos_dir) && is_dir($photos_dir)){
    $photos = BaseFileHelper::findFiles($photos_dir);
}else{
    $photos = [];
}
if(!count($photos)){
    $empty_photos = [];
    for($i = 0; $i < 3; ++$i){
        $empty_photos[] = '<span class="empty-img"><i class="glyphicon glyphicon-camera"></i></span>';
    }
}
foreach($photos as $key => $one){
    $photos_show[] = $key;
    if($key == $stop_photo){break;};
}
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
$rate = '';
if($hotel->hotel_rate == 0){
    $rate .= '<span class="status">'.Yii::t('app', 'No rate').'</span>';
}else{
    $rate .= '<span class="status">'.Yii::t('app', 'Rate').':</span><span class="number">'.$hotel->hotel_rate.'</span>';
}
$role = (Yii::$app->user->identity->role==1)?'user':'manager';
?>
<div class="col-xs-12 hotel-list-wrap">
    <div class="hotel-title">
        <span class="name <?=(Yii::$app->user->identity->role == 1)?'more-hotel-info-user':'more-hotel-info-manager';?>" data-tab-class="<?=$filter_type;?>" data-hotel-id="<?=$hotel->hotel_id;?>"><?= $hotel->name;?></span>
        <span class="star"><?= $star;?></span>
    </div>
    <div class="row hotel-body">
        <div class="col-xs-6 images">
            <?php if(count($photos)):?>
                <?php foreach($photos_show as $img):?>
                    <a href="<?='/uploads/hotel/images/big/'.$hotel->hotel_id.'/'.$img.'.jpg';?>" class="preview" title="<?=$hotel->name;?>">
                        <img src="<?='/uploads/hotel/images/small/'.$hotel->hotel_id.'/'.$img.'.jpg';?>" class="img-responsive hotel-img" alt="gallery thumbnail">
                    </a>
                <?php endforeach;?>
            <?php else:?>
                <?php foreach($empty_photos as $img):?>
                    <?=$img;?>
                <?php endforeach;?>
            <?php endif;?>
        </div>
        <div class="col-xs-6 information">
            <div class="col-xs-6 info">
                <span class="rate">
                    <?=$rate;?>
                </span>
                <span class="country"><?=$hotel->country_name;?></span>
                <span class="city"><?=$hotel->resort;?></span>
            </div>
            <div class="col-xs-6 buttons">
                <a href="#" class="<?=(Yii::$app->user->identity->role == 1)?'more-hotel-info-user':'more-hotel-info-manager';?> btn btn-primary" data-tab-class="<?=$filter_type;?>" data-hotel-id="<?=$hotel->hotel_id;?>"><?= Yii::t('app', 'More');?></a>
                <a href="#" class="add-to-filter <?=$role;?> <?=$filter_type;?> btn btn-default" data-hotel-id="<?=$hotel->hotel_id;?>" data-hotel-name="<?=$hotel->name;?>" data-hotel-star="<?=$hotel->star_id;?>"><?= Yii::t('app', 'Choose');?></a>
            </div>
        </div>
    </div>
</div>
