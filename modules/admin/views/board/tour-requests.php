<?php
use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="admin-panel">
    <?= \app\components\AdminNavbarWidget::widget(['active_link' => 'tour_requests']);?>
    <?php
    echo GridView::widget([
        'dataProvider' => $provider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
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
                'attribute' => 'night_max',
                'value' => function($model){
                    return $model->night_max;
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    return date('d.m.Y H:i', $model->created_at);
                }
            ],
        ],
    ]);
    ?>
</div>