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
                <li role="presentation" class="active"><a href="#create-tour" aria-controls="create-tour" role="tab" data-toggle="tab" class="hotel"><?=Yii::t('app','Create a tour');?></a><span class="badge offers-tab tab-badge create-hot-tour"></span></li>
                <li role="presentation"><a href="#tour-from-user" aria-controls="tour-from-user" role="tab" data-toggle="tab" class="hotel"><?=Yii::t('app','Tour from users');?></a><span class="badge offers-tab tab-badge"><?=count($userTours);?></span></li>
                <li role="presentation"><a href="#flights" aria-controls="flights" role="tab" data-toggle="tab"><?=Yii::t('app','Flights');?></a><span class="badge offers-tab tab-badge user-flights"><?=count($userFlights);?></span></li>
                <li role="presentation"><a href="#my-offers" aria-controls="my-offers" role="tab" data-toggle="tab" class="tour"><?=Yii::t('app','My offers');?></a><span class="badge offers-tab tab-badge manager-offers"><?=count($myOffers);?></span></li>
                <li role="presentation"><a href="#my-hot-tours" aria-controls="my-hot-tours" role="tab" data-toggle="tab" class="tour"><?=Yii::t('app','My hot tours');?></a><span class="badge offers-tab tab-badge manager-hot-tours"><?=count($myHotTours);?></span></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="create-tour">
                    <?=$this->render('manager-tabs/create-tour', [
                        'CreateHotTourForm' => $CreateHotTourForm,
                        'dropdownDestination' => $destinationDropdown,
                        'departCityThereDropdown' => $departCityDropdown,
                        'departCountryDropdown' => $departCountryDropdown
                    ]);?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tour-from-user">
                    <?=$this->render('manager-tabs/tour-from-user', [
                        'userTours' => $this->renderAjax('//tour/partial/user-tour-list', ['tours' => $userTours]),
                        'responseForm' => $this->renderAjax('//tour/partial/manager-tour-response-form-empty', [
                            'CreateTourForm' => $CreateTourForm,
                            'departCountryDropdown' => $departCountryDropdown
                        ]),
                    ]);?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="flights">
                    <?=$this->render('manager-tabs/flights', [
                        'userFlights' => $this->renderAjax('//flight/partial/user-flight-list', ['flights' => $userFlights]),
                        'responseForm' => $this->renderAjax('//flight/partial/manager-flight-response-form-empty', [
                            'ManagerFlightForm' => $ManagerFlightForm,
                            'departCountryDropdown' => $departCountryDropdown
                        ]),
                    ]);?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="my-offers">
                    <?=$this->render('manager-tabs/my-offers',[
                        'ManagerOffersForm' => $ManagerOffersForm,
                        'dropdownDestination' => $destinationDropdown,
                        'myOffers' => $this->renderAjax('//tour/partial/tour-response-list', ['tours' => $myOffers]),
                    ]);?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="my-hot-tours">
                    <?=$this->render('manager-tabs/my-hot-tours',[
                        'ManagerHotTourForm' => $ManagerHotTourForm,
                        'dropdownDestination' => $destinationDropdown,
                        'myHotTours' => $this->renderAjax('//tour/partial/tour-response-list', ['tours' => $myHotTours]),
                    ]);?>
                </div>
            </div>
        </div>

        <?= Html::a('', Url::toRoute(['tour/get-user-tour-list']), ['class' => 'ajax-user-tour-list']);?>
        <?= Html::a('', Url::toRoute(['tour/get-user-tour-full-info']), ['class' => 'ajax-user-tour-full-info']);?>
        <?= Html::a('', Url::toRoute(['flight/get-user-flight-full-info']), ['class' => 'ajax-user-flight-full-info']);?>
        <?= Html::a('', Url::toRoute(['flight/close-flight-full-info']), ['class' => 'ajax-close-user-flight-full-info']);?>
        <?= Html::a('', Url::toRoute(['tour/get-user-tour-request']), ['class' => 'ajax-user-tour-request']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-create-one-more-manager-response']), ['class' => 'ajax-create-one-more-manager-response']);?>
        <?= Html::a('', Url::toRoute(['flight/ajax-create-one-more-manager-flight-response']), ['class' => 'ajax-create-one-more-manager-flight-response']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-hotels-autocomplete-manager']), ['class' => 'ajax-hotel-autocomplete-manager']);?>
        <?= Html::a('', Url::toRoute(['tour/get-hotel-manager-list']), ['class' => 'ajax-hot-tour-hotel-list']);?>
        <?= Html::a('', Url::toRoute(['tour/create-one-more-hot-tour']), ['class' => 'ajax-create-one-more-hot-tour']);?>
        <?= Html::a('', Url::toRoute(['hotel/ajax-show-hotel-full-info']), ['class' => 'ajax-show-hotel-full-info']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-resorts-dropdown-for-filter']), ['class' => 'ajax-resort-for-filter']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-get-manager-offers-list']), ['class' => 'ajax-get-manager-offers-list']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-get-manager-hot-tours-list']), ['class' => 'ajax-get-manager-hot-tours-list']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-order-tours-list']), ['class' => 'ajax-order-tours-list']);?>
        <?= Html::a('', Url::toRoute(['flight/ajax-order-flights-list-manager']), ['class' => 'ajax-order-flights-list-manager']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-tour-full-info']), ['class' => 'ajax-tour-full-info']);?>
    </div>
</div>
