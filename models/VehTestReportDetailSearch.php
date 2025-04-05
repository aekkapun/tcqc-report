<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VehTestReportDetail;

/**
 * VehTestReportDetailSearch represents the model behind the search form about `app\models\VehTestReportDetail`.
 */
class VehTestReportDetailSearch extends VehTestReportDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'schedule_id', 'created_by', 'updated_by'], 'integer'],
            [['test_date_from', 'test_date_to', 'test_location', 'test_purpose', 'test_result', 'report_file', 'remarks', 'created_at', 'updated_at'], 'safe'],
            [['test_distance', 'test_time'], 'number'],
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
        $query = VehTestReportDetail::find();

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
            'schedule_id' => $this->schedule_id,
            'test_date_from' => $this->test_date_from,
            'test_date_to' => $this->test_date_to,
            'test_distance' => $this->test_distance,
            'test_time' => $this->test_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'test_location', $this->test_location])
            ->andFilterWhere(['like', 'test_purpose', $this->test_purpose])
            ->andFilterWhere(['like', 'test_result', $this->test_result])
            ->andFilterWhere(['like', 'report_file', $this->report_file])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
