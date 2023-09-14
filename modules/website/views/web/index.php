<?php
use yii\helpers\Html;
?>

<?= Html::a('Thêm website', ['/website/web/create']) ?>

<br/>
<hr/>
<br/>

<?php foreach ($website as $index=>$web): ?>

Web <?= $index+1 ?>: <?= Html::a($web->template->name, ['/website/web/view', 'id'=>$web->id]) ?>
<br/>

<?php endforeach;?>