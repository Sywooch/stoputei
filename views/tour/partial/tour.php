<?php
use app\models\TourResponse;
$created = date('d.m.Y H:i:s', $tour->created_at);
$tourResponse = new TourResponse();
$isResponsed = $tourResponse->hasResponse($tour->id);
?>
<div class="user-tour-wrapper col-xs-12">
    <div class="col-xs-12 header-info">
        <span class="count"><?=Yii::t('app', 'Order').' № '.$tour->id;?></span>
        <span class="created"><?=$created;?></span>
        <?php if($isResponsed > 0):?>
            <span class="response">
                <i class="glyphicon glyphicon-ok-circle"></i>
                <span class="view-count">(<?=Yii::t('app', 'offers: {n}',['n' => $isResponsed]);?>)</span>
            </span>
        <?php endif;?>
    </div>
    <div class="col-xs-5 body">
        <div><span class="describe"><?=Yii::t('app', 'Destination');?></span> : <span class="data"><?=$tour->country->name;?></span></div>
        <div><span class="describe"><?=Yii::t('app', 'Resort');?> : <span class="data"><?=$tour->city->name;?></span></div>
        <?php if(!is_null($tour->hotel_id)):?>
            <div><span class="describe"><?=Yii::t('app', 'Hotel');?> : <span class="data"><?=$tour->hotel->name;?></span></div>
        <?php endif;?>
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
