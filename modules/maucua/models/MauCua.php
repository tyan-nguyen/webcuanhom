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
                'chieuDai'=>$nhom->tonKhoNhom->chieu_dai, //chieu dai cay nhom trong kho (lay tu table ton_kho_nhom)
                'soLuong'=>1, // boc tach ra tat nhien la 1, can thiet???
                'kieuCat'=>$nhom->mauCuaNhom->kieu_cat, // lay tu MauCua-Nhom
                'khoiLuong'=>$nhom->mauCuaNhom->khoi_luong, //lay tu MauCua-Nhom
                'chieuDaiCayNhom'=>$nhom->tonKhoNhom->so_luong,
                'slTonKho'=>$nhom->tonKhoNhom->so_luong
                
            ];
        }
        return $result;
    }
    /***** end custom function *****/
    /***** virtual attributes *****/
    
    /**
     * show action column for code attribute
     */
    public function getShowAction(){
        return Html::a($this->code,
            [Yii::getAlias('@web/maucua/mau-cua/view'), 'id'=>$this->id],
            ['role'=>'modal-remote']
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