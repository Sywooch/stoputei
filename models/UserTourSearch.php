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
            [['country_id', 'resort_id', 'hotel_id', 'city.name', 'region.name'], 'safe'],
            //[['created_at'], 'date', 'format'=>'d.m']
        ];
    }

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['city.name', 'region.name']);
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
        $query->joinWith(['region']);
        $dataProvider->sort->attributes['city.name'] = [
            'asc' => ['city.name' => SORT_ASC],
            'desc' => ['city.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['region.name'] = [
            'asc' => ['region.name' => SORT_ASC],
            'desc' => ['region.name' => SORT_DESC],
        ];

        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'city.name', $this->getAttribute('city.name')])
            ->andFilterWhere(['like', 'region.name', $this->getAttribute('region.name')]);

        return $dataProvider;
    }
}