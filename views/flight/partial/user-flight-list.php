<?php foreach($flights as $flight):?>
    <?= $this->renderAjax('flight', ['flight' => $flight]);?>
<?php endforeach;?>