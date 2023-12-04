<?php

namespace app\modules\maucua\models\base;

use Yii;
use app\custom\CustomFunc;

/**
 * @property int $id
 * @property int $id_he_nhom
 * @property string $code
 * @property string $ten_cay_nhom
 * @property int|null $so_luong
 * @property float|null $don_gia
 * @property float|null $khoi_luong
 * @property float|null $chieu_dai
 * @property int|null $for_cua_so
 * @property int|null $for_cua_di
 * @property float|null $min_allow_cut
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property MauCuaNhom[] $cuaMauCuaNhoms
 * @property HeNhom $heNhom
 */
class CayNhomBase extends \app\models\CuaCayNhom
{    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_he_nhom', 'code', 'ten_cay_nhom'], 'required'],
            [['id_he_nhom', 'so_luong', 'for_cua_so', 'for_cua_di', 'user_created'], 'integer'],
            [['don_gia', 'khoi_luong', 'chieu_dai', 'min_allow_cut'], 'number'],
            [['date_created'], 'safe'],
            [['code'], 'string', 'max' => 20],
            [['ten_cay_nhom'], 'string', 'max' => 255],
            [['id_he_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => HeNhomBase::class, 'targetAttribute' => ['id_he_nhom' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_he_nhom' => 'Id He Nhom',
            'code' => 'Code',
            'ten_cay_nhom' => 'Ten Cay Nhom',
            'so_luong' => 'So Luong',
            'don_gia' => 'Don Gia',
            'khoi_luong' => 'Khoi Luong',
            'chieu_dai' => 'Chieu Dai',
            'for_cua_so' => 'For Cua So',
            'for_cua_di' => 'For Cua Di',
            'min_allow_cut' => 'Min Allow Cut',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }
    
    public function getRandomCode(){
        $cus = new CustomFunc();
        $code = rand(1,9) . $cus->generateRandomString();
        $loaiCuaModel = CayNhomBase::findOne(['code'=>$code]);
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
            //set default trang thai
            if($this->so_luong == null){
                $this->so_luong = 0;
            }
            if($this->don_gia == null){
                $this->don_gia = 0;
            }
            if($this->khoi_luong == null){
                $this->khoi_luong = 0;
            }
            if($this->chieu_dai == null){
                $this->chieu_dai = 0;
            }
            if($this->for_cua_so == null){
                $this->for_cua_so = 0;
            }
            if($this->for_cua_di == null){
                $this->for_cua_di = 0;
            }
            if($this->min_allow_cut == null){
                $this->min_allow_cut = 0;
            }
            //set code
            if($this->code == null){
                $this->code = $this->getRandomCode();
            }
        }
        return parent::beforeSave($insert);
    }
    
}
