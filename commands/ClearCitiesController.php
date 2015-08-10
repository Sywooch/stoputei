<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Country;
use yii\console\Controller;
use app\models\City;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ClearCitiesController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        $ekskurs_city = City::find()->where(['like', 'name', 'область'])->all();
        foreach($ekskurs_city as $each){
            echo $each->name." \n";
            $each->delete();
        }
        return;
        $cities = City::find()->orderBy('name')->all();
        foreach($cities as $key => $city){
            echo "KEY: $key ... ID: $city->city_id ... $city->name \n";
            $current_city = City::find()->where(['name' => $city->name])->count();
            if($current_city > 1){
                $duplicate_city = City::find()->where(['name' => $city->name])->one();
                echo 'COUNT : '.$current_city.'  '.$duplicate_city->name." \n";
                $duplicate_city->delete();

            }
        }
    }
}
