<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="admin-panel">
    <?= \app\components\AdminNavbarWidget::widget(['active_link' => 'pages']);?>
    <?php if(Yii::$app->session->getFlash('success')):?>
        <?php
        echo \yii\bootstrap\Alert::widget([
            'options' => [
                'class' => 'alert-success',
            ],
            'body' => Yii::t('app', 'Page was updated successful'),
        ]);
        ?>
    <?php endif;?>
    <div class="periods">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><?=Yii::t('app','Page name');?></th>
                    <th><?=Yii::t('app','Title');?></th>
                    <th><?=Yii::t('app','Created');?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pages as $page):?>
                    <tr>
                        <td>
                            <?=$page->id;?>
                        </td>
                        <td>
                            <?= Html::a($page->name, Url::to(['/admin/pages/edit', 'id' => $page->id]));?>
                        </td>
                        <td>
                            <?= Html::a($page->title, Url::to(['/admin/pages/edit', 'id' => $page->id]));?>
                        </td>
                        <td>
                            <?=Yii::$app->formatter->asDate($page->created_at);?>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>