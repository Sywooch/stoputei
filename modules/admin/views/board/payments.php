<?php
use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="admin-panel">
    <?= \app\components\AdminNavbarWidget::widget(['active_link' => 'payments']);?>
    <div>
        <?=\app\components\AdminHeaderLinksWidget::widget(['page' => 'payment']);?>
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
                    'attribute' => 'single_region_cost',
                    'value' => function($model){
                        return $model->single_region_cost;
                    }
                ],
                [
                    'attribute' => 'multiple_region_cost',
                    'value' => function($model){
                        return $model->multiple_region_cost;
                    }
                ],
                [
                    'attribute' => Yii::t('app', 'Actions'),
                    'format' => 'html',
                    'value' => function($model){
                        $actions = '';
                        $actions .= Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-eye-open view']), \yii\helpers\Url::toRoute(['/admin/user/view', 'id' => $model->id]), ['class' => 'actions col-xs-4']);
                        $actions .= Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil edit']), \yii\helpers\Url::toRoute(['/admin/user/edit', 'id' => $model->id]), ['class' => 'actions col-xs-4']);
                        $actions .= Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash delete']), \yii\helpers\Url::toRoute(['/admin/user/delete', 'id' => $model->id]), ['class' => 'actions col-xs-4']);
                        return $actions;
                    }
                ],
            ],
        ]);
        ?>
    </div>
</div>