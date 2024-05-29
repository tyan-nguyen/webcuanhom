<?php

namespace app\modules\dungchung\models;

use Yii;

class HistoryBase extends \app\models\History
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loai', 'id_tham_chieu', 'noi_dung'], 'required'],
            [['id_tham_chieu', 'nguoi_tao'], 'integer'],
            [['noi_dung'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['loai'], 'string', 'max' => 20],
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
            'id_tham_chieu' => 'Tham chiếu',
            'noi_dung' => 'Nội dung',
            'thoi_gian_tao' => 'Thời gian',
            'nguoi_tao' => 'Người thực hiện',
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
     * luu lich su thay doi cho model goi trong aftersave
     * use(in aftersave): History::addHistory($this::MODEL_ID, $changedAttributes, $this, $insert);
     * tham so:
     * - $type>string:truyen truc tiep hoac qua hang so Model::MODEL_ID
     * - $attr:tham so $changedAttributes cua aftersave
     * - $mod:activerecord: model thong qua findOne(hoac goi $this trong aftersave)
     * - $isNew:tham so $insert cua aftersave
     */
    public static function addHistory($type, $atr, $mod, $isNew){
        $noiDung = '';
        if($isNew == false){
            foreach ($atr as $key=>$value){
                if($atr[$key] != $mod->$key){
                    $noiDung .= '<p>Thay đổi '. $mod->getAttributeLabel($key) .' "'. $value . '" thành "'. $mod->$key . '"</p>';
                }
            }
        } else {
            $noiDung = 'Thực hiện thêm mới dữ liệu thành công.';
        }
        
        //$his->noi_dung = var_dump($changedAttributes);
        if($noiDung != null){
            $his = new History();
            $his->loai = $type;
            $his->id_tham_chieu = $mod->id;
            $his->noi_dung = $noiDung;
            $his->save();
        }
    }
    
    /**
     * luu lich su thay doi cho noi dung cu the
     * use(in aftersave): History::addManualHistory($this::MODEL_ID, $idAttribute, $content);
     * tham so:
     * - $type>string:truyen truc tiep hoac qua hang so Model::MODEL_ID
     * - $idAttribute: id cua ke hoach co su thay doi
     * - $content:noi dung cua so luong vat tu thay doi/don gia thay doi
     */
    public static function addManualHistory($type, $idAttribute, $content){
        if($content != null){
            $his = new History();
            $his->loai = $type;
            $his->id_tham_chieu = $idAttribute;
            $his->noi_dung = $content;
            $his->save();
        }
    }
}
