<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserTourSearch extends UserTour
{
    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['id'], 'integer'],
            [['country_id', 'resort_id', 'hotel_id', 'city.name', 'country.name'], 'safe'],
            //[['created_at'], 'date', 'format'=>'d.m']
        ];
    }

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['city.name', 'country.name']);
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = UserTour::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

            'pagination' => [
                'pageSize' => 30,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,

                ],
                'attributes' => [
                    'id',
                    'country_id',
                    'resort_id',
                    'hotel_id',
                    'created_at',
                    'budget'
                ],
            ],
        ]);

        $query->joinWith(['city']);
        $query->joinWith(['country']);
        $dataProvider->sort->attributes['city.name'] = [
            'asc' => ['city.name' => SORT_ASC],
            'desc' => ['city.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['country.name'] = [
            'asc' => ['country.name' => SORT_ASC],
            'desc' => ['country.name' => SORT_DESC],
        ];

        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'country.name', $this->getAttribute('country.name')])
            ->andFilterWhere(['like', 'city.name', $this->getAttribute('city.name')]);

        return $dataProvider;
    }
}