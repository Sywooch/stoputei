<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="navbar-admin">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="row">
                <ul class="nav navbar-nav">
                    <li>
                        <?= Html::a(Yii::t('app', 'Managers'), Url::toRoute(['/admin/board/managers']), ['class' => ' '.$active_link_managers]);?>
                    </li>
                    <li>
                        <?= Html::a(Yii::t('app', 'Users'), Url::toRoute(['/admin/board/users']), ['class' => ' '.$active_link_users]);?>
                    </li>
                    <li>
                        <?= Html::a(Yii::t('app', 'Tour requests'), Url::toRoute(['/admin/board/tour-requests']), ['class' => ' '.$active_link_tour_requests]);?>
                    </li>
                    <li>
                        <?= Html::a(Yii::t('app', 'Tour responses'), Url::toRoute(['/admin/board/tour-responses']), ['class' => ' '.$active_link_tour_responses]);?>
                    </li>
                    <li>
                        <?= Html::a(Yii::t('app', 'Hot tours'), Url::toRoute(['/admin/board/hot-tours']), ['class' => ' '.$active_link_hot_tours]);?>
                    </li>
                    <li>
                        <?= Html::a(Yii::t('app', 'Email management'), Url::toRoute(['/admin/board/emails']), ['class' => ' '.$active_link_emails]);?>
                    </li>
                    <li>
                        <?= Html::a(Yii::t('app', 'Payments'), Url::toRoute(['/admin/board/payments']), ['class' => ' '.$active_link_payments]);?>
                    </li>
                    <li>
                        <?= Html::a(Yii::t('app', 'Time cycles'), Url::toRoute(['/admin/board/periods']), ['class' => ' '.$active_link_periods]);?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>