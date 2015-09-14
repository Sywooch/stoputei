<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class HotToursSearch extends TourResponse
{
    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['id'], 'integer'],
            [['country_id', 'city_id', 'hotel.name', 'city.name', 'region.name'], 'safe'],
            //[['created_at'], 'date', 'format'=>'d.m']
        ];
    }

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['hotel.name', 'city.name', 'region.name']);
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TourResponse::find()->where(['is_hot_tour' => 1]);

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
                    'city_id',
                    'hotel_id',
                    'created_at',
                    'tour_cost'
                ],
            ],
        ]);

        $query->joinWith(['city']);
        $query->joinWith(['region']);
        $query->joinWith(['hotel']);
        $query->joinWith(['owner']);
        $dataProvider->sort->attributes['city.name'] = [
            'asc' => ['city.name' => SORT_ASC],
            'desc' => ['city.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['region.name'] = [
            'asc' => ['region.name' => SORT_ASC],
            'desc' => ['region.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['hotel.name'] = [
            'asc' => ['hotel.name' => SORT_ASC],
            'desc' => ['hotel.name' => SORT_DESC],
        ];

        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id, 'hotel_id' => $this->hotel_id]);
        $query->andFilterWhere(['like', 'region.name', $this->getAttribute('region.name')])
            ->andFilterWhere(['like', 'hotel.name', $this->getAttribute('hotel.name')])
            ->andFilterWhere(['like', 'city.name', $this->getAttribute('city.name')]);

        return $dataProvider;
    }
}