<?php
namespace app\widgets;

use yii\bootstrap5\Modal;
use yii\bootstrap5\Html;

class CustomModal extends Modal{
    /**
     * Renders the header HTML markup of the modal
     * @return string the rendering result
     */
    protected function renderHeader(): string
    {
        $button = $this->renderCloseButton();
        if (isset($this->title)) {
            Html::addCssClass($this->titleOptions, ['widget' => 'modal-title']);
            $header = Html::tag('h5', $this->title, $this->titleOptions);
        } else {
            $header = '';
        }
        
       /*  if ($button !== null) {
            $header .= "\n" . $button;
        } elseif ($header === '') {
            return '';
        } */
        
        $header .= "<div class='header-toolbar close-button'></div>";
        
        Html::addCssClass($this->headerOptions, ['widget' => 'modal-header']);
        
        return Html::tag('div', "\n" . $header . "\n", $this->headerOptions);
    }
}