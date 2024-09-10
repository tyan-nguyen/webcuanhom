<?php
namespace app\modules\users\models;

use yii\helpers\ArrayHelper;
use app\models\UserInfo;

/**
 * This is the model class for table "user_info".
 *
 * @property int $id_user
 * @property string|null $name
 * @property string|null $chuc_vu
 * @property string|null $email
 * @property int|null $nhan_thong_bao
 */

class TaiKhoanInfo extends UserInfo{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user'], 'required'],
            [['id_user', 'nhan_thong_bao'], 'integer'],
            [['name', 'chuc_vu'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 200],
            [['id_user'], 'unique'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'ID Tài khoản',
            'name' => 'Họ tên',
            'chuc_vu' => 'Chức vụ',
            'email' => 'Email',
            'nhan_thong_bao' => 'Nhận thông báo',
        ];
    }
    
    /**
     * Gets query for [[TaiKhoan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaiKhoan()
    {
        return $this->hasOne(TaiKhoan::class, ['id' => 'id_user']);
    }
    
    /**
     * return array email send email
     */
    public static function getListEmailNhanThongBao(){
        $list = TaiKhoanInfo::find()->select('email')->where(['nhan_thong_bao'=>1])->andWhere('email IS NOT NULL')->all();
        $arr = array();
        foreach ($list as $t){
            $arr[] = $t->email;
        }
        return $arr;
    }
}