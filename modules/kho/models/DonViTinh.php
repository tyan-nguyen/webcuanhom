<?php

namespace app\modules\kho\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "cua_don_vi_tinh".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten_dvt
 * @property string|null $date_created
 * @property int|null $user_created
 */
class DonViTinh extends \app\models\CuaDonViTinh
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_dvt'], 'required'],
            [['date_created'], 'safe'],
            [['user_created'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['ten_dvt'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Mã đơn vị tính',
            'ten_dvt' => 'Tên đơn vị tính',
            'date_created' => 'Ngày tạo',
            'user_created' => 'Tài khoản',
        ];
    }
    
    /**
     * lay danh sach don vi tinh de fill vao dropdownlist
     */
    public static function getList(){
        $list = DonViTinh::find()->all();
        return ArrayHelper::map($list, 'id', 'ten_dvt');
    }
    
    public function getShowAction(){
        if($this->id != 1){
            return Html::a($this->ten_dvt,
                [Yii::getAlias('@web/kho/dvt/view'), 'id'=>$this->id],
                ['role'=>'modal-remote', 'class'=>'aInGrid']
            );
        } else {
            return $this->ten_dvt;
        }
    }
}
