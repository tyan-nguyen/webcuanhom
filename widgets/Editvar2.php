<?php
namespace app\widgets;

use yii\base\Widget;
use kartik\editable\Editable;

class Editvar2 extends Widget{
    public $id;
    public $value;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
       //return $this->value . '---------------edit';
       /*  return Editable::widget([
            'name'=>'varible',
            'asPopover' => true,
            'value' => $this->value,
            'header' => 'Name',
            'size'=>'lg',
            'placement'=>'bottom bottom-left',
            'options' => ['class'=>'form-control', 'placeholder'=>'Enter person name...'],
            'formOptions' => ['action' => ['/website/web/edit-var?id=' . $this->id]],
        ]); */
        
        $html = '<div class="mydivoutermulti">';
        
        $html .= $this->value;
        
        $html .= '<a href="/website/web/edit-var?id='.$this->id.'" role="modal-remote" data-pjax="1" data-modal-size="small" class="buttonoverlapmulti"><i class="fas fa-pen-square"></i></a>';
        
        
        $html.= '</div>';
        
        return $html;
    }
}
?>