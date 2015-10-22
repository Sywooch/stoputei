<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\admin\models\TimeCycles;

$flight_class = '';
switch($flight->flight_class){
    case 0:
        $flight_class = Yii::t('app', 'Any class');
        break;
    case 1:
        $flight_class = Yii::t('app', 'Economy class');
        break;
    case 2:
        $flight_class = Yii::t('app', 'Business class');
        break;
}

$timeCycle = TimeCycles::find()->where(['is not', 'id', null])->one();
$flightRequestLifeInSec = $timeCycle->flight_request_life*3600;
?>
<h3>Запрос на авиабилет по направлению: <?=$flight->city->name;?> (<?=$flight->country->name;?>)</h3>
<div>
    <p> Город вылета : <?=$flight->departCity->name;?> (<?=$flight->departCity->country->name;?>)</p>
    <p> <?=($flight->way_ticket == 2)?'В обе стороны':'В одну сторону';?></p>
    <p> Запрос актуален до : <b><?=Yii::$app->formatter->asDate((time()+$flightRequestLifeInSec),'yyyy-MM-dd');?></b></p>
    <p> Класс : <?=$flight_class;?></p>
</div>

<div>
    <?= Html::a(Yii::t('app','StoPutei'), Url::to(['site/index'], [true]));?>
</div>
