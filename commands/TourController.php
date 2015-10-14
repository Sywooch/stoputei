<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\modules\admin\models\TimeCycles;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class TourController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        $file = 'web/list.txt';
        $fh = fopen($file, 'a') or die("can't open file");
        $longDate = \Yii::$app->formatter->format('now', 'datetime');
        $timeCycle = TimeCycles::find()->where(['is not', 'id', null])->one();
        $tour_request_life = $timeCycle->tour_request_life;
        $tour_response_life = $timeCycle->tour_response_life;
        $flight_request_life = $timeCycle->flight_request_life;
        $flight_response_life = $timeCycle->flight_response_life;
        fwrite($fh, "Tour request life: $timeCycle->tour_request_life , Tour response life: $timeCycle->tour_response_life , Flight request life: $timeCycle->flight_request_life , Flight response life: $timeCycle->flight_response_life .... Write text at $longDate \n");
        fclose($fh);
        echo $message . "\n";
        echo 'TEST console controller' . "\n";
    }
}
