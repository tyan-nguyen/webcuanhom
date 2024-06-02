<?php

namespace app\modules\maucua\models\base;

use Yii;
use app\custom\CustomFunc;
use app\modules\maucua\models\ToiUu;
use app\modules\maucua\models\KhoNhom;
use app\modules\maucua\models\CayNhom;
use app\modules\maucua\models\MauCuaSettings;
use app\modules\dungchung\models\Setting;
use app\modules\maucua\models\NhomSuDung;

/**
 * @property int $id
 * @property string|null $code
 * @property string $ten_cua
 * @property string $kich_thuoc
 * @property float|null $ngang
 * @property float|null $cao
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
    
    public $nhomDu;//su dung trong form nhap nhom du
    
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
            [['ngang', 'cao'], 'number'],
            [['id_he_nhom', 'id_loai_cua', 'id_parent', 'id_du_an', 'so_luong', 'user_created'], 'integer'],
            [['date_created', 'nhomDu'], 'safe'],
            [['code', 'kich_thuoc', 'status'], 'string', 'max' => 20],
            [['ten_cua'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['id_he_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => HeNhomBase::class, 'targetAttribute' => ['id_he_nhom' => 'id']],
            [['id_loai_cua'], 'exist', 'skipOnError' => true, 'targetClass' => LoaiCuaBase::class, 'targetAttribute' => ['id_loai_cua' => 'id']],
            [['id_du_an'], 'exist', 'skipOnError' => true, 'targetClass' => DuAnBase::class, 'targetAttribute' => ['id_du_an' => 'id']],
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
            'ngang' => 'Ngang',
            'cao' => 'Cao',
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
     * {@inheritdoc}
     */
    public function afterSave( $insert, $changedAttributes ){
        parent::afterSave($insert, $changedAttributes);
        //create mau cua - setting
        $globalSetting = Setting::find()->one();
        $setModel = new MauCuaSettings();
        $setModel->id_mau_cua = $this->id;
        $setModel->vet_cat = $globalSetting->vet_cat != null ? $globalSetting->vet_cat : 0;
        $setModel->save();
    }
    
    /**
     * xoa tat ca toi uu
     */
    public function deleteToiUu(){
        foreach ($this->dsToiUu as $mod){
            $mod->delete();
        }
    }
    
    /**
     * xoa tat ca nhom su dung
     */
    public function deleteNhomSuDung(){
        foreach ($this->dsNhomSuDung as $mod){
            $mod->delete();
        }
    }
    
    /*
     * tao toi uu
     */
    public function taoToiUu(){
        $kq = array();
        foreach ($this->dsNhoms as $iNhom=>$nhom){
            if($nhom->so_luong <= 0){
                //continue;
            } else if($nhom->so_luong == 1){
                $toiUuModel = new ToiUu();
                $toiUuModel->id_mau_cua = $this->id;
                $toiUuModel->id_mau_cua_nhom = $nhom->id;
                //$toiUuModel->id_ton_kho_nhom = 1;//**********tam
                //
                $toiUuModel->id_ton_kho_nhom = $this->getKhoNhomTheoChieuDai($nhom->id_cay_nhom, $nhom->chieu_dai, $this->id);
                if($toiUuModel->save()){
                    
                } else {
                    $kq[] = $toiUuModel->errors;
                }
            } else {
                for($iTam=1;$iTam<=$nhom->so_luong;$iTam++){
                    $toiUuModel = new ToiUu();
                    $toiUuModel->id_mau_cua = $this->id;
                    $toiUuModel->id_mau_cua_nhom = $nhom->id;
                    //$toiUuModel->id_ton_kho_nhom = 1;//*********tam
                    //
                    $toiUuModel->id_ton_kho_nhom = $this->getKhoNhomTheoChieuDai($nhom->id_cay_nhom, $nhom->chieu_dai, $this->id);
                    if($toiUuModel->save()){
                        
                    } else {
                        $kq[] = $toiUuModel->errors;
                    }
                }
            }
        }
        return $kq;
    }
    
    /*
     * tao toi uu cat moi
     */
    public function taoToiUuCatMoi(){
        foreach ($this->dsNhoms as $iNhom=>$nhom){
            if($nhom->so_luong <= 0){
                //continue;
            } else if($nhom->so_luong == 1){
                $toiUuModel = new ToiUu();
                $toiUuModel->id_mau_cua = $this->id;
                $toiUuModel->id_mau_cua_nhom = $nhom->id;
                $toiUuModel->id_ton_kho_nhom = $this->getKhoNhomCayNhomMoi($nhom->id_cay_nhom);
                $toiUuModel->save();
            } else {
                for($iTam=1;$iTam<=$nhom->so_luong;$iTam++){
                    $toiUuModel = new ToiUu();
                    $toiUuModel->id_mau_cua = $this->id;
                    $toiUuModel->id_mau_cua_nhom = $nhom->id;
                    $toiUuModel->id_ton_kho_nhom = $this->getKhoNhomCayNhomMoi($nhom->id_cay_nhom);
                    $toiUuModel->save();
                }
            }
        }
    }
    
    /**
     * ham lay thanh nhom trong kho theo chieu dai
     */
    /*public function getKhoNhomTheoChieuDai($idCayNhom, $chieuDai){
       
        //neu thanh nhom cat co trong kho thi lay (dieu kien so luong phai du de lay
        //neu khong co thanh nhom cat thi lay cay nhom dai (khong can kiem tra kho có hay khong)
        $cayNhom = CayNhom::findOne($idCayNhom);
        if($cayNhom != null){
            $thanhNhom = KhoNhom::find()->where([
                'id_cay_nhom'=>$idCayNhom,
            ])->andWhere('so_luong>0')
            ->andWhere('chieu_dai>='.($chieuDai+$cayNhom->min_allow_cut))
            ->orderBy('chieu_dai ASC')->one();
            
            if($thanhNhom != null){
                return $thanhNhom->id;
            } else {               
                $thanhNhom = KhoNhom::find()->where([
                    'id_cay_nhom' => $idCayNhom,
                    'chieu_dai'=>$cayNhom->chieu_dai
                ])->one();
                if($thanhNhom != null){
                    return $thanhNhom->id;
                } else {
                    //xu ly ney thanh nhom khong ton tai trong kho
                }                
            }
        } else {
            //xu ly loi neu cay nhom khong ton tai
        }
    }*/
    public function getKhoNhomTheoChieuDai($idCayNhom, $chieuDai, $idMauCua=NULL){
        
        //neu thanh nhom cat co trong kho thi lay (dieu kien so luong phai du de lay
        //neu khong co thanh nhom cat thi lay cay nhom dai (khong can kiem tra kho có hay khong)
        $cayNhom = CayNhom::findOne($idCayNhom);
        if($cayNhom != null){
            
            //kiem tra ton kho cay nhom co con hay khong
            //so luong phai tru hao so luong dang bi ngam trong cac mau cua khac
            $thanhNhom = KhoNhom::find()->where([
                'id_cay_nhom'=>$idCayNhom,
            ])->andWhere('so_luong>0')
            ->andWhere('chieu_dai>='.($chieuDai+$cayNhom->min_allow_cut))
            ->orderBy('chieu_dai ASC')->one();
            
            if($thanhNhom != null){
                $soLuongDangNgam = NhomSuDung::find()->alias('t')->joinWith(['mauCua as mc'])->where([
                    't.id_kho_nhom' => $thanhNhom->id,
                ])->andWhere("mc.status IN ('KHOI_TAO', 'TOI_UU')")->count();
                
                $soLuongDangToiUu = 0;
                if($idMauCua != NULL){
                    $soLuongDangToiUu = ToiUu::find()->where([
                        'id_mau_cua' => $idMauCua,
                        'id_ton_kho_nhom' => $thanhNhom->id,
                    ])->count();
                }
                if($thanhNhom->so_luong - $soLuongDangNgam - $soLuongDangToiUu > 0){
                    return $thanhNhom->id;
                } else {
                    //lay lai thanh nhom ton kho phu hop dieu kien va > 0
                    return $this->getTonKhoNhomHopLe($cayNhom, $chieuDai, $idMauCua, [$thanhNhom->id]);
                }
            } else {
                $thanhNhom = KhoNhom::find()->where([
                    'id_cay_nhom' => $idCayNhom,
                    'chieu_dai'=>$cayNhom->chieu_dai
                ])->one();
                if($thanhNhom != null){
                    return $thanhNhom->id;
                } else {
                    //xu ly ney thanh nhom khong ton tai trong kho
                }
            }
        } else {
            //xu ly loi neu cay nhom khong ton tai
        }
    }
    //de quy delay cay nhom hop le
    public function getTonKhoNhomHopLe($cayNhom, $chieuDai, $idMauCua, $arrayLoaiTru){
        $thanhNhom = KhoNhom::find()->where([
            'id_cay_nhom'=>$cayNhom->id,
        ])->andWhere('so_luong>0')
        ->andWhere('chieu_dai>='.($chieuDai+$cayNhom->min_allow_cut))
        ->andWhere('id NOT IN (' . implode(',', $arrayLoaiTru) . ')')
        ->orderBy('chieu_dai ASC')->one();
        if($thanhNhom != null){
            $soLuongDangNgam = NhomSuDung::find()->alias('t')->joinWith(['mauCua as mc'])->where([
                't.id_kho_nhom' => $thanhNhom->id,
            ])->andWhere("mc.status IN ('KHOI_TAO', 'TOI_UU')")->count();
            
            $soLuongDangToiUu = 0;
            if($idMauCua != NULL){
                $soLuongDangToiUu = ToiUu::find()->where([
                    'id_mau_cua' => $idMauCua,
                    'id_ton_kho_nhom' => $thanhNhom->id,
                ])->count();
            }
            if($thanhNhom->so_luong - $soLuongDangNgam - $soLuongDangToiUu > 0){
                return $thanhNhom->id;
            } else {
                //lay lai thanh nhom ton kho phu hop dieu kien va > 0
                array_push($arrayLoaiTru, $thanhNhom->id);
                return $this->getTonKhoNhomHopLe($cayNhom, $chieuDai, $idMauCua, $arrayLoaiTru);
            }
        } else {
            $thanhNhom = KhoNhom::find()->where([
                'id_cay_nhom' => $cayNhom->id,
                'chieu_dai'=>$cayNhom->chieu_dai
            ])->one();
            if($thanhNhom != null){
                return $thanhNhom->id;
            } else {
                //xu ly ney thanh nhom khong ton tai trong kho
            }
        }
        
    }
    
    /**
     * ham lay id kho nhom cua cay nhom chinh
     */
    public function getKhoNhomCayNhomMoi($idCayNhom){
        $cayNhom = CayNhom::findOne($idCayNhom);
        if($cayNhom !=null){
            $thanhNhom = KhoNhom::find()->where([
                'id_cay_nhom'=>$idCayNhom,
                'chieu_dai'=>$cayNhom->chieu_dai
            ])->one();
            if($thanhNhom!=null){
                return $thanhNhom->id;
            } else {
                //
            }
        }else{
            //
        }
    }
    
    
    /**
     * chay thuat toan toi uu nhom tong hop
     */
    public function chayToiUuNhomTongHop(){
        //duyet ds toi uu nhom gan ton kho nhom cho thanh nhom
    }
    
    /**
     * chay thuat toan toi uu tu nhom moi
     */
    public function chayToiUuNhomMoi(){
        //set toan bo ds toi uu nhom cho thanh nhom moi
    }
    
    
    
    /**
     * toi uu theo thanh nhom
     */
    public function toiUuTheoNhom(){
        /**
         * xu ly tim trong kho co thanh nhom cu nao cat duoc khong
         */
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
