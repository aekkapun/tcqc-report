<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MacTestVehCertDetail;

/**
 * MacTestVehCertDetailSearch represents the model behind the search form of `app\models\MacTestVehCertDetail`.
 */
class MacTestVehCertDetailSearch extends MacTestVehCertDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['OFF_CODE', 'BR_CODE', 'CAR_TEST_TYPE', 'CERT_YEAR', 'CERT_NO', 'CAR_TYPE', 'PLATE1', 'PLATE2', 'NUM_BODY', 'ENG_FLAG', 'NUM_ENG', 'SERIES_NAME', 'TEST_DATE', 'RENEW_DATE', 'LAST_CPY_DATE', 'SEND_BACK_DATE', 'STOP_USE_DATE', 'SEND_BACK_FLAG', 'VEH_STATUS', 'UPD_USER_CODE', 'LAST_UPD_DATE', 'CREATE_USER_CODE', 'CREATE_DATE'], 'safe'],
            [['PLATE_SEQ', 'LAST_CPY_NO'], 'number'],
            [['TEST_DISTANCE', 'TEST_TIME'], 'integer'],
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
    public function search($params, $formName = null,$findName = null)
    {

    $query = MacTestVehCertDetail::find()
        ->alias('d')  // Alias for `mac_test_veh_cert_detail`
        ->joinWith(['macTestVehCert mac']) // Alias for `mac_test_veh_cert`
        ->andWhere(['mac.ID_NO' => $findName]);

    // ✅ Explicitly reference columns with their aliases to avoid ambiguity
    $query->andFilterWhere(['like', 'd.CAR_TEST_TYPE', $this->CAR_TEST_TYPE])
          ->andFilterWhere(['like', 'd.CAR_TYPE', $this->CAR_TYPE]);

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
            'PLATE_SEQ' => $this->PLATE_SEQ,
            'TEST_DISTANCE' => $this->TEST_DISTANCE,
            'TEST_TIME' => $this->TEST_TIME,
            'LAST_CPY_NO' => $this->LAST_CPY_NO,
            'LAST_UPD_DATE' => $this->LAST_UPD_DATE,
            'CREATE_DATE' => $this->CREATE_DATE,
            'd.CAR_TEST_TYPE'=>'Q',
        ]);

        $query->andFilterWhere(['like', 'd.OFF_CODE', $this->OFF_CODE])
            ->andFilterWhere(['like', 'd.d.BR_CODE', $this->BR_CODE])
            ->andFilterWhere(['like', 'd.CAR_TEST_TYPE', $this->CAR_TEST_TYPE])
            ->andFilterWhere(['like', 'd.CERT_YEAR', $this->CERT_YEAR])
            ->andFilterWhere(['like', 'd.CERT_NO', $this->CERT_NO])
            ->andFilterWhere(['like', 'd.CAR_TYPE', $this->CAR_TYPE])
            ->andFilterWhere(['like', 'd.PLATE1', $this->PLATE1])
            ->andFilterWhere(['like', 'd.PLATE2', $this->PLATE2])
            ->andFilterWhere(['like', 'NUM_BODY', $this->NUM_BODY])
            ->andFilterWhere(['like', 'ENG_FLAG', $this->ENG_FLAG])
            ->andFilterWhere(['like', 'NUM_ENG', $this->NUM_ENG])
            ->andFilterWhere(['like', 'SERIES_NAME', $this->SERIES_NAME])
            ->andFilterWhere(['like', 'TEST_DATE', $this->TEST_DATE])
            ->andFilterWhere(['like', 'RENEW_DATE', $this->RENEW_DATE])
            ->andFilterWhere(['like', 'LAST_CPY_DATE', $this->LAST_CPY_DATE])
            ->andFilterWhere(['like', 'SEND_BACK_DATE', $this->SEND_BACK_DATE])
            ->andFilterWhere(['like', 'STOP_USE_DATE', $this->STOP_USE_DATE])
            ->andFilterWhere(['like', 'SEND_BACK_FLAG', $this->SEND_BACK_FLAG])
            ->andFilterWhere(['like', 'VEH_STATUS', $this->VEH_STATUS])
            ->andFilterWhere(['like', 'UPD_USER_CODE', $this->UPD_USER_CODE])
            ->andFilterWhere(['like', 'CREATE_USER_CODE', $this->CREATE_USER_CODE]);

        return $dataProvider;
    }
}
