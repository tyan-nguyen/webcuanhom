<?php

namespace app\modules\template\controllers;

use app\modules\template\models\TemplatePages;
use app\modules\template\models\TemplatePagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\template\models\Template;
use app\custom\Message;
use yii\web\UploadedFile;

/**
 * TemplatePagesController implements the CRUD actions for TemplatePages model.
 */
class TemplatePagesController extends Controller
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
     * Lists all TemplatePages models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TemplatePagesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TemplatePages model.
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
     * Creates a new TemplatePages model by template code.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionAdd($code)
    {
        $model = new TemplatePages();
        $template = ($code != null ? Template::findOne(['code'=>$code]) : null);
        
        if($template != null):
            $model->id_template = $template->id;
            if ($this->request->isPost) {
                if ($model->load($this->request->post()) ) {
                    if($model->id_template == $template->id){
                        
                        $file = UploadedFile::getInstance($model, 'fileInput');
                        if (!empty($file)){
                            $model->file = $file->name;
                        }
                        
                        if($model->save()){
                            if (!empty($file))
                                $file->saveAs( $model->template->getTemplateRootFolder() . '/' . $model->file);
                            return $this->redirect(['view', 'id' => $model->id]);
                        } else {
                            return $this->render('create', compact('model'));
                        }
                    } else {
                        throw new NotFoundHttpException(Message::$exception['m011']);
                    }
                }
            } else {
                $model->loadDefaultValues();
            }
            
            return $this->render('create', compact('model'));
        else:
            throw new NotFoundHttpException(Message::$exception['m001']);
        endif;
    }

    /**
     * Creates a new TemplatePages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TemplatePages();

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

    /**
     * Updates an existing TemplatePages model.
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
     * Deletes an existing TemplatePages model.
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
     * Finds the TemplatePages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TemplatePages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TemplatePages::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Message::$exception['m001']);
    }
}
