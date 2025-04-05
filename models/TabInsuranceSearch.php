<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TabInsurance;

/**
 * TabInsuranceSearch represents the model behind the search form about `app\models\TabInsurance`.
 */
class TabInsuranceSearch extends TabInsurance
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['INS_CODE', 'INS_NAME', 'INTER_FLAG', 'UPD_USER_CODE', 'LAST_UPD_DATE', 'CREATE_USER_CODE', 'CREATE_DATE', 'INS_ABBR_NAME'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TabInsurance::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'LAST_UPD_DATE' => $this->LAST_UPD_DATE,
            'CREATE_DATE' => $this->CREATE_DATE,
        ]);

        $query->andFilterWhere(['like', 'INS_CODE', $this->INS_CODE])
            ->andFilterWhere(['like', 'INS_NAME', $this->INS_NAME])
            ->andFilterWhere(['like', 'INTER_FLAG', $this->INTER_FLAG])
            ->andFilterWhere(['like', 'UPD_USER_CODE', $this->UPD_USER_CODE])
            ->andFilterWhere(['like', 'CREATE_USER_CODE', $this->CREATE_USER_CODE])
            ->andFilterWhere(['like', 'INS_ABBR_NAME', $this->INS_ABBR_NAME]);

        return $dataProvider;
    }
}
