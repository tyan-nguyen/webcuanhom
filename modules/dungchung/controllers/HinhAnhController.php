<?php

namespace app\modules\dungchung\controllers;

use app\modules\dungchung\models\HinhAnh;
use app\modules\dungchung\models\HinhAnhSearch;
use app\widgets\views\ImageGridWidget;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * HinhAnhController implements the CRUD actions for HinhAnh model.
 */
class HinhAnhController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
    		return [
    			'ghost-access'=> [
    			'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
    		],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				    'delete-outer' => ['POST'],
				],
			],
		];
	}

    /**
     * Lists all HinhAnh models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new HinhAnhSearch();
  		if(isset($_POST['search']) && $_POST['search'] != null){
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $_POST['search']);
        } else if ($searchModel->load(Yii::$app->request->post())) {
            $searchModel = new HinhAnhSearch(); // "reset"
            $dataProvider = $searchModel->search(Yii::$app->request->post());
        } else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single HinhAnh model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "HinhAnh",
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new HinhAnh model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new HinhAnh();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới HinhAnh",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mới HinhAnh",
                    'content'=>'<span class="text-success">Thêm mới thành công</span>',
                    'tcontent'=>'Thêm mới thành công!',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Thêm mới HinhAnh",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }
    
    /**
     * Creates a new HinhAnh model from other modules.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateOuter($loai, $thamchieu)
    {
        $request = Yii::$app->request;
        $model = new HinhAnh();
        
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới Hình ảnh",
                    'content'=>$this->renderAjax('create-outer', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                        Html::button('Close',['data-bs-dismiss'=>"modal"])
                    
                ];
            }else if($model->load($request->post())){
                $file = UploadedFile::getInstance($model, 'file');
                $model->loai = $loai;
                $model->id_tham_chieu = $thamchieu;
                if (!empty($file)){
                    $model->ten_file_luu = $file->name;
                    $model->img_extension = $file->extension;
                    $model->img_size = $file->size;
                    $model->duong_dan = md5(Yii::$app->user->id . date('Y-m-d H:i:s')) . '.' . $model->img_extension;
                }
                if($model->save()){
                    if (!empty($file))
                        $file->saveAs( Yii::getAlias('@webroot') . HinhAnh::FOLDER_IMAGES .  $model->duong_dan);
                    return [
                        #'forceReload'=>'#hinh-anh-pjax',
                        'forceClose'=>true,
                       /*  'title'=> "Thêm mới Hình ảnh",
                        'content'=>'<span class="text-success">Thêm mới thành công</span>',
                        'tcontent'=>'Thêm mới thành công!', */
                        'dungChungType'=>'hinhAnh',
                        'dungChungContent'=>ImageGridWidget::widget([
                            'loai' => $loai,
                            'id_tham_chieu' => $thamchieu
                        ]),
                        /* 'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal2"]).
                        Html::a('Tiếp tục thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote-2']) */
                        
                    ];
                } else {
                    return [
                        'title'=> "Thêm mới Hình ảnh",
                        'content'=>$this->renderAjax('create', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                        
                    ];
                }
            }else{
                return [
                    'title'=> "Thêm mới Hình ảnh",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                        Html::button('Close',['data-bs-dismiss'=>"modal"])
                    
                ];
            }
        }
        
    }

    /**
     * Updates an existing HinhAnh model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật HinhAnh",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    #'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "HinhAnh",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'tcontent'=>'Cập nhật thành công!',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                            Html::a('Sửa',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Cập nhật HinhAnh",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }
    
    /**
     * Updates an existing HinhAnh model from other modules.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateOuter($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        
        if($request->isAjax){
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật hình ảnh",
                    'content'=>$this->renderAjax('update-outer', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                        Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceClose'=>true,
                    #'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Hình ảnh",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'tcontent'=>'Cập nhật thành công!',
                    'dungChungType'=>'hinhAnh',
                    //'dungChungContent'=>$this->renderAjax('_imagesByID', []),
                    'dungChungContent'=>ImageGridWidget::widget([
                        'loai' => $model->loai,
                        'id_tham_chieu' => $model->id_tham_chieu
                    ]),
                   /*  'footer'=> Html::a('Edit',['update-outer','id'=>$id],['role'=>'modal-remote']) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"]) */
                ];
            }else{
                return [
                    'title'=> "Cập nhật hình ảnh",
                    'content'=>$this->renderAjax('update-outer', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                        Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];
            }
        }else{
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update-outer', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing HinhAnh model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }
    
    public function actionDeleteOuter($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $loai = $model->loai;
        $thamchieu = $model->id_tham_chieu;
        $model->delete();
        
        if($request->isAjax){
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,/* 'forceReload'=>'#crud-datatable-pjax',  */ 
                'dungChungType'=>'hinhAnh',
                'dungChungContent'=>ImageGridWidget::widget([
                    'loai' => $loai,
                    'id_tham_chieu' => $thamchieu
                ]),
            ];
        }else{
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
        
        
    }

     /**
     * Delete multiple existing HinhAnh model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        $delOk = true;
        $fList = array();
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            try{
            	$model->delete();
            }catch(\Exception $e) {
            	$delOk = false;
            	$fList[] = $model->id;
            }
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax',
            			'tcontent'=>$delOk==true?'Xóa thành công!':('Không thể xóa:'.implode('</br>', $fList)),
            ];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the HinhAnh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HinhAnh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HinhAnh::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
