<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Alert;
?>
<div class="admin-panel">
    <?= \app\components\AdminNavbarWidget::widget(['active_link' => 'users']);?>
    <?php if(Yii::$app->session->getFlash('success')):?>
        <?php
        echo Alert::widget([
            'options' => [
                'class' => 'alert-success',
            ],
            'body' => Yii::t('app', 'Tourist was updated successful.'),
        ]);
        ?>
    <?php endif;?>
    <?php
    echo GridView::widget([
        'dataProvider' => $provider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'email',
            [
                'attribute' => 'approved',
                'format' => 'html',
                'value' => function($model){
                    if($model->approved == 1){
                        return Html::tag('span', '', ['class' => 'glyphicon glyphicon-ok paid']);
                    }else{
                        return Html::tag('span', '', ['class' => 'glyphicon glyphicon-remove']);
                    }
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
                'attribute' => 'created_at',
                'value' => function($model){
                    $date = new DateTime($model->created_at);
                    return $date->format('d.m.Y H:i');
                }
            ],

            [
                'attribute' => Yii::t('app', 'Actions'),
                'format' => 'html',
                'value' => function($model){
                    $actions = '';
                    $actions .= Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil edit']), \yii\helpers\Url::toRoute(['/admin/users/edit', 'id' => $model->id]), ['class' => 'actions col-xs-6']);
                    $actions .= Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash delete']), \yii\helpers\Url::toRoute(['/admin/users/delete', 'id' => $model->id]), ['class' => 'actions delete col-xs-6']);
                    return $actions;
                }
            ],
        ],
    ]);
    ?>
</div>