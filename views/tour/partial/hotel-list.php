<?php foreach($hotels as $key => $hotel):?>
    <?= $this->renderAjax('hotel', ['hotel' => $hotel]);?>
<?php endforeach;?>