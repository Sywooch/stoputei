<?php
use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="admin-panel">
    <?= \app\components\AdminNavbarWidget::widget(['active_link' => 'managers']);?>
    <?php
    echo GridView::widget([
        'dataProvider' => $provider,
        'filterModel' => $searchModel,
        'columns' => [
            'email',
            [
                'attribute' => 'city.name',
                'value' => function($model){
                    return $model->city->name.'( '.$model->city->country->name.' )';
                }
            ],
            [
                'attribute' => 'company_name',
                'value' => function($model){
                    return $model->company_name;
                }
            ],
            [
                'attribute' => 'company_phone',
                'value' => function($model){
                    return $model->company_phone;
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($model){
                    $date = new DateTime($model->updated_at);
                    return $date->format('d.m.Y H:i');
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