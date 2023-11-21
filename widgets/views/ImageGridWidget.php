<?php
namespace app\widgets\views;

use Yii;
use yii\base\Widget;
use app\modules\dungchung\models\HinhAnh;

class ImageGridWidget extends Widget{
    public $loai;
    public $id_tham_chieu;
    
    public function init(){
        parent::init();
    }
    
    public function run(){        
        $data = HinhAnh::getHinhAnhThamChieu($this->loai, $this->id_tham_chieu);
        
        $maHtml = '<div id="imgBlock" class="container mt-2"><div class="row">';
        
        foreach ($data as $key=>$val){
            $maHtml .= '<div class="col-md-4 text-center">
                
            <a data-fancybox="gallery" href="'. $val->hinhAnhUrl . '">
                <img alt="avatar" class="radius" width="100%" src="'. $val->hinhAnhUrl . '">
            </a>
                <a class="badge rounded-pill avatar-icons bg-primary" role="modal-remote-2" data-pjax="0" href="'. Yii::getAlias('@web/dungchung/hinh-anh/update-outer?id='. $val->id) . '">
                    <i class="fa-solid fa-pen-to-square"></i> Sửa
                </a>

                <a class="badge rounded-pill avatar-icons bg-danger" 
                    role="modal-remote-2" href="'. Yii::getAlias('@web/dungchung/hinh-anh/delete-outer?id='. $val->id) . '" aria-label="Xóa" data-pjax="0" data-request-method="post" data-toggle="tooltip" data-confirm-title="Xác nhận xóa hình ảnh?" data-confirm-message="Bạn có chắc chắn thực hiện hành động này?" data-bs-placement="top" data-bs-toggle="tooltip-secondary" data-bs-original-title="Xóa hình ảnh này">
                   <i class="fa-solid fa-trash-arrow-up"></i> Xóa 
                </a>
            </div>';
        }
        
        $maHtml .= '</div></div>';
        return $maHtml;
    }
}
?>