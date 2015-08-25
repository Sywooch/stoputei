<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'StoPutei';
?>
<div class="site-index">
    <div class="row">
        <div class="col-xs-12" id="control-tabs">
            <ul class="nav nav-tabs user" role="tablist">
                <li role="presentation"><a href="#get-tour" aria-controls="get-tour" role="tab" data-toggle="tab" class="hotel"><?=Yii::t('app','Take a tour');?></a><span class="badge offers-tab tab-badge get-tour"></span></li>
                <li role="presentation"><a href="#offers" aria-controls="offers" role="tab" data-toggle="tab" class="tour"><?=Yii::t('app','Offers');?></a><span class="badge offers-tab tab-badge user-offers"><?=count($tourUserResponse);?></span></li>
                <li role="presentation"><a href="#flights" aria-controls="flights" role="tab" data-toggle="tab"><?=Yii::t('app','Flights');?></a><span class="badge offers-tab tab-badge flights"><?=count($flightsUserResponse);?></span></li>
                <li role="presentation"><a href="#favourites" aria-controls="favourites" role="tab" data-toggle="tab" class="tour"><?=Yii::t('app','Favourites');?></a><span class="badge offers-tab tab-badge favourites-tours"><?=count($userFavouriteTours);?></span></li>
                <li role="presentation" class="active"><a href="#hot-tour" aria-controls="hot-tour" role="tab" data-toggle="tab" class="tour"><?=Yii::t('app','Hot tours');?></a><span class="badge offers-tab tab-badge hot-tours"><?=count($userHotTours);?></span></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade" id="get-tour">
                    <?=$this->render('user-tabs/get-tour', [
                        'GetTourForm' => $GetTourForm,
                        'destinationDropdown' => $destinationDropdown,
                        'departCityDropdown' => $departCityDropdown,
                        'departCountryDropdown' => $departCountryDropdown
                    ]);?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="offers">
                    <?=$this->render('user-tabs/offers', [
                        'tourUserResponse' => $this->renderAjax('//tour/partial/tour-response-list', ['tours' => $tourUserResponse, 'tour_title' => 'offer']),
                        'destinationDropdown' => $destinationDropdown,
                        'TourOffersForm' => $TourOffersForm,
                        'cityDropdown' => $cityDropdown,
                    ]);?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="flights">
                    <?=$this->render('user-tabs/flights',[
                        'UserFlightForm' => $UserFlightForm,
                        'destinationDropdown' => $destinationDropdown,
                        'departCityDropdown' => $departCityDropdown,
                        'departCountryDropdown' => $departCountryDropdown,
                        'userFlights' => $this->renderAjax('//flight/partial/user-flight-response-list', ['flights' => $flightsUserResponse]),
                    ]);?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="favourites">
                    <?=$this->render('user-tabs/favourites',[
                        'UserFavouriteForm' => $userFavouriteForm,
                        'destinationDropdown' => $destinationDropdown,
                        'userFavouriteToursList' => $this->renderAjax('//tour/partial/tour-response-list', ['tours' => $userFavouriteTours, 'tour_title' => 'user-favourites']),
                    ]);?>
                </div>
                <div role="tabpanel" class="tab-pane fade in active" id="hot-tour">
                    <?=$this->render('user-tabs/hot-tour',[
                        'UserHotTourForm' => $UserHotTourForm,
                        'destinationDropdown' => $destinationDropdown,
                        'userHotToursList' => $this->renderAjax('//tour/partial/tour-response-list', ['tours' => $userHotTours, 'tour_title' => 'user-hot-tour']),
                    ]);?>
                </div>
            </div>
        </div>
        <?= Html::a('', Url::toRoute(['tour/ajax-resorts-dropdown']), ['class' => 'ajax-resort']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-resorts-dropdown-for-filter']), ['class' => 'ajax-resort-for-filter']);?>
        <?= Html::a('', Url::toRoute(['flight/ajax-get-empty-flight-form']), ['class' => 'ajax-empty-flight-form']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-get-empty-tour-form']), ['class' => 'ajax-empty-tour-form']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-create-same-tour']), ['class' => 'ajax-same-tour']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-get-offers-list']), ['class' => 'ajax-get-offers-list']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-hotels-autocomplete']), ['class' => 'ajax-hotel-autocomplete-offer']);?>
        <?= Html::a('', Url::toRoute(['flight/ajax-filter-flight-list']), ['class' => 'ajax-filter-flight-list']);?>
        <?= Html::a('', Url::toRoute(['tour/get-user-tour-full-info']), ['class' => 'ajax-user-tour-full-info']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-get-user-hot-tours-list']), ['class' => 'ajax-get-user-hot-tours-list']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-get-user-favourites-tours-list']), ['class' => 'ajax-get-user-favourites-tours-list']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-order-tours-list']), ['class' => 'ajax-order-tours-list']);?>
        <?= Html::a('', Url::toRoute(['flight/ajax-order-flights-list-user']), ['class' => 'ajax-order-flights-list-user']);?>
        <?= Html::a('', Url::toRoute(['tour/ajax-tour-full-info']), ['class' => 'ajax-tour-full-info']);?>
        <?= Html::a('', Url::toRoute(['hotel/ajax-show-hotel-full-info']), ['class' => 'ajax-show-hotel-full-info']);?>
        <?= Html::a('', Url::toRoute(['flight/ajax-show-flight-full-info-user']), ['class' => 'ajax-show-flight-full-info']);?>
    </div>
</div>
