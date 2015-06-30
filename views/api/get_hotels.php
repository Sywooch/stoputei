<?php
use yii\helpers\BaseFileHelper;
//use app\models\SoapClientApi;
//use app\models\Hotel;
/*
include_once ('simple_html_dom.php');
$i = 0;
$site = 'http://hotels.sletat.ru/hotel_desc/?id=';

foreach($countries as $c) {
    ini_set('max_execution_time', 7200);
    ini_set('memory_limit', '-1');
    if($c->Id > 15) {
        $hotels = SoapClientApi::getHotels($c->Id);
        foreach ($hotels as $key => $one) {
            if (is_array($one)) {
                foreach ($one as $k => $v) {
                    //$info = SoapClientApi::getHotelInformation($v->Id);
                    $html = file_get_html($site . $v->Id);
                    echo $site . $v->Id . '<br>';
                    $description = $html->find('body', 0)->plaintext;
                    $hotel = new Hotel();
                    $hotel->updateDescription($v->Id, $description);
                    unset($hotel);

                }
            } else {
                //$info = SoapClientApi::getHotelInformation($one->Id);
                $html = file_get_html($site . $one->Id);
                $description = $html->find('body', 0)->plaintext;
                $hotel = new Hotel();
                $hotel->updateDescription($one->Id, $description);
                unset($hotel);

            }
        }
    }else{
        continue;
    }
}*/
?>
<div>
    <?php foreach($hotels as $hotel):?>
        <div>
            <div>id : <?=$hotel->hotel_id;?></div>
            <div>address : <?=$hotel->address;?></div>
            <div>airport_distance : <?=$hotel->airport_distance;?></div>
            <div>area : <?=$hotel->area;?></div>
            <div>building_date : <?=$hotel->building_date;?></div>
            <div>city_center_distance : <?=$hotel->city_center_distance;?></div>
            <div>country_id : <?=$hotel->country_id;?></div>
            <div>country_name : <?=$hotel->country_name;?></div>
            <div>description : <?=$hotel->description;?></div>
            <div>distance_to_lifts : <?=$hotel->distance_to_lifts;?></div>
            <div>district : <?=$hotel->district;?></div>
            <div>email : <?=$hotel->email;?></div>
            <div>fax : <?=$hotel->fax;?></div>
            <div>hotel_rate : <?=$hotel->hotel_rate;?></div>
            <div>house_number : <?=$hotel->house_number;?></div>
            <div>image_count : <?=$hotel->image_count;?></div>
            <?php if($hotel->image_count > 0):?>
                <?php foreach(BaseFileHelper::findFiles('uploads/hotel/images/big/'.$hotel->hotel_id.'/') as $img):?>
                    <img src="/<?=$img;?>" class="img-responsive">
                <?php endforeach;?>
                <?php foreach(BaseFileHelper::findFiles('uploads/hotel/images/small/'.$hotel->hotel_id.'/') as $img):?>
                    <img src="/<?=$img;?>" class="img-responsive">
                <?php endforeach;?>
            <?php endif;?>
            <div>latitude : <?=$hotel->latitude;?></div>
            <div>longitude : <?=$hotel->longitude;?></div>
            <div>name : <?=$hotel->name;?></div>
            <div>native_address : <?=$hotel->native_address;?></div>
            <div>old_cyrillic_name : <?=$hotel->old_cyrillic_name;?></div>
            <div>old_latin_name : <?=$hotel->old_latin_name;?></div>
            <div>phone : <?=$hotel->phone;?></div>
            <div>post_index : <?=$hotel->post_index;?></div>
            <div>rating_meal : <?=$hotel->rating_meal;?></div>
            <div>rating_overall : <?=$hotel->rating_overall;?></div>
            <div>rating_place : <?=$hotel->rating_place;?></div>
            <div>rating_service : <?=$hotel->rating_service;?></div>
            <div>region : <?=$hotel->region;?></div>
            <div>renovation : <?=$hotel->renovation;?></div>
            <div>resort_id : <?=$hotel->resort_id;?></div>
            <div>resort : <?=$hotel->resort;?></div>
            <div>rooms_count : <?=$hotel->rooms_count;?></div>
            <div>site : <?=$hotel->site;?></div>
            <div>square : <?=$hotel->square;?></div>
            <div>star_id : <?=$hotel->star_id;?></div>
            <div>star_name : <?=$hotel->star_name;?></div>
            <div>street : <?=$hotel->street;?></div>
            <div>video : <?=$hotel->video;?></div>
        </div>
    <?php endforeach;?>
</div>