<?php

namespace app\modules\kho\models;

use Yii;
use yii\helpers\Html;

class PhuKien extends KhoVatTu
{
    const MODEL_ID = 'phu-kien';
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Mã phụ kiện',
            'ten_vat_tu' => 'Tên phụ kiện',
            'id_nhom_vat_tu' => 'Nhóm phụ kiện',
            'thuong_hieu' => 'Thương hiệu',
            'model' => 'Model',
            'xuat_xu' => 'Xuất xứ',
            'la_phu_kien' => 'Là phụ kiện',
            'so_luong' => 'Số lượng',
            'dvt' => 'Đơn vị tính',
            'don_gia' => 'Đơn giá',
            'ghi_chu' => 'Ghi chú',
            'date_created' => 'Ngày tạo',
            'user_created' => 'Tài khoản',
        ];
    }
    /***** /relation *****/
    /***** custom function *****/
    /***** /custom function *****/
    /***** virtual attributes *****/
    public function getShowAction(){
        return Html::a($this->code,
            [Yii::getAlias('@web/kho/phu-kien/view'), 'id'=>$this->id],
            ['role'=>'modal-remote', 'class'=>'aInGrid']
            );
    }
}