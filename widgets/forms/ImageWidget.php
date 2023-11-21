<?php
namespace app\widgets\forms;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\modules\dungchung\models\HinhAnh;
use app\widgets\views\ImageGridWidget;

class ImageWidget extends Widget{
    public $loai;
    public $id_tham_chieu;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        
        $maHtml = Html::a('<i class="fas fa fa-plus" aria-hidden="true"></i> Thêm hình',
            [Yii::getAlias('@web').'/dungchung/hinh-anh/create-outer?loai='.$this->loai.'&thamchieu='.$this->id_tham_chieu],['role'=>'modal-remote-2','title'=> 'Thêm mới hình ảnh','class'=>'btn btn-outline-primary']);
        
        $maHtml .= ImageGridWidget::widget([
            'loai' => $this->loai,
            'id_tham_chieu' => $this->id_tham_chieu
        ]);
        //$maHtml .= '</div>';
        return $maHtml;
    }
}
?>  