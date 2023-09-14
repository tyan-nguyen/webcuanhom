<?php
use yii\helpers\Html;
?> 

<?= $model->template->name ?>

<br/>

<?= $model->id ?>

<?php foreach ($model->websitePages as $index=>$page): ?>
Page <?= $index+1 ?>: <?= Html::a($page->templagePage->name, ['/website/default/detail', 'id'=>$page->id]) ?>
<?php endforeach; ?>


