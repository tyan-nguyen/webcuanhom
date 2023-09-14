<?php

namespace app\modules\website\models;

class Website extends WebsiteBase
{
    public function getVaribles(){
        $arr = array();
        foreach ($this->websiteVaribles as $varible){
            $arr[$varible->templateVarible->name] = $varible->value;
        }
        return $arr;
    }
    
    public function getBlocks(){
        $arr = array();
        foreach ($this->websiteBlocks as $block){
            $arr[$block->templateBlock->name] = $block->content;
        }
        return $arr;
    }
    
}