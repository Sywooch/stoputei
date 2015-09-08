<?php
namespace app\components;

use app\models\Hotel;
use yii\base\Widget;

class TopHotelsWidget extends Widget
{
    public $page;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $sql_requests = "SELECT       `hotel_id`, COUNT(*) AS `value_occurrence`
                FROM     `user_tour`
                WHERE `hotel_id` IS NOT NULL AND `region_owner_id` = ".\Yii::$app->user->identity->region_id."
                GROUP BY `hotel_id`
                ORDER BY `value_occurrence` DESC
                LIMIT    5";
        $sql_responses = "SELECT       `hotel_id`, COUNT(*) AS `value_occurrence`
                FROM     `tour_response`
                WHERE `region_manager_id` = ".\Yii::$app->user->identity->region_id."
                GROUP BY `hotel_id`
                ORDER BY `value_occurrence` DESC
                LIMIT    5";

        $hotels_requests_arr = \Yii::$app->db->createCommand($sql_requests)
            ->queryAll();
        $hotels_responses_arr = \Yii::$app->db->createCommand($sql_responses)
            ->queryAll();
        $ids = array_merge($hotels_requests_arr, $hotels_responses_arr);

        if(!empty($ids)) {
            foreach ($ids as $one) {
                $ids_new[$one['hotel_id']] = $one['value_occurrence'];
            }
        }else{
            $ids_new = [];
        }
        arsort($ids_new);
        $hotels_ids = [];
        foreach($ids_new as $key=>$value){
            $hotels_ids[] = $key;
        }
        $hotels = Hotel::find()->where(['hotel_id' => $hotels_ids])->limit(5)->all();

        return $this->render('top-hotels',['hotels' => $hotels, 'type' => $this->page]);
    }
}