<?php

namespace app\modules\maucua\models;

//use app\modules\maucua\models\base\DuAnBase;
use Yii;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use app\modules\maucua\models\base\CongTrinhBase;
use app\modules\banle\models\KhachHang;
use app\custom\CustomFunc;


class CongTrinh extends CongTrinhBase
{
    /**
     * đánh giá công trình
     */
    public function getDanhGia()
    {
        $kq = null;
        $kqTrue = 0;
        foreach ($this->mauCuas as $mc){
            if($mc->danhGia!=NULL && !$mc->danhGia->trangThai){
                $kq = 'failed';
                break;
            } else if($mc->danhGia!=NULL && $mc->danhGia->trangThai){
                $kqTrue++;
            }
        }
        if($kq!='failed'){
            if(count($this->mauCuas) == $kqTrue){
                $kq = 'success';
            }
        }
        return $kq;
    }
    //get Dm ke hoach load vao combo idKeHoach
    public function getDmKeHoach(){
        $list = DuAn::find()->limit(10)->orderBy(['id'=>SORT_DESC])->all();
        return ArrayHelper::map($list, 'id', 'ten_du_an');
    }
    
    /**
     * Gets query for [[DuAnChiTiet]].
     * chuan bi deleete vi doi mo hinh
     * @return \yii\db\ActiveQuery
     */
   /*  public function getDuAnChiTiet()
    {
        return $this->hasMany(DuAnChiTiet::class, ['id_du_an' => 'id']);
    } */
    
    /**
     * Gets query for [[MauCua]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMauCuas()
    {
        return $this->hasMany(MauCua::class, ['id_cong_trinh' => 'id']);
    }
    
    /**
     * Gets query for [[KhachHang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhachHang()
    {
        return $this->hasOne(KhachHang::class, ['id' => 'id_khach_hang']);
    }
    
    /**
     * Gets query for [[Settings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSetting()
    {
        return CongTrinhSettings::findOne(['id_cong_trinh'=>$this->id]);
    }
    
    /**
     * lay danh sach tat ca du an
     * @return array
     */
    public static function getList(){
        $list = CongTrinh::find()->all();
        return ArrayHelper::map($list, 'id', 'ten_cong_trinh');
    }
    /**
     * show action column for code attribute
     */
    public function getShowAction(){
        return Html::a($this->code,
            [Yii::getAlias('@web/maucua/cong-trinh/view'), 'id'=>$this->id],
            [ 'role'=>'modal-remote', 'class'=>'aInGrid' /* 'target'=>'_blank', 'data-pjax'=>0 */
            ]);
    }
    /**
     * lay ten mau thiet ke
     * @return string
     */
    public function getMauThietKe(){
        return $this->getDmThietKeLabel($this->code_mau_thiet_ke);
    }
    
    /**
     * get thong tin khach hang
     */
    public function getTenKhachHang(){
        return $this->khachHang!=null ? $this->khachHang->ten_khach_hang : '';
    }
    public function getDiaChiKhachHang(){
        return $this->khachHang!=null ? $this->khachHang->dia_chi : '';
    }
    public function getSdtKhachHang(){
        return $this->khachHang!=null ? $this->khachHang->so_dien_thoai : '';
    }
    public function getEmailKhachHang(){
        return $this->khachHang!=null ? $this->khachHang->email : '';
    }
    public function getNgayBatDau(){
        $custom = new CustomFunc();
        return $custom->convertYMDToDMY($this->ngay_bat_dau);
    }
    public function getNgayHoanThanh(){
        $custom = new CustomFunc();
        return $custom->convertYMDToDMY($this->ngay_hoan_thanh);
    }
    
    /**
     * lay ten trang thai
     * @return string
     */
    public function getTrangThai(){
        //return $this->getDmTrangThaiLabel($this->trang_thai);
    }
    
    /**
     * Gets query for [[NhomSuDung]].
     * get ds nhom su dung neu du an/ke hoach duoc toi uu tat ca
     * id_mau_cua luc nay chinh la id du an
     *
     * @return \yii\db\ActiveQuery
     */
    /* public function getDsNhomSuDung()
    {
        //if($this->toi_uu_tat_ca == 1){
        return $this->hasMany(NhomSuDung::class, ['id_du_an' => 'id']);
        //} else {
        //    return array();
        //}
    } */
    
    /**
     * toi uu cat cho toan bo nhom toi uu cho toan du an (khac hàm taoNhomSuDung2 ben MauCua chi toi uu cho 1 cua)
     * toi uu cat tren cay nhom (cai thien thuat toan thu 2)
     * tao tinh gon tu view _test2.php
     */
    /* public function taoNhomSuDung(){
        $toiUuNhomCat =  new ToiUuNhomCat();
        $newarray = array();
        //foreach($this->dsToiUu() as $key => $value){
        foreach($this->dsToiUuCoVetCat() as $key => $value){
            $newarray[$value['idTonKhoNhom']][$key] = $value;
        }
        foreach ($newarray as $vI => $v){
            $vCopy = $v;
            $numbers = array_column($v, 'chieuDai');
            $tonKhoNhom = KhoNhom::findOne($vI);
            $desiredSum = $tonKhoNhom->chieu_dai;
            $result = $toiUuNhomCat->ToiUu2($numbers, $desiredSum, null);
            
            foreach ($result as $i7=>$v7){
                $nhomsdSaveSuccess = false;
                $nhomsd = new NhomSuDung();
                $nhomsd->id_mau_cua = NULL;//id_mau_cua
                $nhomsd->id_du_an = $this->id;//new
                $nhomsd->id_kho_nhom = $tonKhoNhom->id;
                $nhomsd->chieu_dai_ban_dau = $tonKhoNhom->chieu_dai;
                $nhomsd->chieu_dai_con_lai = $tonKhoNhom->chieu_dai - array_sum($v7);
                if($nhomsd->save()){
                    $nhomsdSaveSuccess = true;
                }else {
                    var_dump($nhomsd->errors);
                }
                $i=0;
                foreach ($v7 as $v8){
                    
                    if($nhomsdSaveSuccess == true ){
                        $nhomct = new NhomSuDungChiTiet();
                        $nhomct->id_nhom_su_dung = $nhomsd->id;
                        $tKey = ToiUuNhomCat::getKey($vCopy, 'chieuDai', $v8);
                        $nhomct->id_nhom_toi_uu = $vCopy[$tKey]['id'];//khong lay $v de su dung loop
                        if($nhomct->save()){
                            //remove key
                            unset($vCopy[$tKey]);
                        } else {
                            var_dump($nhomct->errors);
                        }
                    }
                    $i++;
                }
            }
        }
    } */
    /*
     * lay ds toi uu cho toan du an (tinh luon vet cat)
     */
    /* public function dsToiUuCoVetCat(){
        $result = array();
        
        $dsToiUu = ToiUu::find()->alias('t')->joinWith(['mauCua as mc'])->where([
            'mc.id_du_an'=>$this->id,
        ])->all();
        
        foreach ($dsToiUu as $iNhom=>$nhom){

            $result[] = [
                'id'=>$nhom->id, //id toi uu
                'idMauCua'=>$nhom->id_mau_cua, //id mau cua
                'idCuaNhom'=>$nhom->id_mau_cua_nhom, // id mau cua - nhom
                'idTonKhoNhom'=>$nhom->id_ton_kho_nhom, //id ton kho nhom
                'maCayNhom'=>$nhom->mauCuaNhom->cayNhom->code, //code cua nhom (lay tu CayNhom - from MauCua-Nhom OR TonKhoNhom)
                'tenCayNhom'=>$nhom->mauCuaNhom->cayNhom->ten_cay_nhom, // ten cay nhom (lay tu CayNhom - from MauCua-Nhom OR TonKhoNhom)
                'chieuDai'=>$nhom->mauCuaNhom->chieu_dai + $nhom->mauCua->cuaSetting->vet_cat, //chieu dai cay nhom cat ra lay tu bang maucua-nhom
                'soLuong'=>1, // boc tach ra tat nhien la 1, can thiet???
                'kieuCat'=>$nhom->mauCuaNhom->kieu_cat, // lay tu MauCua-Nhom
                'khoiLuong'=>$nhom->mauCuaNhom->khoi_luong, //lay tu MauCua-Nhom
                'chieuDaiTonKhoNhom'=>$nhom->tonKhoNhom->chieu_dai,//chieu dai cay nhom trong kho (lay tu table ton_kho_nhom)
                'chieuDaiCayNhom'=>$nhom->tonKhoNhom->cayNhom->chieu_dai,//chieu dai cay nhom trong kho (lay tu table ton_kho_nhom)
                'slTonKho'=>$nhom->tonKhoNhom->so_luong
                
            ];
        }
        return $result;
    } */
    
    /**
     * xoa tat ca nhom su dung thuoc du an/ke hoach
     */
    /* public function deleteNhomSuDung(){
        foreach ($this->dsNhomSuDung as $mod){
            $mod->delete();
        }
    } */
    
    /*
     * lay ds nhom su dung tu bang NhomSuDung theo id_du_an
     */
   /*  public function dsSuDung(){
        $result = array();
        foreach ($this->dsNhomSuDung as $iNhom=>$nhom){
            
            $soLuongArr = array();
            foreach ($nhom->chiTiet as $ict=>$ct){
                $soLuongArr[] = [
                    'id'=>$ct->id,
                    'width'=>$ct->nhomToiUu->mauCuaNhom->chieu_dai,
                    'type'=>$this->getKieuCat($ct->nhomToiUu->mauCuaNhom->kieu_cat),
                    'left'=>$this->getKieuCatLeft($ct->nhomToiUu->mauCuaNhom->kieu_cat)==true?10:0,
                    'right'=>$this->getKieuCatRight($ct->nhomToiUu->mauCuaNhom->kieu_cat)==true?10:0,
                    //'vetcat'=>$ct->nhomToiUu->mauCua->setting['vet_cat']
                ];
            }
            
            $result[] = [
                'id'=>$nhom->id, //id toi uu
                'macaynhom'=>$nhom->khoNhom->cayNhom->code,
                'soluong'=>$soLuongArr,
                'chieudai'=>$nhom->chieu_dai_ban_dau,
                'vetcat'=> $nhom->duAn->setting['vet_cat']

                
            ];
        }
        return $result;
    }
     */
    /**
     * lay kieu cat
     */
    /* public function getKieuCat($str){
        if($str == '/===\\'){
            return 'both';
        } else if($str == '|===\\'){
            return 'right';
        } else if($str == '/===|'){
            return 'left';
        } else if($str == '|===|'){
            return 'none';
        } else {
            return null;
        }
    } */
    
    /**
     * lay left
     */
    /* public function getKieuCatLeft($str){
        if($str == '/===\\' || $str == '/===|'){
            return true;
        } else {
            return false;
        }
    } */
    
    /**
     * lay right
     */
   /*  public function getKieuCatRight($str){
        if($str == '/===\\' || $str == '|===\\'){
            return true;
        } else {
            return false;
        }
    } */
    
}