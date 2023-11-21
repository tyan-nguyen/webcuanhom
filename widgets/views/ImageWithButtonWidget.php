<?php
namespace app\widgets\views;

use yii\base\Widget;

class ImageWithButtonWidget extends Widget{
    public $imageUrl;
    public $buttonType;
    public $func='';
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        $icon = 'fe fe-edit';
        if($this->buttonType == 'print'){
            $icon = 'fa fa-print';
        }
        return '
        <div class="demo-avatar-group d-flex">
           <div class="main-img-user avatar-xl m-2">
    			<img alt="avatar" class="radius" src="' . $this->imageUrl . '">
    			<a class="badge rounded-pill avatar-icons bg-primary" style="font-size:45%" onclick="'.$this->func.'" href="javascript:void(0);"><i class="'. $icon .'"></i></a>
    		</div>
        </div>
        ';
    }
}
?>