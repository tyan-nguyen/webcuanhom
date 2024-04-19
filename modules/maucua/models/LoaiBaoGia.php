<?php

namespace app\modules\maucua\models;

use app\custom\CustomFunc;
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\CuaLoaiBaoGia;

class LoaiBaoGia extends CuaLoaiBaoGia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_loai_bao_gia', 'nhom_bao_gia'], 'required'],
            [['ghi_chu'], 'string'],
            [['code', 'nhom_bao_gia'], 'string', 'max' => 20],
            [['ten_loai_bao_gia'], 'string', 'max' => 255],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'ten_loai_bao_gia' => 'Tên loại báo giá',
            'nhom_bao_gia' => 'Nhóm báo giá',
            'ghi_chu' => 'Ghi chú',
        ];
    }
    
    public function getRandomCode(){
        $cus = new CustomFunc();
        $code = rand(1,9) . $cus->generateRandomString();
        $loaiCuaModel = LoaiBaoGia::findOne(['code'=>$code]);
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
            //set code
            if($this->code == null){
                $this->code = $this->getRandomCode();
            }
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * Gets query for [[CuaMauCuaVatTus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVatTu()
    {
        return $this->hasMany(MauCuaVatTu::class, ['code_bao_gia' => 'id']);
    }
    
    /**
     * nhom bao gia array
     */
    public function dsNhomBaoGia(){
        return [
            'NHOM'=>'Báo giá nhôm',
            'VATTU'=>'Báo giá vật tư',
            'VACH'=>'Báo giá vách'
        ];
    }
    
    /**
     * nhom bao gia label
     */
    public function nhomBaoGiaLabel($nhom=NULL){
        $label = '';
        switch ($nhom){
            case 'NHOM':
                $label = 'Báo giá nhôm';
                break;
            case 'VATTU':
                $label = 'Báo giá vật tư';
                break;
            case 'VACH':
                $label = 'Báo giá vách';
                break;
            default: 
                $label = null;
        }
        return $label;
    }
    
    /**
     * lay danh sach <loai_bao_gia> de fill vao dropdownlist
     * <loai_bao_gia> must in array $this->dsNhomBaoGia()
     */
    public static function getList($nhom=NULL){
        if($nhom == NULL){
            $list = LoaiBaoGia::find()->all();
        } else {
            $list= LoaiBaoGia::find()->where(['nhom_bao_gia'=>$nhom])->all();
        }
        return ArrayHelper::map($list, 'id', 'ten_loai_bao_gia');
    }
    
    public function getShowAction(){
        return Html::a($this->code,
            [Yii::getAlias('@web/maucua/loai-bao-gia/view'), 'id'=>$this->id],
            ['role'=>'modal-remote', 'class'=>'aInGrid']
            );
    }
    
    
}