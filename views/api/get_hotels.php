<?php use app\models\SoapClientApi;
use app\models\Hotel;

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
}