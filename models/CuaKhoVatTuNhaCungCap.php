<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_kho_vat_tu_nha_cung_cap".
 *
 * @property int $id
 * @property string|null $code
 * @property string $ten_nha_cung_cap
 * @property string|null $dia_chi
 * @property string|null $date_created
 * @property int|null $user_created
 */
class CuaKhoVatTuNhaCungCap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_kho_vat_tu_nha_cung_cap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_nha_cung_cap'], 'required'],
            [['dia_chi'], 'string'],
            [['date_created'], 'safe'],
            [['user_created'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['ten_nha_cung_cap'], 'string', 'max' => 255],
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
            'ten_nha_cung_cap' => 'Ten Nha Cung Cap',
            'dia_chi' => 'Dia Chi',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }
}
