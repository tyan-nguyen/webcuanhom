<?php
namespace app\custom;

use app\modules\template\models\TemplateVaribles;
use app\modules\website\models\WebsiteVaribles;
use app\modules\template\models\TemplateBlocks;
use app\modules\website\models\WebsiteBlocks;
use app\widgets\Editvar;
use app\widgets\Editblock;

class ThemeControl{
    const MOD_EDITED = 'edit';
    const MOD_VIEW = 'view';
    const TYPE_VAR = 'var';
    const TYPE_BLOCK = 'block';
    
    public $mod;
    
    //ShowVarible
    public function shova($type, $name){
        if($this->mod == ThemeControl::MOD_EDITED){
           return $this->showEdit($type, $name);
        } else if($this->mod == ThemeControl::MOD_VIEW){
           return $this->showView($type, $name);
        } 
    }
    
    public function showEdit($type, $name){
        if($type == ThemeControl::TYPE_VAR){
            $varible = TemplateVaribles::findOne(['name'=>$name]);
            if($varible != null){
                $wVar = WebsiteVaribles::findOne(['id_template_varible' => $varible->id]);
                if($wVar != null){
                    return Editvar::widget(['id'=>$wVar->id, 'value'=>$wVar->value]);
                }
            }
            
        }else if($type == ThemeControl::TYPE_BLOCK){
            $block = TemplateBlocks::findOne(['name'=>$name]);
            if($block != null){
                $wBlock = WebsiteBlocks::findOne(['id_template_block' => $block->id]);
                if($wBlock != null){
                    return Editblock::widget(['id'=>$wBlock->id, 'content'=>$wBlock->content]);
                }
            }
        }
    }
    
    public function showView($type, $name){
        if($type == ThemeControl::TYPE_VAR){
            $varible = TemplateVaribles::findOne(['name'=>$name]);
            if($varible != null){
                $wVar = WebsiteVaribles::findOne(['id_template_varible' => $varible->id]);
                if($wVar != null){
                    return $wVar->value;
                }
            }
        }else if($type == ThemeControl::TYPE_BLOCK){
            $block = TemplateBlocks::findOne(['name'=>$name]);
            if($block != null){
                $wBlock = WebsiteBlocks::findOne(['id_template_block'=>$block->id]);
                if($wBlock != null){
                    return $wBlock->content;
                }
            }
        }
    }
}