<?php
namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PaymentSearch extends Payment
{
    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['country.name'], 'safe'],
        ];
    }

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['country.name']);
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Payment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

            'pagination' => [
                'pageSize' => 30,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                    'country_id' => SORT_ASC
                ],
                'attributes' => [
                    'id',
                    'country_id',
                    'single_region_cost',
                    'multiple_region_cost',
                ],
            ],
        ]);

        $query->joinWith(['country']);


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
        $query->andFilterWhere(['like', 'country.name', $this->getAttribute('country.name')]);


        return $dataProvider;
    }
}