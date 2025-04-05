<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Company;

/**
 * CompanySearch แบบจำลองสำหรับการค้นหาบริษัท
 */
class CompanySearch extends Company
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['company_registration_number', 'company_name', 'authorized_person', 'proxy_person', 'email', 'phone'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // ข้ามการดำเนินการเมธอด scenarios() ของคลาสพื้นฐาน
        return Model::scenarios();
    }

    /**
     * สร้าง data provider สำหรับการค้นหา
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Company::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // ถ้าข้อมูลไม่ผ่านการตรวจสอบ กลับไปที่การเรียกดูทั้งหมด
            return $dataProvider;
        }

        // ตั้งค่าเงื่อนไขการค้นหา
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        // กรองตามข้อมูลแบบ text
        $query->andFilterWhere(['like', 'company_registration_number', $this->company_registration_number])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'authorized_person', $this->authorized_person])
            ->andFilterWhere(['like', 'proxy_person', $this->proxy_person])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}