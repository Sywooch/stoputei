<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\models\SoapClientApi;
use yii\helpers\BaseFileHelper;
use app\models\Hotel;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HotelImagesController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {



        function crop_image($url, $id, $key){
            $path = 'web/uploads/hotel/images/big/';
                $size = getimagesize($url);
                $img_width = $size[0];
                $img_height = $size[1];
                $crop_H = $img_height * 0.174;
                $new_image_height = $img_height - $crop_H;
                $src_image = imagecreatefromjpeg($url);
                $destination_image = imagecreatetruecolor($img_width, $new_image_height);
                imagecopyresized($destination_image, imagecreatefromjpeg($url), 0, 0, 0, 0, $img_width, $new_image_height, $img_width, $new_image_height);

                BaseFileHelper::createDirectory($path . $id);
                imagejpeg($destination_image, $path . $id . '/' . $key . '.jpg', 100);
                imagedestroy($destination_image);
                imagedestroy($src_image);
        }

        function small_image($url, $id, $key){
            $path = 'web/uploads/hotel/images/small/';
                $size = getimagesize($url);
                $img_width = $size[0];
                $img_height = $size[1];
                if ($img_width > $img_height) {
                    $ratio = $img_width / $img_height;
                    $new_img = 'http://hotels.sletat.ru/i/p/' . $id . '_' . $key . '_' . round(200 / $ratio) . '_200_0.jpg';
                    $img_src = imagecreatefromjpeg($new_img);
                    BaseFileHelper::createDirectory($path . $id);
                    imagejpeg($img_src, $path . $id . '/' . $key . '.jpg', 100);
                } else {
                    $ratio = $img_height / $img_width;
                    $new_img = 'http://hotels.sletat.ru/i/p/' . $id . '_' . $key . '_200_' . round(200 / $ratio) . '_0.jpg';
                    $img_src = imagecreatefromjpeg($new_img);
                    BaseFileHelper::createDirectory($path . $id);
                    imagejpeg($img_src, $path . $id . '/' . $key . '.jpg', 100);
                }
        }

        $hotels = Hotel::find()->limit(20)->offset(12807)->all();
        foreach($hotels as $one){
            echo $one->hotel_id."\n";;
        }

        /*
        $countries = SoapClientApi::getCountries();
        $c_arr = [];
        foreach($countries as $one){
            if($one->Id > 18) {
                $c_arr[] = $one;
            }
        }
        //SAVE IMAGES FROM HOTEL
        $count = 0;
        $h_count = 0;
        //$stop = 10;
        foreach($c_arr as $c){
            ini_set('max_execution_time', 36000000);
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
                                small_image($url, $v->Id, $key);
                                echo $v->Id. "\n";
                                //if($count == $stop)return;
                            }
                        }
                        echo 'hotel N : '.$key. "\n";
                        $count++;
                    }
                }else{
                    $images = SoapClientApi::getHotelImages($one->Id);
                    if ((!is_null($images)) and (is_array($images))) {
                        foreach ($images as $key => $img) {
                            $url = $img;
                            crop_image($url, $one->Id, $key);
                            small_image($url, $one->Id, $key);
                            echo $one->Id. "\n";
                        }
                        //if($count == $stop)return;
                    }
                    echo 'hotel N : '.$key. "\n";
                    $count++;
                }
                $h_count++;
                echo 'HOTEL COUNT : '.$h_count. "\n";
            }
        }*/
    }
}
