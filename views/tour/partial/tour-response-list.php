<?php foreach($tours as $tour):?>
    <?= $this->renderAjax('user-tour-response', ['tour' => $tour, 'tour_title' => $tour_title]);?>
<?php endforeach;?>