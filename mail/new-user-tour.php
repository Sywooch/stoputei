<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\admin\models\TimeCycles;

$timeCycle = TimeCycles::find()->where(['is not', 'id', null])->one();
$tourRequestLifeInSec = $timeCycle->tour_request_life*3600;
?>
<h3>Запрос на тур по направлению: <?=$tour->city->name;?> (<?=$tour->country->name;?>)</h3>
<div>
    <?php if(!empty($tour->hotel)):?>
        <p> Отель : <?=$tour->hotel->name;?></p>
    <?php endif;?>
    <p> Количество ночей : <?=$tour->night_max;?></p>
    <p> Количество взрослых : <?=$tour->adult_amount;?></p>
    <p> Перелет : <?=($tour->flight_included == 1)?'включен':'не включен';?></p>
    <p> Запрос актуален до : <b><?=Yii::$app->formatter->asDate((time()+$tourRequestLifeInSec),'yyyy-MM-dd');?></b></p>
    <p> Стоимость тура : <b><?=$tour->budget;?> <?=$tour->owner->city->country->currency->name;?></b></p>
    <?php if(!empty($tour->add_info)):?>
        <p> Дополнительная информация : <?= $tour->add_info;?></p>
    <?php endif;?>
</div>

<div>
    <?= Html::a(Yii::t('app','StoPutei'), Url::to(['site/index'], [true]));?>
</div>
