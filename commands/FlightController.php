<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\FlightResponse;
use app\models\UserFlight;
use app\models\UserTour;
use yii\console\Controller;
use app\modules\admin\models\TimeCycles;
use app\models\TourResponse;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FlightController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
        echo 'TEST' . "\n";
    }


    public function actionClear()
    {
        echo 'Starting clear flight....'. "\n";

        $timeCycle = TimeCycles::find()->where(['is not', 'id', null])->one();
        $flightRequestLifeInSec = $timeCycle->flight_request_life*3600;
        $flightResponseLifeInSec = $timeCycle->flight_response_life*3600;

        //all user request flight for deleting
        $flightRequest = UserFlight::find()->where(['<', 'created_at', (\Yii::$app->formatter->format('now', 'timestamp') - $flightRequestLifeInSec)])->all();
        foreach($flightRequest as $userFlight){
            $userFlight->delete();
            echo "USER FLIGHT ID $userFlight->id \n";
            echo 'USER Flight deadline: '.\Yii::$app->formatter->asDate($userFlight->created_at, 'yyyy-MM-dd')."\n";
        }

        //all manager response flight for deleting
        $flightResponse = FlightResponse::find()->where(['<', 'created_at', (\Yii::$app->formatter->format('now', 'timestamp') - $flightResponseLifeInSec)])->all();
        foreach($flightResponse as $managerFlight){
            $managerFlight->delete();
            echo "MANAGER FLIGHT ID $managerFlight->id \n";
            echo 'MANAGER Flight deadline: '.\Yii::$app->formatter->asDate($managerFlight->created_at, 'yyyy-MM-dd')."\n";
        }
    }
}
