<?php
namespace app\components;

use yii\base\Widget;

class AdminNavbarWidget extends Widget
{
    public $active_link;
    public $active_link_users;
    public $active_link_tour_requests;
    public $active_link_tour_responses;
    public $active_link_emails;

    public function init()
    {
        parent::init();
        $this->active_link_users = '';
        $this->active_link_emails = '';
        $this->active_link_tour_requests = '';
        $this->active_link_tour_responses = '';
        switch($this->active_link){
            case 'users':
                $this->active_link_users = 'active';
                break;
            case 'tour_requests':
                $this->active_link_tour_requests = 'active';
                break;
            case 'tour_responses':
                $this->active_link_tour_responses = 'active';
                break;
            case 'email':
                $this->active_link_emails = 'active';
                break;
        }
    }

    public function run()
    {
        return $this->render('admin-navbar-widget', [
            'active_link_users' => $this->active_link_users,
            'active_link_emails' => $this->active_link_emails,
            'active_link_tour_requests' => $this->active_link_tour_requests,
            'active_link_tour_responses' => $this->active_link_tour_responses,
        ]);
    }
}