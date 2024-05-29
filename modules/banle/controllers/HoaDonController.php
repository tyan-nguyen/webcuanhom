<?php

namespace app\modules\banle\controllers;

use Yii;
use app\modules\banle\models\HoaDon;
use app\modules\banle\models\search\HoaDonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\kho\models\KhoVatTuLichSu;
use app\modules\kho\models\KhoVatTu;

/**
 * HoaDonController implements the CRUD actions for HoaDon model.
 */
class HoaDonController extends Controller
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
	 * load hoa don in
	 * @return mixed
	 */
	public function actionGetPhieuXuatKhoInAjax($idHoaDon)
	{
	    Yii::$app->response->format = Response::FORMAT_JSON;
	    $model = HoaDon::findOne($idHoaDon);
	    if($model !=null){
	        return [
	            'status'=>'success',
	            'content' => $this->renderAjax('_print_phieu', [
	                'model' => $model
	            ])
	        ];
	    } else {
	        return [
	            'status'=>'failed',
	            'content' => 'Phiếu xuất kho không tồn tại!'
	        ];
	    }
	}

    /**
     * Lists all HoaDon models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new HoaDonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single HoaDon model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Thông tin HoaDon",
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::a('Edit', ['update','id'=>$id], ['role'=>'modal-remote']). '&nbsp;' .
                    Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new HoaDon model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = new HoaDon();
            if($model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Hóa đơn",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                    Html::button('Close',['data-bs-dismiss'=>"modal"])
                ]; 
            }
        }
       
    }
    
    /**
     * xuat hoa don va khong thanh toan
     */
    public function actionXuatKhongThanhToan($id){
        $request = Yii::$app->request;
        $model = $this->findModel($id);        
        $trangThaiHienTai = $model->trang_thai;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model->trang_thai = 'CHUA_THANH_TOAN';
        if($model->save()){
            if($trangThaiHienTai == 'BAN_NHAP')
                $model->xuatHang();
            return [
                'title'=> "Cập nhật Hóa đơn",
                'content'=>$this->renderAjax('update', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                Html::button('Close',['data-bs-dismiss'=>"modal"])
            ];
        }
        

    }
    
    /**
     * xuat hoa don va thanh toan
     */
    public function actionXuatVaThanhToan($id){
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $trangThaiHienTai = $model->trang_thai;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model->trang_thai = 'DA_THANH_TOAN';
        $model->so_vao_so = $model->getSoHoaDonCuoi($model->nam) + 1;
        if($model->save()){
            $model->refresh();
            if($trangThaiHienTai == 'BAN_NHAP'){
               $model->xuatHang();
            }
            
            return [
                'title'=> "Cập nhật Hóa đơn",
                'content'=>$this->renderAjax('update', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                Html::button('Close',['data-bs-dismiss'=>"modal"])
            ];
        } 
        
        
    }

    /**
     * Updates an existing HoaDon model.
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
                    'title'=> "Cập nhật Hóa đơn",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                /* return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thông tin HoaDon",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::a('Edit',['update','id'=>$id],['role'=>'modal-remote']) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];   */  
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Cập nhật Hóa đơn",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                    Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];   
            }else{
                 return [
                    'title'=> "Cập nhật Hóa đơn",
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
     * Delete an existing HoaDon model.
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
     * Delete multiple existing HoaDon model.
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
     * Finds the HoaDon model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HoaDon the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HoaDon::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
