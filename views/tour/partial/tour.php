<?php
$date = new DateTime($tour->created_at);
?>
<div class="user-tour-wrapper col-xs-12">
    <div class="col-xs-12 header-info">
        <span class="count"><?=Yii::t('app', 'Order').' № '.$tour->id;?></span>
        <span class="created"><?=$date->format('d.m.Y H:i:s');?></span>
    </div>
    <div class="col-xs-5 body">
        <div><span class="describe"><?=Yii::t('app', 'Destination');?></span> : <span class="data"><?=$tour->country->name;?></span></div>
        <div><span class="describe"><?=Yii::t('app', 'Resort');?> : <span class="data"><?=$tour->city->name;?></span></div>
    </div>
    <div class="col-xs-5 people">
        <div><span class="describe"><?=Yii::t('app', 'Amount of adult');?></span> : <span class="data"><?= $tour->adult_amount;?></span></div>
        <div><span class="describe"><?=Yii::t('app', 'Amount of children (under 12 years old)');?></span> : <span class="data"><?= $tour->children_under_12_amount;?></span></div>
        <div><span class="describe"><?=Yii::t('app', 'Amount of children (under 2 years old)');?></span> : <span class="data"><?= $tour->children_under_2_amount;?></span></div>
    </div>
    <div class="col-xs-2 buttons">
        <a href="#" class="tour-more-info btn btn-primary" data-tour-id="<?=$tour->id;?>"><?= Yii::t('app', 'More');?></a>
    </div>
</div>
