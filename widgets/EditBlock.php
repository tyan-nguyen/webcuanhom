<?php
namespace app\widgets;

use yii\base\Widget;
use kartik\editable\Editable;

class Editblock extends Widget{
    public $id;
    public $content;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        //return $this->value . '---------------edit';
        return Editable::widget([
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
            'formOptions' => ['action' => ['/website/default/edit-block?id=' . $this->id]],
            'pluginEvents' => [
                /* "editableChange"=>"function(event, val) { alert('Changed Value ' + val); }",
                "editableSubmit"=>"function(event, val, form) { alert('Submitted Value ' + val); }",
                "editableBeforeSubmit"=>"function(event, jqXHR) { alert('Before submit triggered'); }",
                "editableSubmit"=>"function(event, val, form, jqXHR) { alert('Submitted Value ' + val); }",
                "editableReset"=>"function(event) { alert('Reset editable form'); }",
                "editableSuccess"=>"function(event, val, form, data) { alert('Successful submission of value ' + val); }",
                "editableError"=>"function(event, val, form, data) { alert('Error while submission of value ' + val); }",
                "editableAjaxError"=>"function(event, jqXHR, status, message) { alert(message); }", */
                "click.target.popoverX"=>"function() { /*alert('click.target.popoverX');*/ setNote() }",
                //"load.complete.popoverX"=>"function() { alert('load.complete.popoverX'); }",
            ]
        ]);
    }
}
?>