<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VehTestReportSchedule;

/**
 * VehTestReportScheduleSearch represents the model behind the search form about `app\models\VehTestReportSchedule`.
 */
class VehTestReportScheduleSearch extends VehTestReportSchedule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'PLATE_SEQ', 'created_by', 'updated_by'], 'integer'],
            [['OFF_CODE', 'BR_CODE', 'CAR_TEST_TYPE', 'CERT_YEAR', 'CERT_NO', 'PLATE1', 'PLATE2', 'report_date', 'report_month', 'report_status', 'actual_report_date', 'is_fined', 'fine_payment_status', 'fine_payment_date', 'fine_receipt_no', 'remarks', 'created_at', 'updated_at'], 'safe'],
            [['fine_amount'], 'number'],
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
        $query = VehTestReportSchedule::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'PLATE_SEQ' => $this->PLATE_SEQ,
            'report_date' => $this->report_date,
            'actual_report_date' => $this->actual_report_date,
            'fine_amount' => $this->fine_amount,
            'fine_payment_date' => $this->fine_payment_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'OFF_CODE', $this->OFF_CODE])
            ->andFilterWhere(['like', 'BR_CODE', $this->BR_CODE])
            ->andFilterWhere(['like', 'CAR_TEST_TYPE', $this->CAR_TEST_TYPE])
            ->andFilterWhere(['like', 'CERT_YEAR', $this->CERT_YEAR])
            ->andFilterWhere(['like', 'CERT_NO', $this->CERT_NO])
            ->andFilterWhere(['like', 'PLATE1', $this->PLATE1])
            ->andFilterWhere(['like', 'PLATE2', $this->PLATE2])
            ->andFilterWhere(['like', 'report_month', $this->report_month])
            ->andFilterWhere(['like', 'report_status', $this->report_status])
            ->andFilterWhere(['like', 'is_fined', $this->is_fined])
            ->andFilterWhere(['like', 'fine_payment_status', $this->fine_payment_status])
            ->andFilterWhere(['like', 'fine_receipt_no', $this->fine_receipt_no])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
