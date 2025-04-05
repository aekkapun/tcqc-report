<?php
/**
 * Created by PhpStorm.
 * User: BKK-60-91
 * Date: 15/3/2560
 * Time: 23:31
 */

namespace app\models;
use yii\base\Model;

class Registar extends Model
{
    public $CODE;
    public $NAME;
    public $POSITION;
    public $REGISTAR_POSITION;

    public function rules() {
        return [
            [['NAME', 'POSITION', 'REGISTAR_POSITION'], 'required'],
            [['START_DTE', 'END_DTE'], 'safe'],
        ];
    }
    private static $registar = [
        '100' => [
            'id' => '100',
            'name' => 'นางสาววรรณี  เกิดสินธ์ชัย',
            'position' => 'ผู้อำนวยการสำนักมาตรฐานงานทะเบียนและภาษีรถ  ปฏิบัติราชการแทน',
            'registar_position' => 'นายทะเบียนทั่วราชอาณาจักร',
        ],
        '101' => [
            'id' => '101',
            'name' => 'นางสุดาวรรณ สุวัตถิพงศ์',
            'position' => 'หัวหน้าส่วนควบคุมบัญชีรถและเครื่องยนต์  ปฏิบัติราชการแทน',
            'registar_position' => 'นายทะเบียนทั่วราชอาณาจักร',
        ],
        '102' => [
            'id' => '101',
            'name' => 'นางสาวเกษร  เศรษฐีสมบัติ',
            'position' => 'หัวหน้างานระบบบัญชีรถและเครื่องยนต์  ปฏิบัติราชการแทน',
            'registar_position' => 'นายทะเบียนทั่วราชอาณาจักร',
        ],
    ];

    public function attributeLabels() {
        return [

            'NAME' => 'ชื่อนายทะเบียน ',
            'POSITION' => 'ตำแหน่ง ',
            'REGISTAR_POSITION' => ' นายทะเบียน ',
        ];
    }

}