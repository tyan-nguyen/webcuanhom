<?php
namespace app\widgets;

use yii\base\Widget;
use kartik\editable\Editable;

class Editvar extends Widget{
    public $id;
    public $value;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        //return $this->value . '---------------edit';
        return Editable::widget([
            'name'=>'varible',
            'asPopover' => true,
            'value' => $this->value,
            'header' => 'Name',
            'size'=>'lg',
            'placement'=>'bottom bottom-left',
            'options' => ['class'=>'form-control', 'placeholder'=>'Enter person name...'],
            'formOptions' => ['action' => ['/website/default/edit-var?id=' . $this->id]],
        ]);
    }
}
?>