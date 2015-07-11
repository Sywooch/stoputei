<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\base\Exception;
use yii\console\Controller;
use app\models\SoapClientApi;
use app\models\Hotel;
use app\models\Facility;
use app\models\HotelFacilities;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HotelFacilitiesController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($limit, $offset)
    {


        function saveRelations($name_facility, $hint_facility, $hotel_id){
            $facilityModel = new Facility();
            if($facModel = $facilityModel->find()->where(['name' => $name_facility])->one()){
                $hotelFacilitiesModel = new HotelFacilities();
                if($hotelFacilitiesModel->find()->where(['hotel_id' => $hotel_id, 'facility_id' => $facModel->id])->one()){
                    //echo "Hotel facilities relation exists \n";
                }else{
                    $hotelFacilitiesModel->hotel_id = $hotel_id;
                    $hotelFacilitiesModel->facility_id = $facModel->id;
                    $hotelFacilitiesModel->save();
                    echo "Hotel facilities relation created \n";
                    unset($hotelFacilitiesModel);
                }
            }else{
                echo "New Facility created. \n";
                $facilityModel->name = $name_facility;
                $facilityModel->hint = $hint_facility;
                $facilityModel->save();
                $hotelFacilitiesModel = new HotelFacilities();
                $hotelFacilitiesModel->hotel_id = $hotel_id;
                $hotelFacilitiesModel->facility_id = $facilityModel->id;
                $hotelFacilitiesModel->save();
                unset($facilityModel);
                unset($hotelFacilitiesModel);
            }
            unset($facilityModel);
        }

        ini_set('max_execution_time', 36000000);
        ini_set('memory_limit', '-1');

        $hotels = Hotel::find()->limit($limit)->offset($offset)->all();
        foreach($hotels as $k => $hotel){
            echo "-------- $hotel->hotel_id --------- HOTEL COUNT : $hotel->id ---------- \n";
            try{
                $hotelFacilities = SoapClientApi::getHotelFacilities($hotel->hotel_id);
            }catch (Exception $e){
                echo "Hotel with this ID not found!!! \n";
            }
            if(!empty($hotelFacilities)) {
                //echo 'HOTEL ID : '.$hotel->hotel_id."\n";
                foreach($hotelFacilities as $facility){
                    if(is_array($hotelFacilities)){
                        foreach($hotelFacilities as $one_facility){
                            if(is_array($one_facility)){
                                foreach($one_facility as $f){
                                    //echo 'ID : '.$f->Id.'  HIT : '.$f->Hit.'  NAME : '.$f->Name."\n #### \n";
                                    saveRelations($f->Name, $f->Hit, $hotel->hotel_id);
                                }
                            }else{
                                $fac = $one_facility->Facilities->HotelInfoFacility;
                                if(is_array($fac)){
                                    foreach($fac as $one_f){
                                        //echo 'ID : ' . $one_f->Id . '  HIT : ' . $one_f->Hit . '  NAME : ' . $one_f->Name."\n #### \n";
                                        saveRelations($one_f->Name, $one_f->Hit, $hotel->hotel_id);
                                    }
                                }else{
                                    //echo 'ID : ' . $fac->Id . '  HIT : ' . $fac->Hit . '  NAME : ' . $fac->Name."\n #### \n";
                                    saveRelations($fac->Name, $fac->Hit, $hotel->hotel_id);
                                }
                            }
                        }
                    }else{
                        if(gettype($facility) == 'object'){
                            //echo 'ID : '.$facility->HotelInfoFacility->Id.'  HIT : '.$facility->HotelInfoFacility->Hit.'  NAME : '.$facility->HotelInfoFacility->Name."\n #### \n";
                            saveRelations($facility->HotelInfoFacility->Name, $facility->HotelInfoFacility->Hit, $hotel->hotel_id);
                        }

                    }
                }
            }
        }
    }
}
