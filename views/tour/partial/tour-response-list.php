<?php foreach($tours as $tour):?>
    <?= $this->renderAjax('user-tour-response', ['tour' => $tour]);?>
<?php endforeach;?>