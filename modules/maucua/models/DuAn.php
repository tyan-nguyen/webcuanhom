<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\DuAnBase;
use Yii;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use app\modules\kho\models\KhoVatTu;


class DuAn extends DuAnBase
{  
    /**
     * Gets query for [[DuAnChiTiet]].
     * chuan bi deleete vi doi mo hinh
     * @return \yii\db\ActiveQuery
     */
    public function getDuAnChiTiet()
    {
        return $this->hasMany(DuAnChiTiet::class, ['id_du_an' => 'id']);
    }
    
    /**
     * Gets query for [[MauCua]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMauCuas()
    {
        return $this->hasMany(MauCua::class, ['id_du_an' => 'id']);
    }
    
    /**
     * Gets query for [[Settings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSetting()
    {
        return DuAnSettings::findOne(['id_du_an'=>$this->id]);
    }
    
    /**
     * get tong hop vat tu
     */
    public function getVatTus(){
       /*  $sql = 'SELECT a.id_kho_vat_tu, a.so_luong, sum(a.so_luong) as sluong
                FROM cua_mau_cua_vat_tu a, cua_mau_cua b
                WHERE a.id_mau_cua = b.id AND b.id_du_an = 6
                GROUP BY a.id_kho_vat_tu;';        
        return Yii::$app->db->createCommand($sql)->queryAll(); */
        $query = MauCuaVatTu::find()->alias('t')   
        ->select(['t.*', 'mc.*', 'kvt.code as maVT', 'kvt.id as idkvt', 'kvt.ten_vat_tu', 'dvt.ten_dvt', 'hmm.ma_mau as maHeMau', 'hmm.code as codeHeMau', 'sum(t.so_luong) as sluong'])
            ->joinWith(['mauCua as mc', 'khoVatTu as kvt', 'khoVatTu.donViTinh as dvt', 'khoVatTu.heMau as hmm'])
            ->andWhere(['mc.id_du_an' => $this->id])
            ->groupBy(['id_kho_vat_tu']);
         //return $query->createCommand()->getRawSql();
         //return $query->all();
            return $query->createCommand()->queryAll();
    }
    
    /**
     * get tong hop vat tu
     */
    public function getNhomSuDungs(){
        /*  $sql = 'SELECT a.id_kho_vat_tu, a.so_luong, sum(a.so_luong) as sluong
         FROM cua_mau_cua_vat_tu a, cua_mau_cua b
         WHERE a.id_mau_cua = b.id AND b.id_du_an = 6
         GROUP BY a.id_kho_vat_tu;';
         return Yii::$app->db->createCommand($sql)->queryAll(); */
        $query = NhomSuDung::find()->alias('t')
        ->select(['t.*', 't.id_kho_nhom as idKhoNhom', 'kn.qr_code as knQrCode', 'kn.chieu_dai as kncd', 'kn.so_luong as knsl', 'cn.code as cnCode', 'cn.ten_cay_nhom as cnTenCayNhom', 'hn.code as hnCode', 'hmm.ma_mau as maHeMau', 'hmm.code as codeHeMau', 'count(t.id_kho_nhom) as sluong'])
        ->joinWith(['duAn as da', 'khoNhom as kn', 'khoNhom.cayNhom as cn', 'khoNhom.cayNhom.heNhom as hn', 'khoNhom.cayNhom.heMau as hmm'])
        ->andWhere(['t.id_du_an' => $this->id])
        ->groupBy(['id_kho_nhom']);
        //return $query->createCommand()->getRawSql();
        //return $query->all();
        return $query->createCommand()->queryAll();
    }
    /**
     * check trạng thái kho vat tu
     * true: đủ vật tư, false: có vật tư thiếu tồn kho
     */
    public function getTrangThaiVatTuOk(){
        $trangThaiVatTu = true;//ok
        foreach ($this->vatTus as $indexVT=>$vt){
            $sluongVT = round($vt['sluong'], 2);
            $vatTu = KhoVatTu::findOne($vt['idkvt']);
            //chưa tính mốc kho min
            if($vatTu->so_luong <= 0 || $vatTu->so_luong - $sluongVT < 0){
                $trangThaiVatTu = false; //not ok
                break;
            }
        }
        return $trangThaiVatTu;
    }
    /**
     * check trạng thái kho nhôm
     * true: đủ nhôm sx, false: thiếu nhôm sx
     */
    public function getTrangThaiKhoNhomOk(){
        $trangThaiKhoNhom = true;//ok
        foreach ($this->nhomSuDungs as $indexNhom=>$nhom){
            $sluongNhom = round($nhom['sluong'], 2);
            $khoNhom = KhoNhom::findOne($nhom['idKhoNhom']);
            //chưa tính mốc kho min
            if($khoNhom->so_luong <= 0 || $khoNhom->so_luong - $sluongNhom < 0){
                $trangThaiKhoNhom = false; //not ok
                break;
            }
        }
        return $trangThaiKhoNhom;
    }
    
    
    /**
     * lay danh sach tat ca du an
     * @return array
     */
    public static function getList(){
        $list = DuAn::find()->all();
        return ArrayHelper::map($list, 'id', 'ten_du_an');
    }
    /**
     * show action column for code attribute
     */
    public function getShowAction(){
        return Html::a($this->code, 
            [Yii::getAlias('@web/maucua/du-an/view'), 'id'=>$this->id],
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
     * lay ten trang thai
     * @return string
     */
    public function getTrangThai(){
        return $this->getDmTrangThaiLabel($this->trang_thai);
    }
    
    /**
     * Gets query for [[NhomSuDung]].
     * get ds nhom su dung neu du an/ke hoach duoc toi uu tat ca
     * id_mau_cua luc nay chinh la id du an
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDsNhomSuDung()
    {
        //if($this->toi_uu_tat_ca == 1){
            return $this->hasMany(NhomSuDung::class, ['id_du_an' => 'id']);
        //} else {
        //    return array();
        //}
    }
    
    /**
     * toi uu cat cho toan bo nhom toi uu cho toan du an (khac hàm taoNhomSuDung2 ben MauCua chi toi uu cho 1 cua)
     * toi uu cat tren cay nhom (cai thien thuat toan thu 2)
     * tao tinh gon tu view _test2.php
     */
    public function taoNhomSuDung(){
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
    }
    /*
     * lay ds toi uu cho toan du an (tinh luon vet cat)
     */
    public function dsToiUuCoVetCat(){
        $result = array();
        
        $dsToiUu = ToiUu::find()->alias('t')->joinWith(['mauCua as mc'])->where([
            'mc.id_du_an'=>$this->id,
        ])->all();
        
        foreach ($dsToiUu as $iNhom=>$nhom){
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
    }
    
    /**
     * xoa tat ca nhom su dung thuoc du an/ke hoach
     */
    public function deleteNhomSuDung(){
        foreach ($this->dsNhomSuDung as $mod){
            $mod->delete();
        }
    }
    
    /*
     * lay ds nhom su dung tu bang NhomSuDung theo id_du_an
     */
    public function dsSuDung(){
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
                    'mauCuaCode' => $ct->nhomToiUu->mauCua->code,
                    'mauCuaTen' => $ct->nhomToiUu->mauCua->ten_cua,
                ];
            }
            
            $result[] = [
                'id'=>$nhom->id, //id toi uu
                'macaynhom'=>$nhom->khoNhom->cayNhom->code,
                'codeHeMau'=>$nhom->khoNhom->cayNhom->heMau->code,
                'soluong'=>$soLuongArr,
                'chieudai'=>$nhom->chieu_dai_ban_dau,
                'vetcat'=> $nhom->duAn->setting['vet_cat'],
                'stt'=> ($iNhom+1),
                
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
     * lay kieu cat
     */
    public function getKieuCat($str){
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
    }
    
    /**
     * lay left
     */
    public function getKieuCatLeft($str){
        if($str == '/===\\' || $str == '/===|'){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * lay right
     */
    public function getKieuCatRight($str){
        if($str == '/===\\' || $str == '|===\\'){
            return true;
        } else {
            return false;
        }
    }
    
}