<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\template\models\TemplatePages $model */

$this->title = 'Create Template Pages';
$this->params['breadcrumbs'][] = ['label' => 'Template Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-pages-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
