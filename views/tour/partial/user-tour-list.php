<?php foreach($tours as $key => $tour):?>
    <?= $this->renderAjax('tour', ['tour' => $tour]);?>
<?php endforeach;?>