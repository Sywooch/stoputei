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
            [
                'attribute' => 'city.name',
                'value' => function($model){
                    return $model->city->name.' ('.$model->city->country->name.')';
                }
            ],
            [
                'attribute' => 'region.name',
                'value' => function($model){
                    return $model->owner->city->name.' ('.$model->owner->city->country->name.')';
                }
            ],
            [
                'attribute' => 'budget',
                'value' => function($model){
                    if(in_array($model->owner->city->country->country_id, Yii::$app->params['depart_countries'])) {
                        return $model->budget . ' ' . $model->owner->city->country->currency->name;
                    }else{
                        return $model->budget . ' USD';
                    }
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