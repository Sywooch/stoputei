<?php
use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="admin-panel">
    <?= \app\components\AdminNavbarWidget::widget(['active_link' => 'hot_tours']);?>
    <?php
    echo GridView::widget([
        'dataProvider' => $provider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'country.name',
                'value' => function($model){
                    return $model->country->name;
                }
            ],
            [
                'attribute' => 'city.name',
                'value' => function($model){
                    return $model->city->name;
                }
            ],
            [
                'attribute' => 'hotel.name',
                'value' => function($model){
                    return $model->hotel->name;
                }
            ],
            [
                'attribute' => 'region_manager_id',
                'value' => function($model){
                    return $model->owner->city->name;
                }
            ],
        ],
    ]);
    ?>
</div>