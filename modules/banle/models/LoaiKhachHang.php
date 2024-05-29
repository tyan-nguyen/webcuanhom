<?php

namespace app\modules\banle\models;

use Yii;
use app\models\BanleLoaiKhachHang;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "banle_loai_khach_hang".
 *
 * @property int $id
 * @property string $ten_loai_khach_hang
 * @property string|null $ghi_chu
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property BanleKhachHang[] $banleKhachHangs
 */
class LoaiKhachHang extends BanleLoaiKhachHang
{    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_loai_khach_hang'], 'required'],
            [['ghi_chu'], 'string'],
            [['date_created'], 'safe'],
            [['user_created'], 'integer'],
            [['ten_loai_khach_hang'], 'string', 'max' => 200],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_loai_khach_hang' => 'Tên loại khách hàng',
            'ghi_chu' => 'Ghi chú',
            'date_created' => 'Thời gian tạo',
            'user_created' => 'Người tạo',
        ];
    }
    
    
    /**
     * lay danh sach khach hang de fill vao dropdownlist
     */
    public static function getList(){
        $list = LoaiKhachHang::find()->all();
        return ArrayHelper::map($list, 'id', 'ten_loai_khach_hang');
    }
    /**
     * Gets query for [[BanleKhachHangs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhachHangs()
    {
        return $this->hasMany(KhachHang::class, ['id_loai_khach_hang' => 'id']);
    }
}
