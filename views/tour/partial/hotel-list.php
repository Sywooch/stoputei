<?php foreach($hotels as $key => $hotel):?>
    <?= $this->renderAjax('hotel', ['hotel' => $hotel, 'filter_type' => $filter_type]);?>
<?php endforeach;?>