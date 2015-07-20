<?php foreach($flights as $flight):?>
    <?= $this->renderAjax('flight-response', ['flight' => $flight]);?>
<?php endforeach;?>