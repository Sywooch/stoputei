<?php foreach($tourUserResponse as $tour):?>
    <?= $this->renderAjax('user-tour-response', ['tour' => $tour]);?>
<?php endforeach;?>