<?php
use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="admin-panel">
    <?= \app\components\AdminNavbarWidget::widget(['active_link' => 'tour_responses']);?>
    <?php
    echo GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            'id',
            [
                'attribute' => 'country_id',
                'value' => function($model){
                    return $model->country->name;
                }
            ],
            [
                'attribute' => 'city_id',
                'value' => function($model){
                    return $model->city->name;
                }
            ],
            [
                'attribute' => 'hotel_id',
                'value' => function($model){
                    return $model->hotel->name;
                }
            ],
        ],
    ]);
    ?>
</div>