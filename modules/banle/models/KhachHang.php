<?php
namespace app\modules\banle\models;
use Yii;
use webvimark\modules\UserManagement\models\User;
use app\modules\banle\models\base\KhachHangBase;
use yii\helpers\ArrayHelper;
/**
 * HoaDon class
 * @author annvt
 */
class KhachHang extends KhachHangBase
{
    /**
     * Gets query for [[HoaDons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHoaDons()
    {
        return $this->hasMany(HoaDon::class, ['id_khach_hang' => 'id']);
    }
    
    /**
     * Gets query for [[LoaiKhachHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaiKhachHang()
    {
        return $this->hasOne(LoaiKhachHang::class, ['id' => 'id_loai_khach_hang']);
    }
    
    /**
     * lay danh sach khach hang de fill vao dropdownlist
     */
    public static function getList(){
        $list = KhachHang::find()->all();
        return ArrayHelper::map($list, 'id', 'ten_khach_hang');
    }
}