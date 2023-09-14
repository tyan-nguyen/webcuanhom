<?php

namespace app\modules\template\controllers;

use app\modules\template\models\Template;
use app\modules\template\models\TemplateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\template\models\TemplateVaribles;
use app\custom\Message;
use app\modules\template\models\TemplateBlocks;

/**
 * TemplateController implements the CRUD actions for Template model.
 */
class TemplateController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Template models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TemplateSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Template model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Template model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Template();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    public function actionAddVarible($code){
        $template = ($code != null ? Template::findOne(['code' => $code]) : null);
        if($template != null):
            $model = new TemplateVaribles();
            $model->id_template = $template->id;
            if ($this->request->isPost) {
                if ($model->load($this->request->post()) ) {
                    if($model->id_template == $template->id){                      
                        if($model->save()){
                            return $this->redirect(['index']);
                        } else {
                            return $this->render('add-varible', compact('model'));
                        }
                    } else {
                        throw new NotFoundHttpException(Message::$exception['m011']);
                    }
                }
            } else {
                $model->loadDefaultValues();
            }
            return $this->render('add-varible', compact('model'));
        else:
            throw new NotFoundHttpException(Message::$exception['m001']);
        endif;
    }
    
    public function actionAddBlock($code){
        $template = ($code != null ? Template::findOne(['code' => $code]) : null);
        if($template != null):
        $model = new TemplateBlocks();
        $model->id_template = $template->id;
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) ) {
                if($model->id_template == $template->id){
                    if($model->save()){
                        return $this->redirect(['index']);
                    } else {
                        return $this->render('add-block', compact('model'));
                    }
                } else {
                    throw new NotFoundHttpException(Message::$exception['m011']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }
        return $this->render('add-block', compact('model'));
        else:
            throw new NotFoundHttpException(Message::$exception['m001']);
        endif;
    }

    /**
     * Updates an existing Template model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Template model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Template model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Template the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Template::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
