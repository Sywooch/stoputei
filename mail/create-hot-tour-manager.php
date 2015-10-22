<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<h3>Создан новый горящий тур: <?=$tour->city->name;?> (<?=$tour->country->name;?>)</h3>
<div>
    <p> Отель : <?=$tour->hotel->name;?></p>
    <p> Количество ночей : <?=$tour->night_count;?></p>
    <p> Количество взрослых : <?=$tour->adult_amount;?></p>
    <p> Перелет : <?=($tour->flight_included == 1)?'включен':'не включен';?></p>
    <p> Количество билетов : <?=($tour->tickets_exist == 1)?'много':'мало';?></p>
    <p> Тур актуален до : <b><?=Yii::$app->formatter->asDate($tour->deadline, 'short');?></b></p>
    <p> Стоимость тура : <b><?=$tour->tour_cost;?> <?=$tour->owner->city->country->currency->name;?></b></p>
</div>

<div>
    <?= Html::a(Yii::t('app','StoPutei'), Url::to(['site/index'], [true]));?>
</div>
