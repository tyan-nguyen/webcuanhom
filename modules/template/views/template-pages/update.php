<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\template\models\TemplatePages $model */

$this->title = 'Update Template Pages: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Template Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="template-pages-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
