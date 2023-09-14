<?php

use app\modules\template\models\Template;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\template\models\TemplateSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Templates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Template', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'code',
            'name',
            'summary:ntext',
            'user_created',
            //'datetime_created',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Template $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                 'template' => '{view} {update} {delete} {addPage} {addVarible} {addBlock}',  // the default buttons + your custom button
                 'buttons' => [
                    'addPage' => function($url, $model, $key) {     // render your custom button
                        return Html::a(
                            'add pages',
                            [Yii::getAlias('@web/template/template-pages/add'), 'code' => $model->code]
                        );
                    },
                    'addVarible' => function($url, $model, $key) {     // render your custom button
                        return Html::a(
                        'add varible',
                        [Yii::getAlias('@web/template/template/add-varible'), 'code' => $model->code]
                        );
                    },
                    'addBlock' => function($url, $model, $key) {     // render your custom button
                        return Html::a(
                        'add blocks',
                        [Yii::getAlias('@web/template/template/add-block'), 'code' => $model->code]
                        );
                    },
                    
                 ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
