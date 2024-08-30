<?php
namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class BtnBackWidget extends Widget{
    public $linkList;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
       $maHtml = '';
       if($this->linkList != null){
            $maHtml .= '<div class="btn-group" role="group">
            <button type="button" class="btn btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-ellipsis-vertical"></i>
            </button>
            <ul class="dropdown-menu">';
           foreach ($this->linkList as $index=>$link){
               $maHtml .= ('<li>' . Html::a( $link['icon'] . '&nbsp;' . $link['text'], $link['url'],[
                   'class'=>'dropdown-item',
                   'role'=>'modal-remote'
               ]) . '</li>');
           }
           $maHtml .= '</ul></div>';
       } else {
           $maHtml .= 'Chưa cấu hình link';
       }
       return $maHtml;
    }
}
?>