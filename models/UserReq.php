<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_req".
 *
 * @property int $id
 * @property string $username
 * @property string|null $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string|null $email
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $verification_token
 * @property string|null $title
 * @property string $fname
 * @property string|null $lname
 * @property string|null $company
 * @property string|null $address
 * @property string $find_name
 * @property int $find_option
 * @property string|null $iss_off_loc_code
 */
class UserReq extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_req';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auth_key', 'password_reset_token', 'email', 'created_at', 'updated_at', 'verification_token', 'title', 'lname', 'company', 'address', 'iss_off_loc_code'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 10],
            [['find_option'], 'default', 'value' => 1],
            [['username', 'password_hash', 'fname', 'find_name'], 'required'],
            [['status', 'find_option'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 1],
            [['fname', 'lname', 'find_name'], 'string', 'max' => 120],
            [['company'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 200],
            [['iss_off_loc_code'], 'string', 'max' => 5],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
            'title' => 'Title',
            'fname' => 'Fname',
            'lname' => 'Lname',
            'company' => 'Company',
            'address' => 'Address',
            'find_name' => 'Find Name',
            'find_option' => 'Find Option',
            'iss_off_loc_code' => 'Iss Off Loc Code',
        ];
    }

}
