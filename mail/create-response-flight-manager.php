<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\admin\models\TimeCycles;

$flight_class = '';
switch($flight->flight_class){
    case 0:
        $flight_class = Yii::t('app', 'Economy class');
        break;
    case 1:
        $flight_class = Yii::t('app', 'Business class');
        break;
    default:
        $flight_class = Yii::t('app', 'Business class');
        break;
}

$timeCycle = TimeCycles::find()->where(['is not', 'id', null])->one();
$flightResponseLifeInSec = $timeCycle->flight_response_life*3600;
?>
<h3>Предложение авиабилета по направлению: <?=$flight->city->name;?> (<?=$flight->country->name;?>)</h3>
<div>
    <p> Город вылета : <?=$flight->departCity->name;?> (<?=$flight->departCity->country->name;?>)</p>
    <p> <?=($flight->way_ticket == 2)?'В обе стороны':'В одну сторону';?></p>
    <p> Запрос актуален до : <b><?=Yii::$app->formatter->asDate((time()+$flightResponseLifeInSec),'yyyy-MM-dd');?></b></p>
    <p> Класс : <?=$flight_class;?></p>
    <p> Стоимость авиабилета : <?=$flight->flight_cost;?> <?=$flight->owner->city->country->currency->name;?></p>
</div>

<div>
    <?= Html::a(Yii::t('app','StoPutei'), Url::to(['site/index'], [true]));?>
</div>
