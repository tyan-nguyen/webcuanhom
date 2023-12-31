<?php

namespace app\modules\kho\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "cua_xuat_xu".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten_xuat_xu
 * @property string|null $ghi_chu
 *
 * @property CuaKhoVatTu[] $cuaKhoVatTus
 */
class XuatXu extends \app\models\CuaXuatXu
{    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_xuat_xu'], 'required'],
            [['ghi_chu'], 'string'],
            [['code'], 'string', 'max' => 20],
            [['ten_xuat_xu'], 'string', 'max' => 255],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Mã xuất xứ',
            'ten_xuat_xu' => 'Tên xuất xứ',
            'ghi_chu' => 'Ghi chú',
        ];
    }
    
    /**
     * Gets query for [[CuaKhoVatTus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuaKhoVatTus()
    {
        return $this->hasMany(KhoVatTu::class, ['xuat_xu' => 'id']);
    }
    
    /**
     * lay danh sach don vi tinh de fill vao dropdownlist
     */
    public static function getList(){
        $list = XuatXu::find()->all();
        return ArrayHelper::map($list, 'id', 'ten_xuat_xu');
    }
    
    public function getShowAction(){
        if($this->id != 1){
            return Html::a($this->ten_xuat_xu,
                [Yii::getAlias('@web/kho/xuat-xu/view'), 'id'=>$this->id],
                ['role'=>'modal-remote', 'class'=>'aInGrid']
            );
        } else {
            return $this->ten_xuat_xu;
        }
    }
}
