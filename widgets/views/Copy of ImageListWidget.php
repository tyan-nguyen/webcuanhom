<?php
namespace app\widgets\views;

use Yii;
use yii\base\Widget;
use app\modules\dungchung\models\HinhAnh;

class ImageListWidget1 extends Widget{
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
        
        $maHtml = '<div class="carousel-slider">';
        $maHtml .= '<div id="carousel" class="carousel slide" data-bs-ride="carousel">';
        $maHtml .= '<div class="carousel-inner">';
        
            foreach ($data as $key=>$val){
                $maHtml .= '<div class="carousel-item ' . ($key==0?'active':'') . '"><img src="' . $val->hinhAnhUrl . '" alt="img"> </div>';
            }
            
            $maHtml .= '</div>';
            $maHtml .= '<a class="carousel-control-prev" href="#carousel" role="button" data-bs-slide="prev">
    					<i class="fa fa-angle-left fs-30" aria-hidden="true"></i>
    				</a>
    				<a class="carousel-control-next" href="#carousel" role="button" data-bs-slide="next">
    					<i class="fa fa-angle-right fs-30" aria-hidden="true"></i>
    				</a>';
        $maHtml .= '</div>';
        
        
        $maHtml .= '<div class="clearfix">';
            $maHtml .= '<div id="thumbcarousel" class="carousel slide" data-bs-interval="false">';
                $maHtml .= '<div class="carousel-inner">';
                    $maHtml .= '<div class="carousel-item active text-nowrap">';
                        foreach ($data as $key=>$val){                            
                            $maHtml .= '<div data-bs-target="#carousel" data-bs-slide-to="'.$key.'" class="thumb mt-2"><img src="' . $val->hinhAnhUrl . '" alt="img" class="br-3"></div>';
                        }
                    $maHtml .= '</div>';
                $maHtml .= '</div>';
                $maHtml .= '<a class="carousel-control-prev" href="#thumbcarousel" role="button" data-bs-slide="prev">
						<i class="fa fa-angle-left fs-20" aria-hidden="true"></i>
					</a>
					<a class="carousel-control-next" href="#thumbcarousel" role="button" data-bs-slide="next">
						<i class="fa fa-angle-right fs-20" aria-hidden="true"></i>
					</a>';
                
            $maHtml .= '</div>';
        $maHtml .= '</div>';
        
        
        
        
        $maHtml .= '</div>';
        }
        return $maHtml;
    }
}
?>