<?php
namespace app\widgets\views;

use Yii;
use yii\base\Widget;
use app\modules\dungchung\models\HinhAnh;
use yii\helpers\Html;

class ImageListWidget extends Widget{
    public $loai;
    public $id_tham_chieu;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        $data = HinhAnh::getHinhAnhThamChieu($this->loai, $this->id_tham_chieu);
        if($data==null){
            $maHtml = 'Chưa có hình ảnh.';
        } else {
        
        $maHtml = '<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">';
        
        $maHtml .= '
        <div class="carousel-indicators">
        ';
        
        foreach ($data as $key=>$val){
            $maHtml .= '<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="'.$key.'" '. ($key==0?'class="active"': '') .' aria-current="true" aria-label="'. $val->ten_hien_thi .'"></button>';
        }
        
        $maHtml .= '
        </div>
        ';
        
        
        $maHtml .= '<div class="carousel-inner">';
        
        foreach ($data as $key=>$val){
            $maHtml .= '<div class="carousel-item '. ($key==0?'active': '') .'">';
            $maHtml .= '<a data-fancybox="gallery" data-caption="'.$val->ten_hien_thi.'" href="'. $val->hinhAnhUrl .'">';
            $maHtml .= Html::img($val->hinhAnhUrl, [
                'class' => 'd-block w-100',
                'alt' => $val->ten_hien_thi
            ]);
            $maHtml .= '</a>';
            /*$maHtml .= '<div class="carousel-caption d-none d-md-block">';
            $maHtml .= '<h5>'. $val->ten_hien_thi .'</h5>';
            $maHtml .= '<p>'. $val->ghi_chu .'</p>';
            $maHtml .= '</div>';//carousel-caption*/
            $maHtml .= '</div>';//carousel-item
        }
        
        $maHtml .= '</div>';//carousel-inner
        
        
        
        
        $maHtml .= '</div>';//end 
        
        
       
        }
        
        return $maHtml;
    }
}
?>