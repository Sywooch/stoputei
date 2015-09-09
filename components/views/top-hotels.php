<?php if(count($hotels)):?>
    <div class="top-hotels">
        <div class="col-xs-12 main-title"><?=Yii::t('app', 'Top hotel for all directions');?></div>
        <?php foreach($hotels as $hotel):?>
            <?=$this->renderAjax('//hotel/partial/top-hotel', ['hotel' => $hotel, 'type' => $type]);?>
        <?php endforeach;?>
    </div>
<?php else:?>

<?php endif;?>