<?php

namespace app\modules\kho\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\custom\CustomFunc;

/**
 * This is the model class for table "cua_thuong_hieu".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten_thuong_hieu
 * @property string|null $ghi_chu
 */
class ThuongHieu extends \app\models\CuaThuongHieu
{    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_thuong_hieu'], 'required'],
            [['ghi_chu'], 'string'],
            [['code'], 'string', 'max' => 20],
            [['ten_thuong_hieu'], 'string', 'max' => 255],
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
            'ten_thuong_hieu' => 'Tên thương hiệu',
            'ghi_chu' => 'Ghi chú',
        ];
    }
    
    public function getRandomCode(){
        $cus = new CustomFunc();
        $code = rand(1,9) . $cus->generateRandomString();
        $loaiCuaModel = ThuongHieu::findOne(['code'=>$code]);
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
     * Gets query for [[KhoVatTus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoVatTu()
    {
        return $this->hasMany(KhoVatTu::class, ['thuong_hieu' => 'id']);
    }
    
    /**
     * lay danh sach <thuong_hieu> de fill vao dropdownlist
     */
    public static function getList(){
        $list = ThuongHieu::find()->all();
        return ArrayHelper::map($list, 'id', 'ten_thuong_hieu');
    }
    
    public function getShowAction(){
        return Html::a($this->code,
            [Yii::getAlias('@web/kho/thuong-hieu/view'), 'id'=>$this->id],
            ['role'=>'modal-remote', 'class'=>'aInGrid']
            );
    }
}