<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MacTestVehCertDetailReport;

/**
 * MacTestVehCertDetailReportSearch represents the model behind the search form of `app\models\MacTestVehCertDetailReport`.
 */
class MacTestVehCertDetailReportSearch extends MacTestVehCertDetailReport
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'TEST_DISTANCE', 'TEST_TIME'], 'integer'],
            [['OFF_CODE', 'BR_CODE', 'CAR_TEST_TYPE', 'CERT_YEAR', 'CERT_NO', 'CAR_TYPE', 'PLATE1', 'PLATE2', 'NUM_BODY', 'ENG_FLAG', 'NUM_ENG', 'SERIES_NAME', 'TEST_DATE', 'IS_REPORT', 'REPORT_DATE', 'UPD_USER_CODE', 'LAST_UPD_DATE', 'CREATE_USER_CODE', 'CREATE_DATE'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = MacTestVehCertDetailReport::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'TEST_DISTANCE' => $this->TEST_DISTANCE,
            'TEST_TIME' => $this->TEST_TIME,
            'REPORT_DATE' => $this->REPORT_DATE,
            'LAST_UPD_DATE' => $this->LAST_UPD_DATE,
            'CREATE_DATE' => $this->CREATE_DATE,
        ]);

        $query->andFilterWhere(['like', 'OFF_CODE', $this->OFF_CODE])
            ->andFilterWhere(['like', 'BR_CODE', $this->BR_CODE])
            ->andFilterWhere(['like', 'CAR_TEST_TYPE', $this->CAR_TEST_TYPE])
            ->andFilterWhere(['like', 'CERT_YEAR', $this->CERT_YEAR])
            ->andFilterWhere(['like', 'CERT_NO', $this->CERT_NO])
            ->andFilterWhere(['like', 'CAR_TYPE', $this->CAR_TYPE])
            ->andFilterWhere(['like', 'PLATE1', $this->PLATE1])
            ->andFilterWhere(['like', 'PLATE2', $this->PLATE2])
            ->andFilterWhere(['like', 'NUM_BODY', $this->NUM_BODY])
            ->andFilterWhere(['like', 'ENG_FLAG', $this->ENG_FLAG])
            ->andFilterWhere(['like', 'NUM_ENG', $this->NUM_ENG])
            ->andFilterWhere(['like', 'SERIES_NAME', $this->SERIES_NAME])
            ->andFilterWhere(['like', 'TEST_DATE', $this->TEST_DATE])
            ->andFilterWhere(['like', 'IS_REPORT', $this->IS_REPORT])
            ->andFilterWhere(['like', 'UPD_USER_CODE', $this->UPD_USER_CODE])
            ->andFilterWhere(['like', 'CREATE_USER_CODE', $this->CREATE_USER_CODE]);

        return $dataProvider;
    }
}
