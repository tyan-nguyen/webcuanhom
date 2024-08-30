<?php

namespace app\modules\kho\models;

use Yii;
use yii\helpers\Html;

class VatTu extends KhoVatTu
{
    const MODEL_ID = 'vat-tu';
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Mã vật tư',
            'ten_vat_tu' => 'Tên vật tư',
            'id_nhom_vat_tu' => 'Nhóm vật tư',
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
            'id_he_mau' => 'Hệ màu'
        ];
    }
    /***** /relation *****/
    /***** custom function *****/
    /***** /custom function *****/
    /***** virtual attributes *****/
    public function getShowAction(){
        return Html::a($this->codeByColor,
            [Yii::getAlias('@web/kho/vat-tu/view'), 'id'=>$this->id],
            ['role'=>'modal-remote', 'class'=>'aInGrid']
            );
    }
}