<?php

namespace app\modules\kho\models\base;

use Yii;
use app\custom\CustomFunc;
use app\modules\kho\models\KhoVatTuLichSu;

/**
 * @property int $id
 * @property string|null $code
 * @property string $ten_vat_tu
 * @property int|null $id_nhom_vat_tu
 * @property int|null $la_phu_kien
 * @property float|null $so_luong
 * @property int $dvt
 * @property float|null $don_gia
 * @property string|null $ghi_chu
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaKhoVatTuLichSu[] $cuaKhoVatTuLichSus
 */
class KhoVatTuBase extends \app\models\CuaKhoVatTu
{
    const MODEL_ID = 'kho-vat-tu';
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_vat_tu'], 'required'],
            [['id_nhom_vat_tu', 'la_phu_kien', 'user_created', 'dvt'], 'integer'],
            [['so_luong', 'don_gia'], 'number'],
            [['ghi_chu'], 'string'],
            [['date_created'], 'safe'],
            [['code'], 'string', 'max' => 20],
            [['ten_vat_tu'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Mã vật tư',
            'ten_vat_tu' => 'Tên vật tư',
            'id_nhom_vat_tu' => 'Nhóm vật tư',
            'la_phu_kien' => 'Là phụ kiện',
            'so_luong' => 'Số lượng',
            'dvt' => 'Đơn vị tính',
            'don_gia' => 'Đơn giá',
            'ghi_chu' => 'Ghi chú',
            'date_created' => 'Ngày tạo',
            'user_created' => 'Tài khoản',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->date_created = date('Y-m-d H:i:s');
            $this->user_created = Yii::$app->user->id;
            //set code
            if($this->code == null){
                $this->code = $this->getRandomCode();
            }
            //set nhom vat tu
            if($this->id_nhom_vat_tu == null){
                $this->id_nhom_vat_tu = 0;
            }
            //set la phu kien
            if($this->la_phu_kien == null){
                $this->la_phu_kien = 0;
            }
            //set dvt
            if($this->dvt == null){
                $this->dvt = 1;
            }
        }
        return parent::beforeSave($insert);
    }
    
    public function getRandomCode(){
        $cus = new CustomFunc();
        $code = rand(1,9) . $cus->generateRandomString();
        $khoVatTuModel = KhoVatTuBase::findOne(['code'=>$code]);
        if($khoVatTuModel == null){
            return $code;
        } else {
            $this->getRandomCode();
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->isNewRecord) {
            $lichSuTonKho = new KhoVatTuLichSu();
            $lichSuTonKho->id_kho_vat_tu = $this->id;
            $lichSuTonKho->id_nha_cung_cap = 1; //1 la chua phan loai, khong duoc xoa danh muc id 1
            $lichSuTonKho->ghi_chu = 'Số lượng nhập mới';
            $lichSuTonKho->so_luong = $this->so_luong;
            $lichSuTonKho->id_mau_cua = '1';//*********
            $lichSuTonKho->save();
        } else {
            if($this->isAttributeChanged('so_luong')){
                $lichSuTonKho = new KhoVatTuLichSu();
                $lichSuTonKho->id_kho_vat_tu = $this->id;
                $lichSuTonKho->id_nha_cung_cap = 1; //1 la chua phan loai, khong duoc xoa danh muc id 1
                $lichSuTonKho->ghi_chu = 'Sửa số lượng tồn kho - so cu:' . $this->getOldAttribute('so_luong') . ' - so moi:'. $this->so_luong;
                $lichSuTonKho->so_luong = $this->so_luong;
                $lichSuTonKho->id_mau_cua = '';//*********
                $lichSuTonKho->save();
            }
        }
        
        return parent::afterSave($insert, $changedAttributes);
    } 
    
    /**
     * Danh muc nhom vat tu
     * @return string[]
     */
    public static function getDmNhomVatTu(){
        return [
            0=>'Chưa phân loại',
            1=>'Phụ kiện',
            2=>'Vật tư',
            3=>'Thiết bị'
        ];
    }
    
    /**
     * Danh muc Loai Kho luu tru label
     * @param int $val
     * @return string
     */
    public static function getDmNhomVatTuLabel($val){
        $label = '';
        if($val == 0){
            $label = 'Chưa phân loại';
        }else if($val == 1){
            $label = 'Phụ kiện';
        }else if($val == 2){
            $label = 'Vật tư';
        }else if($val == 3){
            $label = 'Thiết bị';
        }
        return $label;
    }

}
