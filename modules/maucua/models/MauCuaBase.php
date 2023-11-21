<?php

namespace app\modules\maucua\models;

use Yii;
use app\custom\CustomFunc;

/**
 * @property int $id
 * @property string|null $code
 * @property string $ten_cua
 * @property string $kich_thuoc
 * @property int|null $id_he_nhom
 * @property int $id_loai_cua
 * @property int|null $id_parent
 * @property int $id_du_an
 * @property int|null $so_luong
 * @property string|null $status
 * @property string|null $date_created
 * @property int|null $user_created
 */
class MauCuaBase extends \app\models\CuaMauCua
{
    const MODEL_ID = 'mau-cua';
    
    /**
     * Danh muc trang thai du an
     * @return string[]
     */
    public static function getDmTrangThai(){
        return [
            'KHOI_TAO'=>'Khởi tạo',
            'TOI_UU'=>'Đã tối ưu',
            'DA_XUAT_KHO'=>'Đã hoàn thành',
            'DA_NHAP_KHO'=>'Đã nhập kho',
            'DA_HOAN_THANH'=>'Đã hoàn thành'
        ];
    }
    
    /**
     * Danh muc Loai Kho luu tru label
     * @param int $val
     * @return string
     */
    public static function getDmTrangThaiLabel($val){
        $label = '';
        if($val == 'KHOI_TAO'){
            $label = 'Khởi tạo';
        }else if($val == 'TOI_UU'){
            $label = 'Đã tối ưu';
        }else if($val == 'DA_XUAT_KHO'){
            $label = 'Đã xuất kho';
        }else if($val == 'DA_NHAP_KHO'){
            $label = 'Đã nhập kho';
        }else if($val == 'DA_HOAN_THANH'){
            $label = 'Đã hoàn thành';
        }
        return $label;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_cua', 'kich_thuoc', 'id_loai_cua', 'id_du_an'], 'required'],
            [['id_he_nhom', 'id_loai_cua', 'id_parent', 'id_du_an', 'so_luong', 'user_created'], 'integer'],
            [['date_created'], 'safe'],
            [['code', 'kich_thuoc', 'status'], 'string', 'max' => 20],
            [['ten_cua'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['id_he_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => HeNhom::class, 'targetAttribute' => ['id_he_nhom' => 'id']],
            [['id_loai_cua'], 'exist', 'skipOnError' => true, 'targetClass' => LoaiCua::class, 'targetAttribute' => ['id_loai_cua' => 'id']],
            [['id_du_an'], 'exist', 'skipOnError' => true, 'targetClass' => DuAn::class, 'targetAttribute' => ['id_du_an' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Mã mẫu cửa',
            'ten_cua' => 'Tên mẫu cửa',
            'kich_thuoc' => 'Kích thước',
            'id_he_nhom' => 'Hệ nhôm',
            'id_loai_cua' => 'Loại cửa',
            'id_parent' => 'Mẫu kế thừa',
            'id_du_an' => 'Thuộc dự án',
            'so_luong' => 'Số lượng',
            'status' => 'Trạng thái',
            'date_created' => 'Ngày tạo dữ liệu',
            'user_created' => 'Người tạo dữ liệu',
        ];
    }
    
    public function getRandomCode(){
        $cus = new CustomFunc();
        $code = rand(1,9) . $cus->generateRandomString();
        $loaiCuaModel = MauCuaBase::findOne(['code'=>$code]);
        if($loaiCuaModel == null){
            return $code;
        } else {
            $this->getRandomCode();
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->date_created = date('Y-m-d H:i:s');
            $this->user_created = Yii::$app->user->id;
            //set default parent
            if($this->id_parent == null){
                $this->id_parent = 0;
            }
            //set default status
            if($this->status == null){
                $this->status = 'KHOI_TAO';
            }
            //set code
            if($this->code == null){
                $this->code = $this->getRandomCode();
            }
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * Gets query for [[DuAn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDuAn()
    {
        return $this->hasOne(DuAn::class, ['id' => 'id_du_an']);
    }
    
    /**
     * Gets query for [[MauCuaNhoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDsNhoms()
    {
        return $this->hasMany(MauCuaNhom::class, ['id_mau_cua' => 'id']);
    }
    
    /**
     * Gets query for [[ToiUu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDsToiUu()
    {
        return $this->hasMany(ToiUu::class, ['id_mau_cua' => 'id']);
    }
    
    
    /**
     * xoa tat ca toi uu
     */
    public function deleteToiUu(){
        foreach ($this->dsToiUu as $mod){
            $mod->delete();
        }
    }
    
    /*
     * tao toi uu
     */
    public function taoToiUu(){
        foreach ($this->dsNhoms as $iNhom=>$nhom){
            if($nhom->so_luong <= 0){
                //continue;
            } else if($nhom->so_luong == 1){
                $toiUuModel = new ToiUu();
                $toiUuModel->id_mau_cua = $this->id;
                $toiUuModel->id_mau_cua_nhom = $nhom->id;
                $toiUuModel->id_ton_kho_nhom = 1;//**********tam
                $toiUuModel->save();
            } else {
                for($iTam=1;$iTam<=$nhom->so_luong;$iTam++){
                    $toiUuModel = new ToiUu();
                    $toiUuModel->id_mau_cua = $this->id;
                    $toiUuModel->id_mau_cua_nhom = $nhom->id;
                    $toiUuModel->id_ton_kho_nhom = 1;//*********tam
                    $toiUuModel->save();
                }
            }
        }
    }
    
    /*
     * lay ds toi uu
     */
    public function dsToiUu(){
        $result = array();
        foreach ($this->dsToiUu as $iNhom=>$nhom){
            $result[] = [
                'id' => 112,
                'idMauCua' => 112,
                'idCuaNhom' => 222,
                'idTonKhoNhom' => 332,
                'maCayNhom' => 'ma0001-1',
                'tenCayNhom' => 'Cây nhôm abc -1',
                'chieuDai' => 550,
                'soLuong' => 1,
                'kieuCat' => '==\\',
                'khoiLuong' => 2000,
                'chieuDaiCayNhom' => 5900
            ];
        }
        return $result;
    }
    
    /**
     * toi uu hoa cat moi
     * tra ve array id-cua-nhom, chieu-dai, kieu-cat, id_kho (moi so luong ra 1 dong)
     */
    public function getCatMoiTatCa(){
        $result = array();
        foreach ($this->dsNhoms as $iDs=>$ds){
            //duyet theo so luong lay theo tung cay nhom
            for($i=1;$i<=$ds->so_luong;$i++){
                $result[] = [
                    'id_cay_nhom'=>$ds->id_cay_nhom,
                    'ten_cay_nhom' => $ds->cayNhom->ten_cay_nhom,
                    'chieu_dai' => $ds->chieu_dai,
                    'so_luong' => $ds->so_luong,
                    'kieu_cat'=>$ds->kieu_cat
                ];
            }
            
            
        }
        
        
        
        return $result;
        
        /*  return array(
            1 => [
                'id-cua-nhom' => 1,
                'id-cay-nhom'=>123,
                'chieu-dai'=>5.5,
                'kieu-cat'=>'//===\\',
                'id_kho'=>'',
                'group'=>'g1'
                
            ],
            2 => [
                'id-cua-nhom' => 2,
                'id-cay-nhom'=>123,
                'chieu-dai'=>5.9,
                'kieu-cat'=>'/|===\\',
                'id_kho'=>'',
                'group'=>'g2'
                
            ],
            2 => [
                'id-cua-nhom' => 2,
                'id-cay-nhom'=>123,
                'chieu-dai'=>5.9,
                'kieu-cat'=>'/|===\\',
                'id_kho'=>'',
                'group'=>'g1'
                
            ]
        ); */
        
    }
    
}