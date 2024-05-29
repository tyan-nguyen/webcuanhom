<?php

namespace app\modules\dungchung\models;

use Yii;

class HinhAnh extends HinhAnhBase
{
    /**
     * get hinh anh thuoc id tham chieu
     * @param string $loai
     * @param int $idthamchieu
     * @return \yii\db\ActiveRecord[]
     */
    public static function getHinhAnhThamChieu($loai, $idthamchieu){
        return HinhAnh::find()->where([
            'loai' => $loai,
            'id_tham_chieu' => $idthamchieu
        ])->orderBy('ID DESC')->all();
    }
    
    /**
     * get hinh anh thuoc id tham chieu (chi lay 1 hinh anh duy nhat)
     * @param string $loai
     * @param int $idthamchieu
     * @return \yii\db\ActiveRecord[]
     */
    public static function getHinhAnhThamChieuOne($loai, $idthamchieu){
        return HinhAnh::find()->where([
            'loai' => $loai,
            'id_tham_chieu' => $idthamchieu
        ])->orderBy('ID DESC')->one();
    }
    
    /**
     * xoa tat ca hinh anh thuoc id tham chieu(khi xoa tham chieu)
     * @param string $loai
     * @param int $idthamchieu
     */
    public static function xoaHinhAnhThamChieu($loai, $idthamchieu){
        $models = HinhAnh::getHinhAnhThamChieu($loai, $idthamchieu);
        foreach ($models as $indexMod=>$model){
            $model->delete();
        }
    }
    
    /**
     * get hinh anh url
     * @return string
     */
    public function getHinhAnhUrl(){
        return Yii::getAlias('@web') . $this::FOLDER_IMAGES . $this->duong_dan;
    }
}
