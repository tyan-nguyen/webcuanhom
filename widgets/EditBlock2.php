<?php
namespace app\widgets;

use yii\base\Widget;
use kartik\editable\Editable;

class EditBlock2 extends Widget{
    public $id;
    public $content;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        //return $this->value . '---------------edit';
        /* return Editable::widget([
            'name'=>'block',
            'asPopover' => true,
            'value' => $this->content,
            'header' => 'Name',
            'size'=>'lg',
            'placement'=>'bottom bottom-left',
            'inputType' => Editable::INPUT_TEXTAREA,
            'options' => [
                'class'=>'form-control abc', 
                'rows'=>10,
                //'onload'=>"setNote()"
            ],
            'formOptions' => ['action' => ['/website/web/edit-block?id=' . $this->id]],
            'pluginEvents' => [
              
            ]
        ]); */
        
        $html = '<div class="mydivoutermulti">';
        
        $html .= $this->content;
        
        $html .= '<a href="/website/web/edit-block?id='.$this->id.'" role="modal-remote" data-pjax="1" data-modal-size="large" class="buttonoverlapmulti"><i class="fas fa-pen-square"></i></a>';
        
        
        $html.= '</div>';
        
        
        return $html;
    }
}
?>