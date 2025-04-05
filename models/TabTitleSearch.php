<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TabTitle;

/**
 * TabTitleSearch represents the model behind the search form about `app\models\TabTitle`.
 */
class TabTitleSearch extends TabTitle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TITLE_CODE', 'TITLE_DESC', 'TITLE_ABREV', 'TITLE_SEX', 'TITLE_ENG_DESC', 'TITLE_ENG_ABREV', 'TITLE_BLANK_FLAG', 'UPD_USER_CODE', 'LAST_UPD_DATE', 'CREATE_USER_CODE', 'CREATE_DATE', 'PRIVATE_FLAG', 'PRT_FLAG', 'PERS_TYPE'], 'safe'],
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
        $query = TabTitle::find();

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

        $query->andFilterWhere(['like', 'TITLE_CODE', $this->TITLE_CODE])
            ->andFilterWhere(['like', 'TITLE_DESC', $this->TITLE_DESC])
            ->andFilterWhere(['like', 'TITLE_ABREV', $this->TITLE_ABREV])
            ->andFilterWhere(['like', 'TITLE_SEX', $this->TITLE_SEX])
            ->andFilterWhere(['like', 'TITLE_ENG_DESC', $this->TITLE_ENG_DESC])
            ->andFilterWhere(['like', 'TITLE_ENG_ABREV', $this->TITLE_ENG_ABREV])
            ->andFilterWhere(['like', 'TITLE_BLANK_FLAG', $this->TITLE_BLANK_FLAG])
            ->andFilterWhere(['like', 'UPD_USER_CODE', $this->UPD_USER_CODE])
            ->andFilterWhere(['like', 'CREATE_USER_CODE', $this->CREATE_USER_CODE])
            ->andFilterWhere(['like', 'PRIVATE_FLAG', $this->PRIVATE_FLAG])
            ->andFilterWhere(['like', 'PRT_FLAG', $this->PRT_FLAG])
            ->andFilterWhere(['like', 'PERS_TYPE', $this->PERS_TYPE]);

        return $dataProvider;
    }
}
