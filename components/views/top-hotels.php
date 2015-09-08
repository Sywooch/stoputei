<?php if(count($hotels)):?>
    <div class="top-hotels">
        <?php foreach($hotels as $hotel):?>
            <?=$this->renderAjax('//hotel/partial/top-hotel', ['hotel' => $hotel, 'type' => $type]);?>
        <?php endforeach;?>
    </div>
<?php else:?>

<?php endif;?>