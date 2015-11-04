<?php
namespace app\components;

use yii\base\Widget;

class AdminNavbarWidget extends Widget
{
    public $active_link;
    public $active_link_users;
    public $active_link_managers;
    public $active_link_tour_requests;
    public $active_link_tour_responses;
    public $hot_tours;
    public $active_link_emails;
    public $active_link_payments;
    public $active_link_periods;
    public $active_link_pages;

    public function init()
    {
        parent::init();
        $this->active_link_users = '';
        $this->active_link_managers = '';
        $this->active_link_emails = '';
        $this->active_link_tour_requests = '';
        $this->active_link_tour_responses = '';
        $this->hot_tours = '';
        $this->active_link_payments = '';
        $this->active_link_periods = '';
        $this->active_link_pages = '';

        switch($this->active_link){
            case 'users':
                $this->active_link_users = 'active';
                break;
            case 'managers':
                $this->active_link_managers = 'active';
                break;
            case 'tour_requests':
                $this->active_link_tour_requests = 'active';
                break;
            case 'tour_responses':
                $this->active_link_tour_responses = 'active';
                break;
            case 'hot_tours':
                $this->hot_tours = 'active';
                break;
            case 'email':
                $this->active_link_emails = 'active';
                break;
            case 'payments':
                $this->active_link_payments = 'active';
                break;
            case 'periods':
                $this->active_link_periods = 'active';
                break;
            case 'pages':
                $this->active_link_pages = 'active';
                break;
        }
    }

    public function run()
    {
        return $this->render('admin-navbar-widget', [
            'active_link_users' => $this->active_link_users,
            'active_link_managers' => $this->active_link_managers,
            'active_link_emails' => $this->active_link_emails,
            'active_link_tour_requests' => $this->active_link_tour_requests,
            'active_link_tour_responses' => $this->active_link_tour_responses,
            'active_link_hot_tours' => $this->hot_tours,
            'active_link_payments' => $this->active_link_payments,
            'active_link_periods' => $this->active_link_periods,
            'active_link_pages' => $this->active_link_pages,
        ]);
    }
}