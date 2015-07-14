<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'StoPutei';
?>
<div class="site-index">
    <div class="row">
        <div class="col-xs-12" id="control-tabs">
            <ul class="nav nav-tabs manager" role="tablist">
                <li role="presentation" class="active"><a href="#tour-from-user" aria-controls="tour-from-user" role="tab" data-toggle="tab"><?=Yii::t('app','Tour from users');?></a><span class="badge offers-tab tab-badge"><?=count($userTours);?></span></li>
                <li role="presentation"><a href="#flights" aria-controls="flights" role="tab" data-toggle="tab"><?=Yii::t('app','Flights');?></a><span class="badge offers-tab tab-badge"><?=count($userFlights);?></span></li>
                <li role="presentation"><a href="#my-offers" aria-controls="my-offers" role="tab" data-toggle="tab"><?=Yii::t('app','My offers');?></a></li>
                <li role="presentation"><a href="#my-hot-tours" aria-controls="my-hot-tours" role="tab" data-toggle="tab"><?=Yii::t('app','My hot tours');?></a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="tour-from-user">
                    <?=$this->render('manager-tabs/tour-from-user', [
                        'userTours' => $this->renderAjax('//tour/partial/user-tour-list', ['tours' => $userTours]),
                        'responseForm' => $this->renderAjax('//tour/partial/manager-tour-response-form-empty', [
                            'CreateTourForm' => $CreateTourForm
                        ]),
                    ]);?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="flights">
                    <?=$this->render('manager-tabs/flights', [
                        'userFlights' => $this->renderAjax('//flight/partial/user-flight-list', ['flights' => $userFlights]),
                        'responseForm' => $this->renderAjax('//flight/partial/manager-flight-response-form-empty', [
                            'ManagerFlightForm' => $ManagerFlightForm
                        ]),
                    ]);?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="my-offers">
                    <?=$this->render('manager-tabs/my-offers');?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="my-hot-tours">
                    <?=$this->render('manager-tabs/my-hot-tours');?>
                </div>
            </div>
        </div>

        <?= Html::a('', Url::toRoute(['tour/get-user-tour-list']), ['class' => 'ajax-user-tour-list']);?>
        <?= Html::a('', Url::toRoute(['tour/get-user-tour-full-info']), ['class' => 'ajax-user-tour-full-info']);?>
        <?= Html::a('', Url::toRoute(['tour/get-user-tour-request']), ['class' => 'ajax-user-tour-request']);?>
    </div>
</div>
