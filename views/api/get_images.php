<?php
use app\models\SoapClientApi;
use yii\helpers\BaseFileHelper;

/*function crop_image($url, $id, $key){
    $path = 'uploads/hotel/images/big/';
    $size = getimagesize($url);
    $img_width = $size[0];
    $img_height = $size[1];
    $crop_H = $img_height*0.17;
    $new_image_height = $img_height - $crop_H;
    $src_image = imagecreatefromjpeg($url);
    $destination_image = imagecreatetruecolor($img_width, $new_image_height);
    imagecopyresized($destination_image, imagecreatefromjpeg($url), 0, 0, 0, 0, $img_width, $new_image_height, $img_width, $new_image_height);

    BaseFileHelper::createDirectory($path.$id);
    imagejpeg($destination_image, $path .$id. '/' . $key . '.jpg', 100);
    imagedestroy($destination_image);
    imagedestroy($src_image);
}

/*function scale_image($url, $id, $key){
    $size = getimagesize($url);
    $img_width = $size[0];
    $img_height = $size[1];
    $scale = 2;
    if($img_width > $img_height){
        $ratio = $img_width/$img_height;
        $new_img = 'http://hotels.sletat.ru/i/p/'.$id.'_'.$key.'_'.round(200/$ratio).'_200_0.jpg';
        $img_src = imagecreatefromjpeg($new_img);
        $size = getimagesize($new_img);
        $img_width = $size[0];
        $img_height = $size[1];
        $img_scale = imagescale($img_src, $img_width*$scale, $img_height*$scale,  IMG_BICUBIC_FIXED);
        BaseFileHelper::createDirectory('uploads/hotel_images/scale/');
        imagejpeg($img_scale, 'uploads/hotel_images/scale/'.$key.'.jpg', 100);
    }else{
        $ratio = $img_height/$img_width;
        $new_img = 'http://hotels.sletat.ru/i/p/'.$id.'_'.$key.'_200_'.round(200/$ratio).'_0.jpg';
        $img_src = imagecreatefromjpeg($new_img);
        $size = getimagesize($new_img);
        $img_width = $size[0];
        $img_height = $size[1];
        $img_scale = imagescale($img_src, $img_width*$scale, $img_height*$scale,  IMG_BICUBIC_FIXED);
        BaseFileHelper::createDirectory('uploads/hotel_images/scale/');
        imagejpeg($img_scale, 'uploads/hotel_images/scale/'.$key.'.jpg', 100);
    }
}

function small_image($url, $id, $key){
    $path = 'uploads/hotel/images/small/';
    $size = getimagesize($url);
    $img_width = $size[0];
    $img_height = $size[1];
    if($img_width > $img_height){
        $ratio = $img_width/$img_height;
        $new_img = 'http://hotels.sletat.ru/i/p/'.$id.'_'.$key.'_'.round(200/$ratio).'_200_0.jpg';
        $img_src = imagecreatefromjpeg($new_img);
        BaseFileHelper::createDirectory($path.$id);
        imagejpeg($img_src, $path .$id. '/' .$key.'.jpg', 100);
    }else{
        $ratio = $img_height/$img_width;
        $new_img = 'http://hotels.sletat.ru/i/p/'.$id.'_'.$key.'_200_'.round(200/$ratio).'_0.jpg';
        $img_src = imagecreatefromjpeg($new_img);
        BaseFileHelper::createDirectory($path.$id);
        imagejpeg($img_src, $path .$id. '/' .$key.'.jpg', 100);
    }
}

//SAVE IMAGES FROM HOTEL
$count = 0;
//$stop = 10;
foreach($countries as $c){
    ini_set('max_execution_time', 360000);
    ini_set('memory_limit', '-1');
    $hotels = SoapClientApi::getHotels($c->Id);
    foreach($hotels as $key => $one){
        if(is_array($one)) {
            foreach ($one as $k => $v) {
                $images = SoapClientApi::getHotelImages($v->Id);
                if ((!is_null($images)) and (is_array($images))) {
                    foreach ($images as $key => $img) {
                        $url = $img;

                        crop_image($url, $v->Id, $key);
                        //scale_image($url, $v->Id, $key);
                        small_image($url, $v->Id, $key);
                        echo '<br><img class="img-with-sign" src="'.$img.'">';
                        $count++;
                        //if ($count == $stop) return;
                    }
                }
            }
        }else{
            $images = SoapClientApi::getHotelImages($one->Id);
            if ((!is_null($images)) and (is_array($images))) {
                foreach ($images as $key => $img) {
                    $url = $img;

                    crop_image($url, $one->Id, $key);
                    //scale_image($url, $one->Id, $key);
                    small_image($url, $one->Id, $key);
                    echo '<br><img class="img-with-sign" src="'.$img.'">';
                }
                $count++;
                //if($count == $stop)return;
            }
        }
    }
}*/
$userTour = \app\models\UserTour::findOne(105);
foreach($userTour->nutritions as $one){
    echo $one->abbreviation.',';
}
?>
