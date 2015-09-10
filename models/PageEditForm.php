<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class PageEditForm extends Model
{
    public $title;
    public $body;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // title and body are required
            [['title', 'body'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Title of page'),
            'body' => Yii::t('app', 'Body of page'),
        ];
    }
}
