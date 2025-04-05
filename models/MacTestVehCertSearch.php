<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MacTestVehCert;

/**
 * MacTestVehCertSearch represents the model behind the search form of `app\models\MacTestVehCert`.
 */
class MacTestVehCertSearch extends MacTestVehCert
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['OFF_CODE', 'BR_CODE', 'CAR_TEST_TYPE', 'CERT_YEAR', 'CERT_NO', 'TEST_VEH_CODE', 'TITLE_CODE', 'ID_NO', 'FNAME', 'LNAME', 'ADDR', 'DIST_CODE', 'AMP_CODE', 'PRV_CODE', 'PHONE', 'INS_CODE', 'INS_NO', 'INS_EXP_DATE', 'FST_PMT_DATE', 'PMT_DATE', 'EXP_DATE', 'CERT_STATUS', 'RENEW_DATE', 'LAST_CPY_DATE', 'STOP_USE_DATE', 'SEND_BACK_DATE', 'FNC_DATE', 'RCP_NO1', 'RCP_NO2', 'PRV_OFF_CODE', 'PRV_BR_CODE', 'PRV_CAR_TEST_TYPE', 'PRV_CERT_YEAR', 'PRV_CERT_NO', 'UPD_USER_CODE', 'LAST_UPD_DATE', 'CREATE_USER_CODE', 'CREATE_DATE'], 'safe'],
            [['NUM_CAR', 'NUM_PLATE', 'LAST_CPY_NO'], 'number'],
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
        $query = MacTestVehCert::find();

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
            'NUM_CAR' => $this->NUM_CAR,
            'NUM_PLATE' => $this->NUM_PLATE,
            'LAST_CPY_NO' => $this->LAST_CPY_NO,
            'LAST_UPD_DATE' => $this->LAST_UPD_DATE,
            'CREATE_DATE' => $this->CREATE_DATE,
        ]);

        $query->andFilterWhere(['like', 'OFF_CODE', $this->OFF_CODE])
            ->andFilterWhere(['like', 'BR_CODE', $this->BR_CODE])
            ->andFilterWhere(['like', 'CAR_TEST_TYPE', $this->CAR_TEST_TYPE])
            ->andFilterWhere(['like', 'CERT_YEAR', $this->CERT_YEAR])
            ->andFilterWhere(['like', 'CERT_NO', $this->CERT_NO])
            ->andFilterWhere(['like', 'TEST_VEH_CODE', $this->TEST_VEH_CODE])
            ->andFilterWhere(['like', 'TITLE_CODE', $this->TITLE_CODE])
            ->andFilterWhere(['like', 'ID_NO', $this->ID_NO])
            ->andFilterWhere(['like', 'FNAME', $this->FNAME])
            ->andFilterWhere(['like', 'LNAME', $this->LNAME])
            ->andFilterWhere(['like', 'ADDR', $this->ADDR])
            ->andFilterWhere(['like', 'DIST_CODE', $this->DIST_CODE])
            ->andFilterWhere(['like', 'AMP_CODE', $this->AMP_CODE])
            ->andFilterWhere(['like', 'PRV_CODE', $this->PRV_CODE])
            ->andFilterWhere(['like', 'PHONE', $this->PHONE])
            ->andFilterWhere(['like', 'INS_CODE', $this->INS_CODE])
            ->andFilterWhere(['like', 'INS_NO', $this->INS_NO])
            ->andFilterWhere(['like', 'INS_EXP_DATE', $this->INS_EXP_DATE])
            ->andFilterWhere(['like', 'FST_PMT_DATE', $this->FST_PMT_DATE])
            ->andFilterWhere(['like', 'PMT_DATE', $this->PMT_DATE])
            ->andFilterWhere(['like', 'EXP_DATE', $this->EXP_DATE])
            ->andFilterWhere(['like', 'CERT_STATUS', $this->CERT_STATUS])
            ->andFilterWhere(['like', 'RENEW_DATE', $this->RENEW_DATE])
            ->andFilterWhere(['like', 'LAST_CPY_DATE', $this->LAST_CPY_DATE])
            ->andFilterWhere(['like', 'STOP_USE_DATE', $this->STOP_USE_DATE])
            ->andFilterWhere(['like', 'SEND_BACK_DATE', $this->SEND_BACK_DATE])
            ->andFilterWhere(['like', 'FNC_DATE', $this->FNC_DATE])
            ->andFilterWhere(['like', 'RCP_NO1', $this->RCP_NO1])
            ->andFilterWhere(['like', 'RCP_NO2', $this->RCP_NO2])
            ->andFilterWhere(['like', 'PRV_OFF_CODE', $this->PRV_OFF_CODE])
            ->andFilterWhere(['like', 'PRV_BR_CODE', $this->PRV_BR_CODE])
            ->andFilterWhere(['like', 'PRV_CAR_TEST_TYPE', $this->PRV_CAR_TEST_TYPE])
            ->andFilterWhere(['like', 'PRV_CERT_YEAR', $this->PRV_CERT_YEAR])
            ->andFilterWhere(['like', 'PRV_CERT_NO', $this->PRV_CERT_NO])
            ->andFilterWhere(['like', 'UPD_USER_CODE', $this->UPD_USER_CODE])
            ->andFilterWhere(['like', 'CREATE_USER_CODE', $this->CREATE_USER_CODE]);

        return $dataProvider;
    }
}
