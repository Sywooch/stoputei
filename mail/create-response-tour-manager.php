<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\admin\models\TimeCycles;

$timeCycle = TimeCycles::find()->where(['is not', 'id', null])->one();
$tourResponseLifeInSec = $timeCycle->tour_response_life*3600;
?>
<h3>Предложение по направлению: <?=$tour->city->name;?> (<?=$tour->country->name;?>)</h3>
<div>
    <p> Отель : <?=$tour->hotel->name;?></p>
    <p> Количество ночей : <?=$tour->night_count;?></p>
    <p> Количество взрослых : <?=$tour->adult_amount;?></p>
    <p> Перелет : <?=($tour->flight_included == 1)?'включен':'не включен';?></p>
    <p> Количество билетов : <?=($tour->tickets_exist == 1)?'много':'мало';?></p>
    <p> Тур актуален до : <b><?=Yii::$app->formatter->asDate((time()+$tourResponseLifeInSec),'yyyy-MM-dd');?></b></p>
    <p> Стоимость тура : <b><?=$tour->tour_cost;?> <?=$tour->owner->city->country->currency->name;?></b></p>
</div>

<div>
    <?= Html::a(Yii::t('app','StoPutei'), Url::to(['site/index'], [true]));?>
</div>
