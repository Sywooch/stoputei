<?php
namespace app\components;

use yii\base\Widget;

class AdminHeaderLinksWidget extends Widget
{
    public $page;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        switch($this->page){
            case 'payment':
                return $this->render('payment-header-links');
        }
    }
}