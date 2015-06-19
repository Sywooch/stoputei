<?php
/* @var $this yii\web\View */
$this->title = 'Amazing Tour';
use app\models\City;
use app\models\DepartCity;
use app\models\Country;
use app\models\SoapClientApi;
use app\models\Hotel;
?>
<div class="api-index">
    <?php

    $countries = $countries;

    //var_dump($hotel_info);
    //var_dump(SoapClientApi::getHotelInformation(3));

    //var_dump($cities);
    //$arr_c = [];

    //$count = 0;
    foreach($countries as $c) {
        //ini_set('max_execution_time', 7200);
        //ini_set('memory_limit', '-1');
        //$arr_c[] = $c->Id;
        //$hotels = SoapClientApi::getHotels($c->Id);
        //var_dump($hotels);
        /*foreach($hotels as $key => $one){
            if(!is_object($one)){
                foreach($one as $k => $v){
                    if(!Hotel::findOne(['hotel_id' => $v->Id])) {
                        $current_hotel = SoapClientApi::getHotelInformation($v->Id);
                        if(!$current_hotel->Error) {
                            $count++;
                            //var_dump($current_hotel);
                            //if($count == 15)return;
                            $hotel = new Hotel();
                            $hotel->hotel_id = $current_hotel->HotelId;
                            $hotel->address = $current_hotel->Address;
                            $hotel->airport_distance = $current_hotel->AirportDistance;
                            $hotel->area = $current_hotel->Area;
                            $hotel->building_date = $current_hotel->BuildingDate;
                            $hotel->city_center_distance = $current_hotel->CityCenterDistance;
                            $hotel->country_id = $current_hotel->CountryId;
                            $hotel->country_name = $current_hotel->CountryName;
                            $hotel->description = $current_hotel->Description;
                            $hotel->distance_to_lifts = $current_hotel->DistanceToLifts;
                            $hotel->district = $current_hotel->District;
                            $hotel->email = $current_hotel->Email;
                            $hotel->fax = $current_hotel->Fax;
                            $hotel->hotel_rate = $current_hotel->HotelRate;
                            $hotel->house_number = $current_hotel->HouseNumber;
                            $hotel->image_count = $current_hotel->ImageCount;
                            $hotel->latitude = $current_hotel->Latitude;
                            $hotel->longitude = $current_hotel->Longitude;
                            $hotel->name = $current_hotel->Name;
                            $hotel->native_address = $current_hotel->NativeAddress;
                            $hotel->old_cyrillic_name = $current_hotel->OldCyrillicName;
                            $hotel->old_latin_name = $current_hotel->OldLatinName;
                            $hotel->phone = $current_hotel->Phone;
                            $hotel->post_index = $current_hotel->PostIndex;
                            $hotel->rating_meal = $current_hotel->RatingMeal;
                            $hotel->rating_overall = $current_hotel->RatingOverall;
                            $hotel->rating_place = $current_hotel->RatingPlace;
                            $hotel->rating_service = $current_hotel->RatingService;
                            $hotel->region = $current_hotel->Region;
                            $hotel->renovation = $current_hotel->Renovation;
                            $hotel->resort_id = $current_hotel->ResortId;
                            $hotel->resort = $current_hotel->Resort;
                            $hotel->rooms_count = $current_hotel->RoomsCount;
                            $hotel->site = $current_hotel->Site;
                            $hotel->square = $current_hotel->Square;
                            $hotel->star_id = $current_hotel->StarId;
                            $hotel->star_name = $current_hotel->StarName;
                            $hotel->street = $current_hotel->Street;
                            $hotel->video = $current_hotel->Video;
                            $hotel->save();
                            unset($hotel);
                        }
                    }else{
                        echo '<br>----------------'.$v->Id.'-----------';
                    }
                }
            }else{
                if(!Hotel::findOne(['hotel_id' => $v->Id])) {
                    $current_hotel = SoapClientApi::getHotelInformation($one->Id);
                    if(!$current_hotel->Error) {
                        $count++;
                        //var_dump($current_hotel);
                        //if($count == 15)return;
                        $count++;
                        //echo '<br>'.$current_hotel->Id;
                        $hotel = new Hotel();
                        $hotel->hotel_id = $current_hotel->HotelId;
                        $hotel->address = $current_hotel->Address;
                        $hotel->airport_distance = $current_hotel->AirportDistance;
                        $hotel->area = $current_hotel->Area;
                        $hotel->building_date = $current_hotel->BuildingDate;
                        $hotel->city_center_distance = $current_hotel->CityCenterDistance;
                        $hotel->country_id = $current_hotel->CountryId;
                        $hotel->country_name = $current_hotel->CountryName;
                        $hotel->description = $current_hotel->Description;
                        $hotel->distance_to_lifts = $current_hotel->DistanceToLifts;
                        $hotel->district = $current_hotel->District;
                        $hotel->email = $current_hotel->Email;
                        $hotel->fax = $current_hotel->Fax;
                        $hotel->hotel_rate = $current_hotel->HotelRate;
                        $hotel->house_number = $current_hotel->HouseNumber;
                        $hotel->image_count = $current_hotel->ImageCount;
                        $hotel->latitude = $current_hotel->Latitude;
                        $hotel->longitude = $current_hotel->Longitude;
                        $hotel->name = $current_hotel->Name;
                        $hotel->native_address = $current_hotel->NativeAddress;
                        $hotel->old_cyrillic_name = $current_hotel->OldCyrillicName;
                        $hotel->old_latin_name = $current_hotel->OldLatinName;
                        $hotel->phone = $current_hotel->Phone;
                        $hotel->post_index = $current_hotel->PostIndex;
                        $hotel->rating_meal = $current_hotel->RatingMeal;
                        $hotel->rating_overall = $current_hotel->RatingOverall;
                        $hotel->rating_place = $current_hotel->RatingPlace;
                        $hotel->rating_service = $current_hotel->RatingService;
                        $hotel->region = $current_hotel->Region;
                        $hotel->renovation = $current_hotel->Renovation;
                        $hotel->resort_id = $current_hotel->ResortId;
                        $hotel->resort = $current_hotel->Resort;
                        $hotel->rooms_count = $current_hotel->RoomsCount;
                        $hotel->site = $current_hotel->Site;
                        $hotel->square = $current_hotel->Square;
                        $hotel->star_id = $current_hotel->StarId;
                        $hotel->star_name = $current_hotel->StarName;
                        $hotel->street = $current_hotel->Street;
                        $hotel->video = $current_hotel->Video;
                        $hotel->save();
                        unset($hotel);
                    }
                }else{
                    echo '<br>----------------'.$v->Id.'-----------';
                }
            }
        }
    }
    //var_dump($arr_c);
    /*foreach($arr_c as $each) {
        echo '<br>------------------'.$each.'------------'.var_dump(SoapClientApi::getHotels($each));
    }*/

        //foreach($countries as $key => $country){
        //ini_set('max_execution_time', 7200);
        //var_dump(SoapClientApi::getHotels($country->Id));
        /*if (!is_object($h)) {
            foreach ($h as $one) {
                $count++;
            }
        } else {
            $count++;
        }
        //$hotels_count = count(SoapClientApi::getHotels($country->Id));
        //echo '<br>'.$hotels_count;
        //var_dump(count(SoapClientApi::getHotels($country->Id)));
        //$count = $count + count(SoapClientApi::getHotels($country->Id));
        //SAVE ALL COUNTRIES
        /*$country_model = new Country();
        $country_model->country_id = $country->Id;
        $country_model->name = $country->Name;
        $country_model->alias = $country->Alias;
        $country_model->flags = $country->Flags;
        $country_model->hotel_is_not_in_stop = $country->HotelIsNotInStop;
        $country_model->is_visa = $country->IsVisa;
        $country_model->rank = $country->Rank;
        $country_model->tickets_included = $country->TicketsIncluded;
        //$country_model->save();

        var_dump($country_model);*/

        //ALL CITIES IN COUNTRY
        //$cities_arr = SoapClientApi::getCities($country->Id);

        /*foreach($cities_arr as $city) {
            foreach ($cities_arr as $city) {
                if (!is_object($city)) {
                    foreach ($city as $one) {
                        $city_model = new City();
                        $city_model->city_id = $one->Id;
                        $city_model->name = $one->Name;
                        $city_model->country_id = $one->CountryId;
                        $city_model->default = $one->Default;
                        $city_model->description_url = $one->DescriptionUrl;
                        $city_model->is_popular = $one->IsPopular;
                        $city_model->parent_id = $one->ParentId;
                        $city_model->save();
                    }
                } else {
                    $city_model = new City();
                    $city_model->city_id = $city->Id;
                    $city_model->name = $city->Name;
                    $city_model->country_id = $city->CountryId;
                    $city_model->default = $city->Default;
                    $city_model->description_url = $city->DescriptionUrl;
                    $city_model->is_popular = $city->IsPopular;
                    $city_model->parent_id = $city->ParentId;
                    $city_model->save();
                }
            }
        }*/
        // }

        /*foreach($cities_arr as $key => $city){
            $city_model = new City();
            $city_model->city_id = $city->Id;
            $city_model->name = $city->Name;
            $city_model->country_id = $city->CountryId;
            $city_model->default = $city->Default;
            $city_model->description_url = $city->DescriptionUrl;
            $city_model->is_popular = $city->IsPopular;
            $city_model->parent_id = $city->ParentId;
            $city_model->save();

            var_dump($city_model);

        }
        //var_dump($cities->GetDepartCitiesResult->City);
        */
        //foreach($images as $key=>$img){
        //    echo '<br><img src="'.$img.'">';
        //}
        //SAVE ALL DEPART CITIES
        /*foreach($depart_cities as $key => $city){
            $city_model = new DepartCity();
            $city_model->city_id = $city->Id;
            $city_model->name = $city->Name;
            $city_model->country_id = $city->CountryId;
            $city_model->default = $city->Default;
            $city_model->description_url = $city->DescriptionUrl;
            $city_model->is_popular = $city->IsPopular;
            $city_model->parent_id = $city->ParentId;
            $city_model->save();

            //var_dump($city_model);

        }*/
    }
    //echo '<div> COUNT : '.$count.'</div>';
    ?>
    <div>
        Countries:
    <select>
        <?php foreach($countries as $key => $country):?>
            <option value="<?=$country->Id;?>">(<?=$key;?>) <?=$country->Name;?></option>
        <?php endforeach;?>
    </select>
    </div>
</div>
