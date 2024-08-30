<?php

namespace app\modules\maucua\controllers;

use Yii;
use app\modules\maucua\models\HeNhom;
use app\modules\maucua\models\search\HeNhomSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\maucua\models\HeNhomMau;

/**
 * HeNhomController implements the CRUD actions for HeNhom model.
 */
class HeNhomController extends Controller
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
				],
			],
		];
	}

    /**
     * Lists all HeNhom models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new HeNhomSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->pagination->pageSize=1;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single HeNhom model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Hệ nhôm",
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                'footer'=> Html::a('Edit',
                        ['update','id'=>$id],
                        ['role'=>'modal-remote']
                        ). '&nbsp;' .
                    Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new HeNhom model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new HeNhom();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới hệ nhôm",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>'submit']) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>'modal'])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                
                if($model->mauNhom != null){
                    $slMauNhom = count($model->mauNhom);
                    foreach ($model->mauNhom as $i=>$val){
                        $heNhomMau = new HeNhomMau();
                        $heNhomMau->id_he_nhom = $model->id;
                        $heNhomMau->id_he_mau = $i; //i is index and id of hemau
                        if($slMauNhom == 1)
                            $heNhomMau->is_mac_dinh = 1;
                        $heNhomMau->save();
                    }
                }
                
                
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mới hệ nhôm",
                    'content'=>'<div class="alert alert-success" role="alert">Thêm mới dữ liệu thành công!</div>'.
                        Html::a('Xem hệ nhôm vừa thêm',['view', 'id'=>$model->id],[
                            'role'=>'modal-remote',
                            'class'=>'btn btn-sm btn-primary'
                        ]),
                    
                    'footer'=> Html::a('Create More',['create'],['role'=>'modal-remote']) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
        
                ];         
            }else{           
                return [
                    'title'=> "Thêm mới hệ nhôm",
                    'content'=>$this->renderAjax('create', [
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
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing HeNhom model.
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
                    'title'=> "Cập nhật hệ nhôm",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                            Html::a('Cancel',['view','id'=>$id],['role'=>'modal-remote']) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];         
            }else if($model->load($request->post())){
                //get mang hemaunhom before update
                $oldMauList = array();
                $oldMaus = HeNhomMau::find()->where(['id_he_nhom' => $model->id])->all();
                if($oldMaus != null){
                    foreach ($oldMaus as $i=>$oldMau){
                        $oldMauList[] = $oldMau->id_he_mau;
                    }
                }
                //bien tap lai mang hemaunhom da post len
                $newMauList = array();
                if($model->mauNhom != null){
                    foreach ($model->mauNhom as $i=>$val){//lay $i la id cua he mau can lay
                        $newMauList[] = $i;
                    }
                }
                if($model->save()){
                    //xoa cac he mau bi xoa khi update
                    if($oldMauList != null) {
                        //sét lại màu mặc định
                        $model->resetMauMacDinh();
                        
                        foreach ($oldMauList as $i=>$oldMau){
                            //xóa hệ màu không có trong list mới
                            if(!in_array($oldMau, $newMauList)){
                                $heNhomMauSingle = HeNhomMau::find()
                                ->where([
                                    'id_he_nhom' => $model->id,
                                    'id_he_mau' => $oldMau
                                ])->one();
                                if($heNhomMauSingle != null)
                                    $heNhomMauSingle->delete();
                            } else{
                                if($model->mauMacDinhInput == $oldMau){
                                    $heNhomMauSingle = HeNhomMau::find()
                                    ->where([
                                        'id_he_nhom' => $model->id,
                                        'id_he_mau' => $oldMau
                                    ])->one();
                                    if($heNhomMauSingle != null){
                                        $heNhomMauSingle->is_mac_dinh = 1;
                                        $heNhomMauSingle->save();
                                    }
                                }
                           
                            }
                        }
                    }
                    
                    //luu cac henhommau moi
                    if($newMauList != null){
                        foreach ($newMauList as $i=>$newMau){
                            if($oldMauList != null){
                                if(!in_array($newMau, $oldMauList)){
                                    $heNhomMauSingle = new HeNhomMau();
                                    $heNhomMauSingle->id_he_nhom = $model->id;
                                    $heNhomMauSingle->id_he_mau = $newMau;
                                    $heNhomMauSingle->save();
                                }
                            } else{
                                $heNhomMauSingle = new HeNhomMau();
                                $heNhomMauSingle->id_he_nhom = $model->id;
                                $heNhomMauSingle->id_he_mau = $newMau;
                                $heNhomMauSingle->save();
                            }
                        }
                    }
                    
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Thông tin hệ nhôm",
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::a('Edit',['update','id'=>$id],['role'=>'modal-remote']) . '&nbsp;' .
                                Html::button('Close',['data-bs-dismiss'=>"modal"])
                    ];   
                }else{
                    return [
                        'title'=> "Cập nhật hệ nhôm",
                        'content'=>$this->renderAjax('update', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                        Html::button('Close',['data-bs-dismiss'=>"modal"])
                    ];
                }
            }else{
                 return [
                    'title'=> "Cập nhật hệ nhôm",
                    'content'=>$this->renderAjax('update', [
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
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing HeNhom model.
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

     /**
     * Delete multiple existing HeNhom model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

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

    /**
     * Finds the HeNhom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HeNhom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HeNhom::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
