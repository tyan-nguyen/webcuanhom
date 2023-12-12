<?php

namespace app\modules\maucua\controllers;

use Yii;
use app\modules\maucua\models\MauCua;
use app\modules\maucua\models\search\MauCuaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\maucua\models\DuAn;
use app\modules\maucua\models\DuAnChiTiet;
use app\modules\maucua\models\ToiUu;
use app\modules\maucua\models\MauCuaNhom;

/**
 * MauCuaController implements the CRUD actions for MauCua model.
 */
class MauCuaController extends Controller
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
     * Lists all MauCua models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new MauCuaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * get data by ajax
     */
    public function actionGetData(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'result'=> [
                [
                    'id' => 11,
                    'soluong' => [
                        [
                            'id' => 1,
                            'width' => rand(100,3000)
                        ],
                        [
                            'id' => 2,
                            'width' => rand(100,3000)
                        ]
                    ],
                    'chieudai' => 5900,
                    'vetcat' => 2,
                    'mincut' => 500
                ],
                [
                    'id' => 11,
                    'soluong' => [
                        [
                            'id' => 4,
                            'width' => rand(100,3000)
                        ],
                        [
                            'id' => 5,
                            'width' => rand(100,2000)
                        ],
                        [
                            'id' => 6,
                            'width' => rand(100,1000)
                        ]
                    ],
                    'chieudai' => 5900,
                    'vetcat' => 2,
                    'mincut' => 500
                ],
                [
                    'id' => 11,
                    'soluong' => [
                    ],
                    'chieudai' => 5900,
                    'vetcat' => 2,
                    'mincut' => 500
                ]
            ]
        ];
    }
    
    /**
     * lay du lieu theo du an
     * @param integer $id
     * @return array
     * 
     */
    public function actionGetData2($id, $type=NULL){
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $kqTest = '';
        
        //neu chua co toi uu thi tao moi
        $toiUu = ToiUu::find()->where(['id_mau_cua'=>$id]);
        $nhom = MauCuaNhom::find()->where(['id_mau_cua'=>$id]);
        
        $mauCuaModel = MauCua::findOne($id);
        
        $slToiUu = $toiUu->count();
        $slNhom = $nhom->sum('so_luong');
        if( $slToiUu == $slNhom ){
            $kqTest = 'số lượng ok';
        } else {
            $kqTest = 'Số lượng k khớp!';
            //kt nếu tối ưu > 0 thì xóa hết.
            if($slToiUu > 0){
                $mauCuaModel->deleteToiUu();
            }
            //them moi lai toan bo toi uu
            //duyet qua tung thanh nhom, neu so luong bao nhiu thi tao them bay nhieu thanh
            if($type==NULL){//toi uu tu kho
               /*  $kqToiUu = $mauCuaModel->taoToiUu();
                $kqTest .= print_r($kqToiUu); */
                $mauCuaModel->taoToiUu();
            } else if($type == 'catmoi'){
                $mauCuaModel->taoToiUuCatMoi();
            }
            
        }
        
        return [
            'kqTest' => $kqTest,
            'result'=> $mauCuaModel->dsToiUu() /* [
                [
                    'id' => 112,
                    'idMauCua' => 112,
                    'idCuaNhom' => 222,
                    'idTonKhoNhom' => 332,
                    'maCayNhom' => 'ma0001-1',
                    'tenCayNhom' => 'Cây nhôm abc -1',
                    'chieuDai' => 550,
                    'soLuong' => 1,
                    'kieuCat' => '==\\',
                    'khoiLuong' => 2000,
                    'chieuDaiCayNhom' => 5900
                ],
                [
                    'id' => 1112,
                    'idMauCua' => 1112,
                    'idCuaNhom' => 2222,
                    'idTonKhoNhom' => 3332,
                    'maCayNhom' => 'ma00011-2',
                    'tenCayNhom' => 'Cây nhôm abc2 - 2',
                    'chieuDai' => 600,
                    'soLuong' => 1,
                    'kieuCat' => '==\\',
                    'khoiLuong' => 2000,
                    'chieuDaiCayNhom' => 5900
                ],
            ] */
        ];
    }


    /**
     * Displays a single MauCua model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $back=NULL, $backid=NULL /*, $dactid=NULL*/)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            //tao back link
            $backLink = '';
            //$dactModel = null;
            if($back != null && $backid != null){
                if($back == DuAn::MODEL_ID){
                    $backLink = [Yii::getAlias('@web/maucua/du-an/view'), 'id'=>$backid];
                    //$dactModel = DuAnChiTiet::findOne($dactid);
                }
            }
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title' => "Thông tin Mẫu cửa",
                    'content' => $this->renderAjax('view', [
                        'model' => $this->findModel($id),
                        //'dactModel'=>$dactModel
                    ]),
                    'footer' =>                        
                        ($backLink != null ? Html::a('Back',
                            $backLink,
                            ['role'=>'modal-remote']) : '') . '&nbsp' .                                                
                        Html::a('Edit',['update','id'=>$id],[
                            'role'=>'modal-remote'
                        ]) . '&nbsp;' .
                        Html::button('Close',['data-bs-dismiss'=>"modal"])
                
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new MauCua model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new MauCua();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mẫu cửa",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                        Html::button('Close',['data-bs-dismiss'=>"modal"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mẫu cửa",
                    'content'=>'<span class="text-success">Thêm mới mẫu cửa thành công!</span>',
                    'footer'=> Html::a('Create More',['create'],['role'=>'modal-remote']) . '&nbsp;' .
                    Html::button('Close',['data-bs-dismiss'=>"modal"])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new MauCua",
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
     * Updates an existing MauCua model.
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
                    'title'=> "Chỉnh sửa mẫu cửa",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thông tin mẫu cửa",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::a('Edit',['update','id'=>$id],['role'=>'modal-remote']) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];    
            }else{
                 return [
                    'title'=> "Chỉnh sửa mẫu cửa",
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
     * Delete an existing MauCua model.
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
     * Delete multiple existing MauCua model.
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
     * Finds the MauCua model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MauCua the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MauCua::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
