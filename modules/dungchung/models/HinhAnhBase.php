<?php

namespace app\modules\dungchung\models;

use Yii;

class HinhAnhBase extends \app\models\CuaHinhAnh
{
    CONST FOLDER_IMAGES = '/uploads/images/';
    public $file;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loai', 'id_tham_chieu'], 'required'],
            [['id_tham_chieu', 'nguoi_tao'], 'integer'],
            [['img_size'], 'number'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['loai', 'img_wh'], 'string', 'max' => 20],
            [['ten_hien_thi', 'duong_dan', 'ten_file_luu'], 'string', 'max' => 255],
            [['img_extension'], 'string', 'max' => 10],
            [['file'], 'file'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai' => 'Loại',
            'id_tham_chieu' => 'ID Tham chiếu',
            'ten_hien_thi' => 'Tên hiển thị',
            'duong_dan' => 'Đường dẫn',
            'ten_file_luu' => 'Tên file lưu',
            'img_extension' => 'Đuôi ảnh',
            'img_size' => 'Dung lượng ảnh',
            'img_wh' => 'Kích thước ảnh',
            'ghi_chu' => 'Ghi chú',
            'thoi_gian_tao' => 'Thời gian tạo',
            'nguoi_tao' => 'Người tạo',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->thoi_gian_tao = date('Y-m-d H:i:s');
            $this->nguoi_tao = Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * {@inheritdoc}
     * xoa file anh
     */
    public function beforeDelete()
    {
        if($this->duong_dan != NULL){
            $filePath = Yii::getAlias('@webroot') . $this::FOLDER_IMAGES . $this->duong_dan;
            if(file_exists($filePath)){
                unlink($filePath);
            }
        }
        return parent::beforeDelete();
    }
}
