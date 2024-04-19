<?php
use app\modules\maucua\models\MauCuaSettings;
?>
<ul>
<?php 
$settingModel = new MauCuaSettings();
foreach ($setting as $iSetting=>$st){
   echo '<li>' . $settingModel->getAttributeLabel($iSetting) . ': ' . $st . ' (mm)' . '</li>';
}
?>
</ul>