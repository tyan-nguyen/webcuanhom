<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\MauCuaBase;
use app\modules\dungchung\models\HinhAnh;
use Yii;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

class MauCua extends MauCuaBase
{
    /***** relation *****/
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
     * Gets query for [[MauCuaVach]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDsVach()
    {
        return $this->hasMany(MauCuaVach::class, ['id_mau_cua' => 'id']);
    }
    
    /**
     * Gets query for [[MauCuaVatTu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDsTatCaVatTu()
    {
        return $this->hasMany(MauCuaVatTu::class, ['id_mau_cua' => 'id']);
    }
    
    /**
     * Gets query for [[MauCuaPhuKien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDsPhuKien()
    {
        return $this->hasMany(MauCuaVatTu::class, ['id_mau_cua' => 'id'])->andOnCondition(['la_phu_kien' => 1]);
    }
    
    /**
     * Gets query for [[MauCuaVatTu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDsVatTu()
    {
        return $this->hasMany(MauCuaVatTu::class, ['id_mau_cua' => 'id'])->andOnCondition(['la_phu_kien' => 0]);
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
     * Gets query for [[NhomSuDung]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDsNhomSuDung()
    {
        return $this->hasMany(NhomSuDung::class, ['id_mau_cua' => 'id']);
    }
    /***** end relation *****/
    /***** custom function *****/
    /**
     * lay danh sach don vi tinh de fill vao dropdownlist
     */
    public static function getList(){
        $list = MauCua::find()->all();
        return ArrayHelper::map($list, 'id', 'ten_cua');
    }
    /*
     * lay ds toi uu
     */
    public function dsToiUu(){
        $result = array();
        foreach ($this->dsToiUu as $iNhom=>$nhom){
            /* $id = rand(1,5000);
             $result[] = [
             'id' => $id,
             'idMauCua' => 112,
             'idCuaNhom' => 222,
             'idTonKhoNhom' => 332,
             'maCayNhom' => 'ma0001-' . $id,
             'tenCayNhom' => 'Cây nhôm abc - x',
             'chieuDai' => 550,
             'soLuong' => 1,
             'kieuCat' => '==\\',
             'khoiLuong' => 2000,
             'chieuDaiCayNhom' => 5900
             ]; */
            
            $result[] = [
                'id'=>$nhom->id, //id toi uu
                'idMauCua'=>$nhom->id_mau_cua, //id mau cua
                'idCuaNhom'=>$nhom->id_mau_cua_nhom, // id mau cua - nhom
                'idTonKhoNhom'=>$nhom->id_ton_kho_nhom, //id ton kho nhom
                'maCayNhom'=>$nhom->mauCuaNhom->cayNhom->code, //code cua nhom (lay tu CayNhom - from MauCua-Nhom OR TonKhoNhom)
                'tenCayNhom'=>$nhom->mauCuaNhom->cayNhom->ten_cay_nhom, // ten cay nhom (lay tu CayNhom - from MauCua-Nhom OR TonKhoNhom)
                'chieuDai'=>$nhom->mauCuaNhom->chieu_dai, //chieu dai cay nhom cat ra lay tu bang maucua-nhom
                'soLuong'=>1, // boc tach ra tat nhien la 1, can thiet???
                'kieuCat'=>$nhom->mauCuaNhom->kieu_cat, // lay tu MauCua-Nhom
                'khoiLuong'=>$nhom->mauCuaNhom->khoi_luong, //lay tu MauCua-Nhom
                'chieuDaiTonKhoNhom'=>$nhom->tonKhoNhom->chieu_dai,//chieu dai cay nhom trong kho (lay tu table ton_kho_nhom)
                'chieuDaiCayNhom'=>$nhom->tonKhoNhom->cayNhom->chieu_dai,//chieu dai cay nhom trong kho (lay tu table ton_kho_nhom)
                'slTonKho'=>$nhom->tonKhoNhom->so_luong
                
            ];
        }
        return $result;
    }
    
    /*
     * lay ds toi uu
     */
    public function dsSuDung(){
        $result = array();
        foreach ($this->dsNhomSuDung as $iNhom=>$nhom){
            
            $soLuongArr = array();
            foreach ($nhom->chiTiet as $ict=>$ct){
                $soLuongArr[] = [
                    'id'=>$ct->id,
                    'width'=>$ct->nhomToiUu->mauCuaNhom->chieu_dai
                ];
            }
            
            $result[] = [
                'id'=>$nhom->id, //id toi uu
                'soluong'=>$soLuongArr,
                'chieudai'=>$nhom->chieu_dai_ban_dau
                
               /*  'idMauCua'=>$nhom->id_mau_cua, //id mau cua
                'idCuaNhom'=>$nhom->id_mau_cua_nhom, // id mau cua - nhom
                'idTonKhoNhom'=>$nhom->id_ton_kho_nhom, //id ton kho nhom
                'maCayNhom'=>$nhom->mauCuaNhom->cayNhom->code, //code cua nhom (lay tu CayNhom - from MauCua-Nhom OR TonKhoNhom)
                'tenCayNhom'=>$nhom->mauCuaNhom->cayNhom->ten_cay_nhom, // ten cay nhom (lay tu CayNhom - from MauCua-Nhom OR TonKhoNhom)
                'chieuDai'=>$nhom->mauCuaNhom->chieu_dai, //chieu dai cay nhom cat ra lay tu bang maucua-nhom
                'soLuong'=>1, // boc tach ra tat nhien la 1, can thiet???
                'kieuCat'=>$nhom->mauCuaNhom->kieu_cat, // lay tu MauCua-Nhom
                'khoiLuong'=>$nhom->mauCuaNhom->khoi_luong, //lay tu MauCua-Nhom
                'chieuDaiTonKhoNhom'=>$nhom->tonKhoNhom->chieu_dai,//chieu dai cay nhom trong kho (lay tu table ton_kho_nhom)
                'chieuDaiCayNhom'=>$nhom->tonKhoNhom->cayNhom->chieu_dai,//chieu dai cay nhom trong kho (lay tu table ton_kho_nhom)
                'slTonKho'=>$nhom->tonKhoNhom->so_luong */
                
            ];
        }
        return $result;
    }
    
    /**
     * toi uu cat tren cay nhom
     * tao tinh gon tu view _test2.php
     */
    public function taoNhomSuDung(){
        $newarray = array();
        foreach($this->dsToiUu() as $key => $value){
            $newarray[$value['idTonKhoNhom']][$key] = $value;
        }
        foreach ($newarray as $vI => $v){
            $vCopy = $v;
            $numbers = array_column($v, 'chieuDai');
            $tonKhoNhom = KhoNhom::findOne($vI);
            $desiredSum = $tonKhoNhom->chieu_dai;
            $result = $this->ToiUu($numbers, $desiredSum, null);
            
            foreach ($result as $i7=>$v7){
                $nhomsdSaveSuccess = false;
                $nhomsd = new NhomSuDung();
                $nhomsd->id_mau_cua = $this->id;
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
                        $tKey = ToiUuNhom::getKey($vCopy, 'chieuDai', $v8);
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
        
    }
    
    public function ToiUu($numbers, $desiredSum, $result){
        if($result == null){
            $result = array();
        }
        if($numbers == null){
            return $result;
        } else {
            
            $chosen = ToiUuNhom::ToiUuCatMoi($numbers, $desiredSum);
            
            //var_dump($numbers);
            $result[] = $chosen;
            foreach ($numbers as $i6=>$v6) {
                foreach ($chosen as $i5=>$v5){
                    if($v5 == $v6){
                        //check lai logic that ky
                        unset($numbers[$i6]);
                        unset($chosen[$i5]);
                        break;
                    }
                }
            }
            
            
            //var_dump($numbers);
            //return $result;
            if(empty($numbers)){
                return $result;
            } else {
                $aZero = array_values($numbers);
                // return $result;
                return $this->ToiUu($aZero, $desiredSum, $result);
            }
        }
        
        /*  if($chosen == null){
         return $result;
         } else {
         ToiUu($numbers, $desiredSum, $result);
         } */
    }
    

    /***** end custom function *****/
    /***** virtual attributes *****/
    
    /**
     * show action column for code attribute
     */
    public function getShowAction(){
        return Html::a($this->code,
            [Yii::getAlias('@web/maucua/mau-cua/view'), 'id'=>$this->id],
            ['role'=>'modal-remote', 'class'=>'aInGrid']
        );
    }
    
    public function getHinhAnh(){
        $img = HinhAnh::findOne([
            'loai' => MauCua::MODEL_ID,
            'id_tham_chieu' => $this->id
        ]);
        return $img != null ? $img->ten_file_luu : null;
    }
    
    public function getImageUrl(){
        return Yii::getAlias('@web/uploads/images/'.$this->hinhAnh);
    }
    /***** end virtual attribute *****/
}