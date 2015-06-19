<?php
use app\models\SoapClientApi;
use yii\helpers\BaseFileHelper;
use app\models\HotelComment;

?>
<div class="image-div">
    <?php
    /*
    $i = 0;
    //$fileHelper = new BaseFileHelper();
    $comments = SoapClientApi::getHotelComments(2);
    /*if(property_exists($comments, 'HotelComment')) {
        foreach($comments->HotelComment as $e){
            var_dump($e->UserName);
        }
    }*/

    /*foreach($countries as $c){
        ini_set('max_execution_time', 7200);
        ini_set('memory_limit', '-1');
        //$arr_c[] = $c->Id;
        $hotels = SoapClientApi::getHotels($c->Id);
        foreach($hotels as $key => $one){
            if(is_array($one)){
                foreach($one as $k => $v){
                    $comments = SoapClientApi::getHotelComments($v->Id);
                    if(property_exists($comments, 'HotelComment')) {
                        $comments_arr = $comments->HotelComment;
                        //return;
                        foreach($comments->HotelComment as $cm) {
                            if(is_object($cm)) {
                                $hotelComment = new HotelComment();
                                $hotelComment->hotel_id = $v->Id;
                                $hotelComment->user_name = $cm->UserName;
                                $hotelComment->negative = $cm->Negative;
                                $hotelComment->positive = $cm->Positive;
                                $hotelComment->start_rest_formatted = $cm->StartRestFormatted;
                                $hotelComment->end_rest_formatted = $cm->EndRestFormatted;
                                $hotelComment->create_date_formatted = $cm->CreateDateFormatted;
                                $hotelComment->city_name = $cm->CityName;
                                $hotelComment->was_there = $cm->WasThere;
                                $hotelComment->is_tourist = $cm->IsTourist;
                                $hotelComment->rate = $cm->Rate;
                                $hotelComment->short_comment = $cm->ShortComment;
                                $hotelComment->save();
                                unset($hotelComment);
                                $i++;
                            }
                        }
                    }else{
                        echo 'WTF!!';
                    }
                    //if ($i == 140) return;
                    /*$images = SoapClientApi::getHotelImages($v->Id);
                    if(!is_null($images)) {
                        //var_dump($images);
                        //SAVE IMAGES FROM FOREIGN URL
                        foreach($images as $key => $img){
                            $url = $img;
                            echo '<br> URL : '.$url;
                            echo '<br> new IMG : '.$img;
                            echo '<br> base URL : '.Yii::$app->getBasePath();
                            BaseFileHelper::createDirectory('uploads/'.$v->Id);
                            file_put_contents('uploads/'.$v->Id.'/'.$key.'.jpg', file_get_contents($url));
                            //return;
                        }
                        if ($i == 2) return;
                        ++$i;
                    }
                }
            }else{
                $comments = SoapClientApi::getHotelComments($one->Id);
                if(property_exists($comments, 'HotelComment')) {
                    $comments_arr = $comments->HotelComment;
                    echo 'ARRAY 111 : '.var_dump($comments_arr);
                    //return;
                    foreach($comments->HotelComment as $cm) {
                        if(is_object($cm)) {
                            $hotelComment = new HotelComment();
                            $hotelComment->hotel_id = $one->Id;
                            $hotelComment->user_name = $cm->UserName;
                            $hotelComment->negative = $cm->Negative;
                            $hotelComment->positive = $cm->Positive;
                            $hotelComment->start_rest_formatted = $cm->StartRestFormatted;
                            $hotelComment->end_rest_formatted = $cm->EndRestFormatted;
                            $hotelComment->create_date_formatted = $cm->CreateDateFormatted;
                            $hotelComment->city_name = $cm->CityName;
                            $hotelComment->was_there = $cm->WasThere;
                            $hotelComment->is_tourist = $cm->IsTourist;
                            $hotelComment->rate = $cm->Rate;
                            $hotelComment->short_comment = $cm->ShortComment;
                            $hotelComment->save();
                            unset($hotelComment);
                            $i++;
                        }
                    }
                }else{
                    echo 'WTF!!';
                }
                $i++;
                //if ($i == 140) return;
                /*$images = SoapClientApi::getHotelImages($one->Id);
                if(!is_null($images)) {
                    //var_dump($images);
                    foreach($images as $key => $img){
                        $url = $img;
                        $img = '/uploads/hotel_images/'.$one->Id.'/'.$key.'.jpg';
                        echo '<br> URL : '.$url;
                        echo '<br> new IMG : '.$img;
                        file_put_contents($img, file_get_contents($url));
                    }
                    if ($i == 2) return;
                    ++$i;
                }*/
            /*}
        }
    }
    echo '<br> COMENT COUNT : '.$i;*/
    ?>
</div>