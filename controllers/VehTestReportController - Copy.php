<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use app\models\MacTestVehCertDetail;
use app\models\VehTestReportSchedule;
use app\components\LicenseReportCalculator;

/**
 * VehTestReportController สำหรับจัดการข้อมูลการรายงานการใช้เครื่องหมาย
 */
class VehTestReportController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create-report-schedule', 'create-report-schedule-all', 'renew-report-schedule'],
                'rules' => [
                    [
                        'actions' => ['create-report-schedule', 'create-report-schedule-all', 'renew-report-schedule'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create-report-schedule' => ['POST'],
                    'create-report-schedule-all' => ['POST'],
                    'renew-report-schedule' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * สร้างกำหนดการรายงานสำหรับรถทดสอบใหม่
     *
     * @return string
     */
    public function actionCreateReportSchedule()
    {
        $request = Yii::$app->request;
        
        if ($request->isPost) {
            $off_code = $request->post('OFF_CODE');
            $br_code = $request->post('BR_CODE');
            $car_test_type = $request->post('CAR_TEST_TYPE');
            $cert_year = $request->post('CERT_YEAR');
            $cert_no = $request->post('CERT_NO');
            $plate1 = $request->post('PLATE1');
            $plate2 = $request->post('PLATE2');
            $start_date = $request->post('START_LICENSE_DATE');
            $end_date = $request->post('PMT_DATE');
            
            // ตรวจสอบการกรอกข้อมูล
            if (empty($off_code) || empty($br_code) || empty($car_test_type) || 
                empty($cert_year) || empty($cert_no) || empty($plate1) || 
                empty($plate2) || empty($start_date) || empty($end_date)) {
                return Json::encode([
                    'success' => false,
                    'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน'
                ]);
            }
            
            // ตรวจสอบว่ามีข้อมูลรถในระบบหรือไม่
            $carTest = $this->findCarTestModel($off_code, $br_code, $car_test_type, $cert_year, $cert_no, $plate1, $plate2);
            
            if (!$carTest) {
                return Json::encode([
                    'success' => false,
                    'message' => 'ไม่พบข้อมูลรถทดสอบในระบบ'
                ]);
            }
            
            try {
                // แปลงรูปแบบวันที่
                $startDateObj = \DateTime::createFromFormat('d/m/Y', $start_date);
                $endDateObj = \DateTime::createFromFormat('d/m/Y', $end_date);
                
                if (!$startDateObj || !$endDateObj) {
                    return Json::encode([
                        'success' => false,
                        'message' => 'รูปแบบวันที่ไม่ถูกต้อง (ต้องเป็น dd/mm/yyyy)'
                    ]);
                }
                
                $startDateSql = $startDateObj->format('Y-m-d');
                $endDateSql = $endDateObj->format('Y-m-d');
                
                // คำนวณวันที่ต้องรายงาน Yii::$app->LicenseReportCalculator->calculateReportDates
                $calculator = new LicenseReportCalculator();
                $reportDates = $calculator->calculateReportDates($start_date, $end_date);
                
                // เริ่ม Transaction
                $transaction = Yii::$app->db->beginTransaction();
                
                $createdCount = 0;
                
                // บันทึกข้อมูลกำหนดการรายงาน
                foreach ($reportDates['reportDates'] as $index => $reportDate) {
                    // แปลงรูปแบบวันที่จาก dd/mm/yyyy เป็น yyyy-mm-dd
                    $reportDateObj = \DateTime::createFromFormat('d/m/Y', $reportDate);
                    $reportDateSql = $reportDateObj->format('Y-m-d');
                    
                    // คำนวณเดือนที่รายงาน (เดือนก่อนหน้าวันที่รายงาน)
                    $reportMonth = date('Y-m', strtotime('-1 month', strtotime($reportDateSql)));
                    
                    // สร้างโมเดลใหม่
                    $model = new VehTestReportSchedule();
                    $model->OFF_CODE = $off_code;
                    $model->BR_CODE = $br_code;
                    $model->CAR_TEST_TYPE = $car_test_type;
                    $model->CERT_YEAR = $cert_year;
                    $model->CERT_NO = $cert_no;
                    $model->PLATE1 = $plate1;
                    $model->PLATE2 = $plate2;
                    $model->report_date = $reportDateSql;
                    $model->report_month = $reportMonth;
                    $model->report_status = 'pending';
                    $model->created_by = Yii::$app->user->id;
                    
                    // บันทึกข้อมูล
                    if ($model->save()) {
                        $createdCount++;
                    } else {
                        // ถ้าเกิดข้อผิดพลาด ให้ยกเลิก Transaction
                        $transaction->rollBack();
                        return Json::encode([
                            'success' => false,
                            'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . Json::encode($model->errors)
                        ]);
                    }
                }
                
                // บันทึก Transaction
                $transaction->commit();
                
                // บันทึกประวัติการทำงาน
                Yii::$app->getModule('audit')->data('CREATE_REPORT_SCHEDULE', [
                    'message' => 'สร้างกำหนดการรายงานสำหรับ ' . $cert_year . '-' . $cert_no . ' ทะเบียน ' . $plate1 . ' ' . $plate2,
                    'data' => [
                        'totalReports' => $createdCount,
                        'license' => $cert_year . '-' . $cert_no,
                        'plate' => $plate1 . ' ' . $plate2
                    ]
                ]);
                
                return Json::encode([
                    'success' => true,
                    'message' => 'สร้างกำหนดการรายงานสำเร็จ จำนวน ' . $createdCount . ' รายการ',
                    'totalDays' => $reportDates['totalDays'],
                    'count' => $createdCount
                ]);
                
            } catch (\Exception $e) {
                if (isset($transaction)) {
                    $transaction->rollBack();
                }
                
                Yii::error('เกิดข้อผิดพลาดในการสร้างกำหนดการรายงาน: ' . $e->getMessage());
                
                return Json::encode([
                    'success' => false,
                    'message' => 'เกิดข้อผิดพลาดในการสร้างกำหนดการรายงาน: ' . $e->getMessage()
                ]);
            }
        }
        
        return Json::encode([
            'success' => false,
            'message' => 'กรุณาใช้เมธอด POST'
        ]);
    }
    
    /**
     * สร้างกำหนดการรายงานสำหรับรถทดสอบทั้งหมดที่ยังไม่หมดอายุ
     *
     * @return string
     */
    public function actionCreateReportScheduleAll()
    {
        try {
            // ค้นหารถทดสอบทั้งหมดที่ยังไม่หมดอายุและไม่ได้ส่งคืนเครื่องหมาย

            $carTests = MacTestVehCertDetail::find()
                ->joinWith('macTestVehCert') // ใช้ Relation ที่สร้างไว้
                ->Where(['mac_test_veh_cert_detail.CAR_TEST_TYPE' => 'Q'])
              /*  ->Where(['mac_test_veh_cert.END_LICENSE_DATE' => 'A'])
                 ->Where(['mac_test_veh_cert.CERT_STATUS' => 'A'])
                ->andWhere(['mac_test_veh_cert_detail.VEH_STATUS' => 'A'])
               ->andWhere([
                    'or',
                    ['mac_test_veh_cert_detail.STOP_USE_DATE' => null],
                    ['>', 'mac_test_veh_cert_detail.STOP_USE_DATE', date('Y-m-d')]
                ])*/
                ->all();
            
            if (empty($carTests)) {
                return Json::encode([
                    'success' => false,
                    'message' => 'ไม่พบรถทดสอบที่ยังไม่หมดอายุในระบบ'
                ]);
            }
            
            // เริ่ม Transaction
            $transaction = Yii::$app->db->beginTransaction();
            
            $createdCount = 0;
            $vehicleCount = 0;
            $calculator = new LicenseReportCalculator();
            
            foreach ($carTests as $carTest) {
                // ตรวจสอบว่ามีกำหนดการรายงานอยู่แล้วหรือไม่
                $existingReports = VehTestReportSchedule::find()
                    ->where([
                        'OFF_CODE' => $carTest->OFF_CODE,
                        'BR_CODE' => $carTest->BR_CODE,
                        'CAR_TEST_TYPE' => $carTest->CAR_TEST_TYPE,
                        'CERT_YEAR' => $carTest->CERT_YEAR,
                        'CERT_NO' => $carTest->CERT_NO,
                        'PLATE1' => $carTest->PLATE1,
                        'PLATE2' => $carTest->PLATE2,
                    ])
                    ->count();
                
                // ถ้ายังไม่มีกำหนดการรายงาน
                if ($existingReports == 0) {
                    // แปลงรูปแบบวันที่เป็น dd/mm/yyyy
                    $startDate = date('d/m/Y', strtotime($carTest->macTestVehCert->PMT_DATE));
                    $endDate = date('d/m/Y', strtotime($carTest->macTestVehCert->EXP_DATE));
                    
                    // คำนวณวันที่ต้องรายงาน
                    $reportDates = $calculator->calculateReportDates($startDate, $endDate);
                    
                    foreach ($reportDates['reportDates'] as $reportDate) {
                        // แปลงรูปแบบวันที่จาก dd/mm/yyyy เป็น yyyy-mm-dd
                        $reportDateObj = \DateTime::createFromFormat('d/m/Y', $reportDate);
                        $reportDateSql = $reportDateObj->format('Y-m-d');
                        
                        // คำนวณเดือนที่รายงาน (เดือนก่อนหน้าวันที่รายงาน)
                        $reportMonth = date('Y-m', strtotime('-1 month', strtotime($reportDateSql)));
                        
                        // สร้างโมเดลใหม่
                        $model = new VehTestReportSchedule();
                        $model->OFF_CODE = $carTest->OFF_CODE;
                        $model->BR_CODE = $carTest->BR_CODE;
                        $model->CAR_TEST_TYPE = $carTest->CAR_TEST_TYPE;
                        $model->CERT_YEAR = $carTest->CERT_YEAR;
                        $model->CERT_NO = $carTest->CERT_NO;
                        $model->PLATE1 = $carTest->PLATE1;
                        $model->PLATE2 = $carTest->PLATE2;
                        $model->report_date = $reportDateSql;
                        $model->report_month = $reportMonth;
                        $model->report_status = 'pending';
                        $model->created_by = Yii::$app->user->id;
                        
                        // บันทึกข้อมูล
                        if ($model->save()) {
                            $createdCount++;
                        } else {
                            // ถ้าเกิดข้อผิดพลาด ให้ยกเลิก Transaction
                            $transaction->rollBack();
                            return Json::encode([
                                'success' => false,
                                'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . Json::encode($model->errors)
                            ]);
                        }
                    }
                    
                    $vehicleCount++;
                }
            }
            
            // บันทึก Transaction
            $transaction->commit();
            
            // บันทึกประวัติการทำงาน
            Yii::$app->getModule('audit')->data('CREATE_REPORT_SCHEDULE_ALL', [
                'message' => 'สร้างกำหนดการรายงานสำหรับรถทั้งหมด ' . $vehicleCount . ' คัน',
                'data' => [
                    'vehicleCount' => $vehicleCount,
                    'reportCount' => $createdCount
                ]
            ]);
            
            return Json::encode([
                'success' => true,
                'message' => 'สร้างกำหนดการรายงานสำเร็จสำหรับรถทั้งหมด ' . $vehicleCount . ' คัน รวม ' . $createdCount . ' รายการ',
                'vehicleCount' => $vehicleCount,
                'reportCount' => $createdCount
            ]);
            
        } catch (\Exception $e) {
            if (isset($transaction)) {
                $transaction->rollBack();
            }
            
            Yii::error('เกิดข้อผิดพลาดในการสร้างกำหนดการรายงาน: ' . $e->getMessage());
            
            return Json::encode([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการสร้างกำหนดการรายงาน: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * สร้างกำหนดการรายงานเพิ่มเติมสำหรับกรณีต่ออายุใบอนุญาต
     *
     * @return string
     */
    public function actionRenewReportSchedule()
    {
        $request = Yii::$app->request;
        
        if ($request->isPost) {
            $off_code = $request->post('OFF_CODE');
            $br_code = $request->post('BR_CODE');
            $car_test_type = $request->post('CAR_TEST_TYPE');
            $cert_year = $request->post('CERT_YEAR');
            $cert_no = $request->post('CERT_NO');
            $plate1 = $request->post('PLATE1');
            $plate2 = $request->post('PLATE2');
            $new_end_date = $request->post('NEW_END_DATE');
            
            // ตรวจสอบการกรอกข้อมูล
            if (empty($off_code) || empty($br_code) || empty($car_test_type) || 
                empty($cert_year) || empty($cert_no) || empty($plate1) || 
                empty($plate2) || empty($new_end_date)) {
                return Json::encode([
                    'success' => false,
                    'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน'
                ]);
            }
            
            // ตรวจสอบว่ามีข้อมูลรถในระบบหรือไม่
            $carTest = $this->findCarTestModel($off_code, $br_code, $car_test_type, $cert_year, $cert_no, $plate1, $plate2);
            
            if (!$carTest) {
                return Json::encode([
                    'success' => false,
                    'message' => 'ไม่พบข้อมูลรถทดสอบในระบบ'
                ]);
            }
            
            try {
                // แปลงรูปแบบวันที่
                $newEndDateObj = \DateTime::createFromFormat('d/m/Y', $new_end_date);
                $oldEndDateObj = new \DateTime($carTest->END_LICENSE_DATE);
                
                if (!$newEndDateObj) {
                    return Json::encode([
                        'success' => false,
                        'message' => 'รูปแบบวันที่ไม่ถูกต้อง (ต้องเป็น dd/mm/yyyy)'
                    ]);
                }
                
                $newEndDateSql = $newEndDateObj->format('Y-m-d');
                
                // ตรวจสอบว่าวันที่สิ้นสุดใหม่ต้องมากกว่าวันที่สิ้นสุดเดิม
                if ($newEndDateObj <= $oldEndDateObj) {
                    return Json::encode([
                        'success' => false,
                        'message' => 'วันที่สิ้นสุดใบอนุญาตใหม่ต้องมากกว่าวันที่สิ้นสุดเดิม'
                    ]);
                }
                
                // เริ่ม Transaction
                $transaction = Yii::$app->db->beginTransaction();
                
                // อัพเดทวันที่สิ้นสุดใบอนุญาตในตารางข้อมูลรถทดสอบ
                $carTest->END_LICENSE_DATE = $newEndDateSql;
                $carTest->RENEW_DATE = date('Y-m-d');
                $carTest->UPDATED_BY = Yii::$app->user->id;
                
                if (!$carTest->save()) {
                    $transaction->rollBack();
                    return Json::encode([
                        'success' => false,
                        'message' => 'เกิดข้อผิดพลาดในการอัพเดทข้อมูลรถทดสอบ: ' . Json::encode($carTest->errors)
                    ]);
                }
                
                // กำหนดวันที่เริ่มต้นสำหรับสร้างรายงานใหม่ (วันถัดจากวันสิ้นสุดเดิม)
                $startDateForNewReports = date('d/m/Y', strtotime($carTest->END_LICENSE_DATE . ' +1 day'));
                
                // คำนวณวันที่ต้องรายงานสำหรับช่วงเวลาใหม่
                $calculator = new LicenseReportCalculator();
                $reportDates = $calculator->calculateReportDates($startDateForNewReports, $new_end_date);
                
                $createdCount = 0;
                
                // บันทึกข้อมูลกำหนดการรายงานเพิ่มเติม
                foreach ($reportDates['reportDates'] as $reportDate) {
                    // แปลงรูปแบบวันที่จาก dd/mm/yyyy เป็น yyyy-mm-dd
                    $reportDateObj = \DateTime::createFromFormat('d/m/Y', $reportDate);
                    $reportDateSql = $reportDateObj->format('Y-m-d');
                    
                    // คำนวณเดือนที่รายงาน (เดือนก่อนหน้าวันที่รายงาน)
                    $reportMonth = date('Y-m', strtotime('-1 month', strtotime($reportDateSql)));
                    
                    // สร้างโมเดลใหม่
                    $model = new VehTestReportSchedule();
                    $model->OFF_CODE = $off_code;
                    $model->BR_CODE = $br_code;
                    $model->CAR_TEST_TYPE = $car_test_type;
                    $model->CERT_YEAR = $cert_year;
                    $model->CERT_NO = $cert_no;
                    $model->PLATE1 = $plate1;
                    $model->PLATE2 = $plate2;
                    $model->report_date = $reportDateSql;
                    $model->report_month = $reportMonth;
                    $model->report_status = 'pending';
                    $model->created_by = Yii::$app->user->id;
                    
                    // บันทึกข้อมูล
                    if ($model->save()) {
                        $createdCount++;
                    } else {
                        // ถ้าเกิดข้อผิดพลาด ให้ยกเลิก Transaction
                        $transaction->rollBack();
                        return Json::encode([
                            'success' => false,
                            'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . Json::encode($model->errors)
                        ]);
                    }
                }
                
                // บันทึก Transaction
                $transaction->commit();
                
                // บันทึกประวัติการทำงาน
                Yii::$app->getModule('audit')->data('RENEW_REPORT_SCHEDULE', [
                    'message' => 'ต่ออายุใบอนุญาตและสร้างกำหนดการรายงานเพิ่มเติมสำหรับ ' . $cert_year . '-' . $cert_no . ' ทะเบียน ' . $plate1 . ' ' . $plate2,
                    'data' => [
                        'license' => $cert_year . '-' . $cert_no,
                        'plate' => $plate1 . ' ' . $plate2,
                        'newReports' => $createdCount,
                        'oldEndDate' => $oldEndDateObj->format('Y-m-d'),
                        'newEndDate' => $newEndDateSql
                    ]
                ]);
                
                return Json::encode([
                    'success' => true,
                    'message' => 'ต่ออายุใบอนุญาตและสร้างกำหนดการรายงานเพิ่มเติมสำเร็จ จำนวน ' . $createdCount . ' รายการ',
                    'count' => $createdCount
                ]);
                
            } catch (\Exception $e) {
                if (isset($transaction)) {
                    $transaction->rollBack();
                }
                
                Yii::error('เกิดข้อผิดพลาดในการต่ออายุและสร้างกำหนดการรายงาน: ' . $e->getMessage());
                
                return Json::encode([
                    'success' => false,
                    'message' => 'เกิดข้อผิดพลาดในการต่ออายุและสร้างกำหนดการรายงาน: ' . $e->getMessage()
                ]);
            }
        }
        
        return Json::encode([
            'success' => false,
            'message' => 'กรุณาใช้เมธอด POST'
        ]);
    }
    
    /**
     * ค้นหาโมเดลข้อมูลรถทดสอบจาก Composite Key
     * 
     * @param string $off_code
     * @param string $br_code
     * @param string $car_test_type
     * @param string $cert_year
     * @param string $cert_no
     * @param string $plate1
     * @param string $plate2
     * @return CarTestInfo|null ข้อมูลรถทดสอบที่พบ หรือ null ถ้าไม่พบ
     */
    protected function findCarTestModel($off_code, $br_code, $car_test_type, $cert_year, $cert_no, $plate1, $plate2)
    {
        return MacTestVehCertDetail::findOne([
            'OFF_CODE' => $off_code,
            'BR_CODE' => $br_code,
            'CAR_TEST_TYPE' => $car_test_type,
            'CERT_YEAR' => $cert_year,
            'CERT_NO' => $cert_no,
            'PLATE1' => $plate1,
            'PLATE2' => $plate2
        ]);
    }
}