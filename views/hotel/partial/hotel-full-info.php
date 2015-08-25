<?php
use yii\helpers\BaseFileHelper;
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
    $big_photo = $photos[rand(0, $photo_count)];
    $big_photo = '<img src="'.$big_photo.'" class="img-responsive big-photo">';
    $gallery = [];
    foreach($photos as $key => $photo){
        if($key > 11){
            $class = 'hide';
        }else{
            $class = '';
        }
        $gallery[] = [
            'url' => $path_to_images.'big/'.$hotel->hotel_id.'/'.$key.'.jpg',
            'src' => $photos_dir.'/'.$key.'.jpg',
            'options' => [
                'title' => $hotel->name,
                'class' => 'one-gallery-img '.$class,
                'alt' => $hotel->name
            ]
        ];
    }
}else{
    $gallery = [];
    $big_photo = '<span class="empty-img"><i class="glyphicon glyphicon-camera"></i></span>';
}

?>

<script type="text/javascript">
    function initialize() {
        //point position
        var myLatLng = new google.maps.LatLng(<?=$hotel->latitude;?>, <?=$hotel->longitude;?>)
        var mapOptions = {
            zoom: 11,
            center: myLatLng
        };

        var map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: "<?=$hotel->name;?>"
        });
    }

    function loadScript() {
        $('#map-api-script').remove();
        $('script[src*="https://maps.gstatic.com/maps-api-v3/api"]').remove();
        var script1 = document.createElement('script');
        script1.type = 'text/javascript';
        script1.id = 'map-api-script';
        script1.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAH-z5yA2rub-VCGI8DfRg4CGsJKyCrpks&callback=initialize';

        document.body.appendChild(script1);
    }

    loadScript();
</script>
<div class="hotel-full-info">
    <div class="row">
        <div class="col-xs-12 header-info">
            <span class="col-xs-8 left">
                <span class="hotel-name">
                    <?=$hotel->name;?>
                </span>
                <span class="stars">
                    <?=$star;?>
                </span>
            </span>
            <span class="col-xs-4 right">
                <span class="rate-field">
                    <?= Yii::t('app', 'Hotel rate');?> :
                </span>
                <span class="rate-value">
                    <?=$hotel->hotel_rate;?>
                </span>
            </span>
        </div>
        <div class="main-content col-xs-12">
            <div class="col-xs-8">
                <div class="col-xs-6 hotel-images">
                    <div><?=$big_photo;?></div>
                    <div>
                        <?= dosamigos\gallery\Gallery::widget([
                            'items' => $gallery,
                            'id' => 'gallery-widget'
                        ]);?>
                    </div>
                    <div id="map-canvas" class="col-xs-12"></div>
                </div>
                <div class="col-xs-6 hotel-description">
                    <?php if(!empty($hotel->description)):?>
                        <?= $hotel->description;?>
                    <?php else:?>
                        <?= Yii::t('app', 'Hotel description coming soon.');?>
                    <?php endif;?>
                    <div>
                        <div>
                            <span class="field"><?=Yii::t('app','Hotel\'s site');?> : </span>
                            <span class="value"><?=(!empty($hotel->site)?$hotel->site:'---');?></span>
                        </div>
                        <div>
                            <span class="field"><?=Yii::t('app','Hotel\'s email');?> : </span>
                            <?php if(!empty($hotel->email)):?>
                                <span class="value">
                                    <a href="mailto:<?=$hotel->email;?>"><?=$hotel->email;?></a>
                            <?php else:?>
                                <span class="value">---</span>
                            <?php endif;?>
                        </div>
                        <div>
                            <span class="field"><?=Yii::t('app','Hotel\'s phone');?> : </span>
                            <span class="value"><?=(!empty($hotel->phone)?$hotel->phone:'---');?></span>
                        </div>
                        <div>
                            <span class="field"><?=Yii::t('app','Hotel\'s fax');?> : </span>
                            <span class="value"><?=(!empty($hotel->fax)?$hotel->fax:'---');?></span>
                        </div>
                        <div>
                            <span class="field"><?=Yii::t('app','Building date');?> : </span>
                            <span class="value"><?=(!empty($hotel->building_date)?$hotel->building_date:'---');?></span>
                        </div>
                        <div>
                            <span class="field"><?=Yii::t('app','Renovation date');?> : </span>
                            <span class="value"><?=(!empty($hotel->renovation)?$hotel->renovation:'---');?></span>
                        </div>
                        <div>
                            <span class="field"><?=Yii::t('app','Rooms amount');?> : </span>
                            <span class="value"><?=(!empty($hotel->rooms_count)?$hotel->rooms_count:'---');?></span>
                        </div>
                        <div>
                            <span class="field"><?=Yii::t('app','Hotel\'s area');?> : </span>
                            <span class="value"><?=(!empty($hotel->area)?$hotel->area. Yii::t('app','m2'):'---');?></span>
                        </div>
                        <div>
                            <span class="field"><?=Yii::t('app','Airport distance');?> : </span>
                            <span class="value"><?=(!empty($hotel->airport_distance)?$hotel->airport_distance. Yii::t('app','Km'):'---');?></span>
                        </div>
                        <div>
                            <span class="field"><?=Yii::t('app','City centre distance');?> : </span>
                            <span class="value"><?=(!empty($hotel->city_center_distance)?$hotel->city_center_distance. Yii::t('app','Km'):'---');?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-4">
                <?php if(!empty($hotel->facilities)):?>
                    <ul class="hotel-facilities">
                        <?php foreach($hotel->facilities as $facility):?>
                            <li>
                                <i class="glyphicon glyphicon-tag"></i>
                                <?=$facility->name;?>
                                <?php if(!empty($facility->hint)):?>
                                    <span class="hint">
                                        ( <?=$facility->hint;?> )
                                    </span>
                                <?php endif;?>
                            </li>
                        <?php endforeach;?>
                    </ul>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>