<?php
namespace app\modules\dungchung\models;

use Yii;

/**
 * This is the model class for table "cua_settings".
 *
 * @property int $id
 * @property int|null $cho_phep_nhap_kho_am
 * @property int|null $an_kho_nhom_bang_khong
 * @property float|null $vet_cat
 */

class Setting extends \app\models\CuaSettings
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cho_phep_nhap_kho_am' => 'Cho phép nhập kho phụ kiện/vật tư số âm',
            'an_kho_nhom_bang_khong' => 'Ẩn tồn kho nhôm bằng 0',
            'vet_cat' => 'Vet Cat',
        ];
    }
}