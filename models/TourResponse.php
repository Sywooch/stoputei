<?php
namespace app\models;

use yii\db\ActiveRecord;
class TourResponse extends ActiveRecord
{
    public static function tableName(){
        return 'tour_response';
    }

    public function getCountry(){
        return $this->hasOne(Country::className(), ['country_id' => 'country_id']);
    }

    public function getCity(){
        return $this->hasOne(City::className(), ['city_id' => 'city_id']);
    }

    public function getHotel(){
        return $this->hasOne(Hotel::className(), ['hotel_id' => 'hotel_id']);
    }

    public function getDepartCityThere(){
        return $this->hasOne(DepartCity::className(), ['city_id' => 'depart_city_there']);
    }

    public function getDepartCityFromThere(){
        return $this->hasOne(DepartCity::className(), ['city_id' => 'depart_city_from_there']);
    }

    public function getVoyageThroughCityThere(){
        return $this->hasOne(DepartCity::className(), ['city_id' => 'voyage_through_city_there']);
    }

    public function getVoyageThroughCityFromThere(){
        return $this->hasOne(DepartCity::className(), ['city_id' => 'voyage_through_city_from_there']);
    }

    public function getOwner(){
        return $this->hasOne(User::className(), ['id' => 'manager_id']);
    }

    public function getRooms(){
        return $this->hasMany(HotelCategory::className(), ['category_id' => 'star_id'])
            ->viaTable(UserTourCategories::tableName(), ['tour_id' => 'id']);
    }

    public function getTestimonials(){
        return $this->hasMany(HotelComment::className(), ['hotel_id' => 'hotel_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->updated_at = time();
            }
            if($this->isNewRecord){
                $this->created_at = time();
            }
            return true;
        }
        return false;
    }

    public function hasResponse($tour_response_id, $manager_id = null){
        if(is_null($manager_id)){
            $manager_id = \Yii::$app->user->identity->getId();
        }
        return self::find()->where(['from_tour_id' => $tour_response_id, 'manager_id' => $manager_id])->count();
    }

    public static function getNutritionName($nutrition){
        switch($nutrition){
            case 0:
                return \Yii::t('app', 'RO');
            case 1:
                return \Yii::t('app', 'BB');
            case 2:
                return \Yii::t('app', 'HB');
            case 3:
                return \Yii::t('app', 'HB+');
            case 4:
                return \Yii::t('app', 'FB+');
            case 5:
                return \Yii::t('app', 'AL');
            case 6:
                return \Yii::t('app', 'UAL');
            case 7:
                return \Yii::t('app', 'Soft AL');
            default:
                return \Yii::t('app', 'RO');
        }
    }

    public static function getLocationName($location){
        switch($location){
            case 0:
                return \Yii::t('app', 'SGL');
            case 1:
                return \Yii::t('app', 'DBL');
            case 2:
                return \Yii::t('app', 'TRP');
            case 3:
                return \Yii::t('app', 'QTRL');
            default:
                return \Yii::t('app', 'SGL');
        }
    }

    public static function getRoomName($room){
        switch($room){
            case 1:
                return \Yii::t('app', 'Standart');
            case 2:
                return \Yii::t('app', 'Family');
            case 3:
                return \Yii::t('app', 'Deluxe');
            case 4:
                return \Yii::t('app', 'Suite');
            case 5:
                return \Yii::t('app', 'Villa');
            case 6:
                return \Yii::t('app', 'Economy');
            case 7:
                return \Yii::t('app', 'Apartments');
            case 8:
                return \Yii::t('app', 'Club');
            case 9:
                return \Yii::t('app', 'Studio');
            case 10:
                return \Yii::t('app', 'Bungalow');
            case 11:
                return \Yii::t('app', 'Superior');
            case 12:
                return \Yii::t('app', 'Eco');
            default:
                return \Yii::t('app', 'Standart');
        }
    }

    public static function getHotelType($hotel_type){
        switch($hotel_type) {
            case 0:
                return \Yii::t('app', 'Teen');
            case 1:
                return \Yii::t('app', 'Family');
            case 2:
                return \Yii::t('app', 'Urban');
            case 3:
                return \Yii::t('app', 'Health');
            case 4:
                return \Yii::t('app', 'For everyone');
            default:
                return \Yii::t('app', 'Any type');
        }
    }

    public static function getRoomView($room_view){
        switch($room_view) {
            case 0:
                return \Yii::t('app', 'Land view');
            case 1:
                return \Yii::t('app', 'Sea view');
            case 2:
                return \Yii::t('app', 'Pool view');
            case 3:
                return \Yii::t('app', 'Garden view');
            case 4:
                return \Yii::t('app', 'Other view');
            default:
                return \Yii::t('app', 'Sea view');
        }
    }

    public static function getBeachLine($beach_line){
        switch($beach_line) {
            case 0:
                return \Yii::t('app', 'First');
            case 1:
                return \Yii::t('app', 'Second');
            case 2:
                return \Yii::t('app', 'Third');
            case 3:
                return \Yii::t('app', 'Fourth');
            case 4:
                return \Yii::t('app', 'Fifth');
            case 5:
                return \Yii::t('app', 'Other');
            default:
                return \Yii::t('app', 'Other');
        }
    }

    public static function getExactlyDate($date){
        switch($date){
            case 0:
                return \Yii::t('app', 'Exactly date');
            case 1:
                return \Yii::t('app', '+-1 day');
            case 2:
                return \Yii::t('app', '+-2 days');
            case 3:
                return \Yii::t('app', '+-3 days');
            default:
                return \Yii::t('app', '+-3 days');
        }
    }
}