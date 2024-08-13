<?php

namespace app\modules\maucua\controllers;

use Yii;
use app\modules\maucua\models\DuAn;
use app\modules\maucua\models\search\DuAnSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\maucua\models\ToiUu;
use app\modules\maucua\models\MauCuaNhom;
use app\modules\maucua\models\MauCua;
use app\modules\kho\models\KhoVatTu;
use app\modules\kho\models\KhoVatTuLichSu;
use app\modules\maucua\models\KhoNhom;
use app\modules\maucua\models\KhoNhomLichSu;
use app\modules\maucua\models\MauCuaVatTu;

/**
 * DuAnController implements the CRUD actions for DuAn model.
 */
class DuAnController extends Controller
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
	 * load phieu xuat kho
	 * @return mixed
	 */
	public function actionGetPhieuInAjax($idDuAn, $type)
	{
	    Yii::$app->response->format = Response::FORMAT_JSON;
	    $model = DuAn::findOne($idDuAn);
	    if($model !=null){
	        if($type == "phieuthongtin"){
	            return [
	                'status'=>'success',
	                'content' => $this->renderAjax('_print_phieu_thong_tin', [
	                    'model' => $model
	                ])
	            ];
	        } else if ($type == "phieuxuatkho"){
	            return [
	                'status'=>'success',
	                'content' => $this->renderAjax('_print_phieu_xuat_kho', [
	                    'model' => $model
	                ])
	            ];
	        }
	    } else {
	        return [
	            'status'=>'failed',
	            'content' => 'Phiếu xuất kho không tồn tại!'
	        ];
	    }
	}
	
	/**
	 * load phieu xuat kho
	 * @return mixed
	 */
	public function actionGetPhieuInAjax2($idDuAn, $type)
	{
	    Yii::$app->response->format = Response::FORMAT_JSON;
	    $model = DuAn::findOne($idDuAn);
	    if($model !=null){
	        if($type == "phieuthongtin"){
	            return [
	                'status'=>'success',
	                'content' => $this->renderAjax('_print_phieu_thong_tin', [
	                    'model' => $model
	                ])
	            ];
	        } else if ($type == "phieuxuatkho"){
	            return [
	                'status'=>'success',
	                'content' => $this->renderAjax('_print_phieu_xuat_kho_2', [
	                    'model' => $model
	                ])
	            ];
	        }
	    } else {
	        return [
	            'status'=>'failed',
	            'content' => 'Phiếu xuất kho không tồn tại!'
	        ];
	    }
	}
	
	/**
	 * tao toi uu cho tat ca bo cua trong giao dien xem du an (toi uu cho rieng tung bo cua rieng le)
	 * @param integer $idDuAn
	 * @return array
	 *
	 */
	public function actionToiUuDuAnChoTungBoCua($idDuAn, $type=NULL){
	    Yii::$app->response->format = Response::FORMAT_JSON;
	    $duAn = DuAn::findOne($idDuAn);
	    
	    $soLuongMauCuaDuocToiUu = 0;
	    $duAn->deleteNhomSuDung();//xoa nhom su dung cua du an neu da toi uu truoc do
	    
	    foreach ($duAn->mauCuas as $indexMauCua=>$mauCuaModel){
	        if($mauCuaModel->status == "KHOI_TAO" || $mauCuaModel->status == "TOI_UU"){
	            $id = $mauCuaModel->id;
	            //neu chua co toi uu thi tao moi
	            $toiUu = ToiUu::find()->where(['id_mau_cua'=>$id]);
	            $nhom = MauCuaNhom::find()->where(['id_mau_cua'=>$id]);
	            
	            // $mauCuaModel = MauCua::findOne($id);
	            
	            $slToiUu = $toiUu->count();
	            //$slNhom = $nhom->sum('so_luong');
	            // if( $slToiUu == $slNhom ){
	            //    $kqTest = 'số lượng ok';
	                // } else {
	                //    $kqTest = 'Số lượng k khớp!';
	                    //kt nếu tối ưu > 0 thì xóa hết.
	                    if($slToiUu > 0){
	                        
	                        $mauCuaModel->deleteNhomSuDung();
	                        $mauCuaModel->deleteToiUu();
	                        
	                    }
	                    //them moi lai toan bo toi uu
	                    //duyet qua tung thanh nhom, neu so luong bao nhiu thi tao them bay nhieu thanh
	                    if($type==NULL){//toi uu tu kho
	                        //$kqToiUu = $mauCuaModel->taoToiUu();
	                        //$kqTest .= print_r($kqToiUu);
	                        $mauCuaModel->taoToiUu();
	                    } else if($type == 'catmoi'){
	                        $mauCuaModel->taoToiUuCatMoi();
	                    }
	                    
	                    if($mauCuaModel->status == "KHOI_TAO"){
	                        $mauCuaModel->status = "TOI_UU";
	                        $mauCuaModel->save(false);
	                    }
	                    
	                    
	                    // }
	                    //search lai de load model moi
	                    $mauCuaModel1 = MauCua::findOne($id);
	                    
	                    /**
	                     * toi uu cat hien thi tren cay nhom
	                     */
	                    //$mauCuaModel1->taoNhomSuDung();
	                    $mauCuaModel1->taoNhomSuDung2();
	                    
	                    $soLuongMauCuaDuocToiUu++;
	                }
	        }
	        
	        //search lai de load model moi
	        $duAn = DuAn::findOne($idDuAn);	  
	        return [
	            'result' => 'Đã tối ưu ' . $soLuongMauCuaDuocToiUu . '/' . count($duAn->mauCuas) . ' mẫu cửa'
	        ];
	}
	
	/**
	 * tao toi uu cho tat ca bo cua trong giao dien xem du an (toi uu chung cho toan du an, nhom su dung se la cua du an)
	 * @param integer $idDuAn
	 * @return array
	 *
	 */
	public function actionToiUuToanDuAn($idDuAn, $type=NULL){
	    Yii::$app->response->format = Response::FORMAT_JSON;
	    $duAn = DuAn::findOne($idDuAn);
	    
	    $soLuongMauCuaDuocToiUu = 0;
	    
	    foreach ($duAn->mauCuas as $indexMauCua=>$mauCuaModel){
	        if($mauCuaModel->status == "KHOI_TAO" || $mauCuaModel->status == "TOI_UU"){
	            $id = $mauCuaModel->id;
	            //neu chua co toi uu thi tao moi
	            $toiUu = ToiUu::find()->where(['id_mau_cua'=>$id]);
	            $nhom = MauCuaNhom::find()->where(['id_mau_cua'=>$id]);
	            
	            // $mauCuaModel = MauCua::findOne($id);
	            
	            $slToiUu = $toiUu->count();
	            //$slNhom = $nhom->sum('so_luong');
	            // if( $slToiUu == $slNhom ){
	            //    $kqTest = 'số lượng ok';
	            // } else {
	            //    $kqTest = 'Số lượng k khớp!';
	                //kt nếu tối ưu > 0 thì xóa hết.
	                if($slToiUu > 0){
	                    
	                    $mauCuaModel->deleteNhomSuDung();
	                    $mauCuaModel->deleteToiUu();
	                    
	                }
	                //them moi lai toan bo toi uu
	                //duyet qua tung thanh nhom, neu so luong bao nhiu thi tao them bay nhieu thanh
	                if($type==NULL){//toi uu tu kho
	                    //$kqToiUu = $mauCuaModel->taoToiUu();
	                    //$kqTest .= print_r($kqToiUu);
	                    $mauCuaModel->taoToiUu();
	                } else if($type == 'catmoi'){
	                    $mauCuaModel->taoToiUuCatMoi();
	                }
	                
	                if($mauCuaModel->status == "KHOI_TAO"){
	                    $mauCuaModel->status = "TOI_UU";
	                    $mauCuaModel->save(false);
	                }
	                
	                $soLuongMauCuaDuocToiUu++;
	            }
	    }
	    
	    // }
	    //search lai de load model moi
	    $duAn = DuAn::findOne($idDuAn);	  
	    //xoa nhom su dung neu co ton tai
	    $duAn->deleteNhomSuDung();
	    //cap nhat trang thai du an
	    /**
	     * toi uu cat hien thi tren cay nhom
	     */
	    $duAn->taoNhomSuDung();
	    $duAn->toi_uu_tat_ca = 1;
	    if($duAn->trang_thai == 'KHOI_TAO' || $duAn->trang_thai == 'THUC_HIEN'){
	        $duAn->trang_thai = 'TOI_UU';
	    }
	    $duAn->save(false);
	    
	    $duAn->refresh();
	    
	    
	    return [
	        'result' => 'Đã tối ưu chung cho toàn dự án (' . $soLuongMauCuaDuocToiUu . '/' . count($duAn->mauCuas) . ' mẫu cửa)',
	        'nhomSuDung' => $duAn->dsSuDung(),
	    ];
	}
	
	/**
	 * xuat kho
	 * For ajax request will return json object
	 * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionXuatKho($id)
	{
	    $request = Yii::$app->request;
	    $model = $this->findModel($id);
	    
	    if($request->isAjax){
	        Yii::$app->response->format = Response::FORMAT_JSON;
	        
	        $dsTatCaVatTu = MauCuaVatTu::find()->alias('t')->joinWith(['mauCua as mc'])->where([
	            'mc.id_du_an'=>$model->id,
	        ])->all();
	        
	        //xuat kho tung cai sau do chuyen trang thai da xuat kho
	        //sauu do chinh sua trang thai du an
	        foreach ($dsTatCaVatTu as $vt){//!!!!!!!!!
	            $vatTuModel = KhoVatTu::findOne($vt->id_kho_vat_tu);
	            $vatTuModelOld = KhoVatTu::findOne($vt->id_kho_vat_tu);
	            $vatTuModel->so_luong = $vatTuModel->so_luong - $vt->so_luong;
	            if($vatTuModel->save()){
	                if($vatTuModel->so_luong != $vatTuModelOld->so_luong){
	                    $lichSuTonKho = new KhoVatTuLichSu();
	                    $lichSuTonKho->id_kho_vat_tu = $vatTuModel->id;
	                    $lichSuTonKho->id_nha_cung_cap = 1; //1 la chua phan loai, khong duoc xoa danh muc id 1
	                    $lichSuTonKho->ghi_chu = 'Xuất kho mẫu cửa #' . $model->code;
	                    $lichSuTonKho->so_luong = $vt->so_luong;
	                    $lichSuTonKho->so_luong_cu = $vatTuModelOld->so_luong;
	                    $lichSuTonKho->so_luong_moi = $vatTuModel->so_luong;
	                    $lichSuTonKho->id_mau_cua = $model->id;
	                    $lichSuTonKho->save();
	                }
	            }
	        }
	        foreach ($model->dsNhomSuDung as $nhomsd){
	            $tonKhoNhom = KhoNhom::findOne($nhomsd->id_kho_nhom);
	            $tonKhoNhomOld = KhoNhom::findOne($nhomsd->id_kho_nhom);
	            $tonKhoNhom->so_luong = $tonKhoNhom->so_luong - 1;//1 is 1 dong trong nhom sd
	            if($tonKhoNhom->save()){
	                if($tonKhoNhom->so_luong != $tonKhoNhomOld->so_luong){
	                    $history = new KhoNhomLichSu();
	                    $history->id_kho_nhom = $tonKhoNhom->id;
	                    $history->so_luong = 1;//1 is 1 dong trong nhom sd
	                    $history->so_luong_cu = $tonKhoNhomOld->so_luong;
	                    $history->so_luong_moi = $tonKhoNhom->so_luong;
	                    $history->id_mau_cua = $model->id;
	                    $history->noi_dung = 'Xuất kho mẫu cửa #'. $model->code;
	                    $history->save();
	                }
	            }
	            
	        }
	        
	        $model->trang_thai = 'DA_XUAT_KHO';
	        $model->save(false);
	        /*if($model->save()){
	            //thay doi trang thai du an
	            /* $duAn = DuAn::findOne($model->id_du_an);
	            
	            $hoanThanh=true;
	            foreach ($duAn->mauCuas as $j=>$cua){
	                if($cua->status == 'KHOI_TAO' || $cua->status == 'TOI_UU'){
	                    $hoanThanh = false;
	                }
	            }
	            if($hoanThanh==true){
	                $duAn->trang_thai = 'HOAN_THANH';
	                $duAn->save();
	            } else {
	                $duAn->trang_thai = 'THUC_HIEN';
	                $duAn->save();
	            }             
	        }*/	
	        
	        return [
	            'forceReload'=>'#crud-datatable-pjax',
	            'title'=> "Thông tin Kế hoạch",
	            'content'=>$this->renderAjax('view', [
	                'model' => $model,
	            ]),
	            'footer' => Html::button('Close',['data-bs-dismiss'=>"modal"])
	        ];
	        
	    }
	}
	

    /**
     * Lists all DuAn models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new DuAnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single DuAn model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Thông tin Kế hoạch sản xuất",
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                'footer'=> Html::a('<i class="fa-solid fa-calendar-plus"></i> Thêm cửa vào KHSX',
                                ['them-mau-cua-vao-ke-hoach','idkh'=>$id],
                                [
                                    'role'=>'modal-remote',
                                    'class' => 'btn btn-sm btn-primary'
                                ]
                                ). '&nbsp;' .
                                Html::a('Edit',
                                    ['update','id'=>$id],
                                    ['role'=>'modal-remote']
                                ). '&nbsp;' .
                           /*  Html::a('Import1',
                                Yii::getAlias('@web/maucua/import/upload?id='.$id.'&type=').DuAn::MODEL_ID ,
                                ['role'=>'modal-remote']
                            ). '&nbsp;' . */
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
            ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    
    //thêm mẫu cửa vào kế hoạch sản xuất
    public function actionThemMauCuaVaoKeHoach($idkh){
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = DuAn::findOne($idkh);
        $mauCuas = MauCua::find()->where('id_du_an IS NULL AND id_cong_trinh IS NOT NULL')
                ->orderBy(['ngay_yeu_cau'=>SORT_DESC, 'id_cong_trinh'=>SORT_DESC])->all();
        if($model == null){
            return [
                'title'=> 'Thông báo',
                'content'=>'Kế hoạch không tồn tại!',
                'footer'=> Html::button('Close-Popup',['data-bs-dismiss'=>'modal'])
            ];
        }
        if($request->isAjax){            
            if($request->isGet){
                return [
                    'title'=> "Thêm mẫu cửa vào KHSX ". $model->ten_du_an,
                    'content'=>$this->renderAjax('_formAddKhsx', [
                        'model' => $model,
                        'mauCuas' => $mauCuas
                    ]),
                    'footer'=> Html::a('<i class="fa-solid fa-arrow-left"></i> Quay lại',
                        ['view','id'=>$idkh],
                        ['role'=>'modal-remote', 'class'=>'btn btn-primary']
                        ). '&nbsp;' . Html::button('Save-Popup',['type'=>'submit']). '&nbsp;' .
                    Html::button('Close-Popup',['data-bs-dismiss'=>'modal'])
                ];
            }else if($model->load($request->post())){
                if($model->validate('vMauCua')){
                    //xu ly them vao khsx
                    if($model->vMauCua != null){
                        foreach ($model->vMauCua as $idMc=>$mc){
                            $mauCua = MauCua::findOne($idMc);
                            if($mauCua != null){
                                $mauCua->id_du_an = $idkh;
                                $mauCua->save();
                            }
                        }
                    }
                }
                
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thông tin Kế hoạch sản xuất",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'showFlash'=> 'Thêm '. count($model->vMauCua) . ' mẫu cửa vào KHSX thành công!'
                    ]),
                    'footer'=> Html::a('<i class="fa-solid fa-calendar-plus"></i> Thêm cửa vào KHSX',
                        ['them-mau-cua-vao-ke-hoach','idkh'=>$idkh],
                        [
                            'role'=>'modal-remote',
                            'class' => 'btn btn-sm btn-primary'
                        ]
                        ). '&nbsp;' .
                    Html::a('Edit',['update','id'=>$idkh],['role'=>'modal-remote']) . '&nbsp;' .
                    Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];   
            }else{
                return [
                    'title'=> "Thêm mẫu cửa vào KHSX ". $model->ten_du_an,
                    'content'=>$this->renderAjax('_formAddKhsx', [
                        'model' => $model,
                        'mauCuas' => $mauCuas
                    ]),
                    'footer'=> Html::a('<i class="fa-solid fa-arrow-left"></i> Quay lại',
                        ['view','id'=>$idkh],
                        ['role'=>'modal-remote', 'class'=>'btn btn-primary']
                        ). '&nbsp;' . Html::button('Save-Popup',['type'=>'submit']). '&nbsp;' .
                    Html::button('Close-Popup',['data-bs-dismiss'=>'modal'])
                ];
            }
        }//if isAjax
    }
    
    //xóa mẫu cửa vào kế hoạch sản xuất
    public function actionRemoveMauCuaKeHoach($idkh,$idmc){
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $modelKeHoach = DuAn::findOne($idkh);
        $modelMauCua = MauCua::findOne($idmc);
        if($modelKeHoach == null){
            return [
                'title'=> 'Thông báo',
                'content'=>'Kế hoạch không tồn tại!',
                'footer'=> Html::button('Close-Popup',['data-bs-dismiss'=>'modal'])
            ];
        }
        if($modelMauCua == null){
            return [
                'title'=> 'Thông báo',
                'content'=>'Mẫu cửa bạn chọn không tồn tại!',
                'footer'=> Html::button('Close-Popup',['data-bs-dismiss'=>'modal'])
            ];
        }
        if($request->isAjax){

            $modelMauCua->id_du_an = NULL;
            $modelMauCua->save();
            
            return [
                'forceReload'=>'#crud-datatable-pjax',
                'title'=> "Thông tin Kế hoạch sản xuất",
                'content'=>$this->renderAjax('view', [
                    'model' => $modelKeHoach,
                    'showFlash'=> 'Xóa mẫu cửa #'. $modelMauCua->code .' khỏi KHSX thành công!'
                ]),
                'footer'=> Html::a('<i class="fa-solid fa-calendar-plus"></i> Thêm cửa vào KHSX',
                    ['them-mau-cua-vao-ke-hoach','idkh'=>$idkh],
                    [
                        'role'=>'modal-remote',
                        'class' => 'btn btn-sm btn-primary'
                    ]
                    ). '&nbsp;' .
                Html::a('Edit',['update','id'=>$idkh],['role'=>'modal-remote']) . '&nbsp;' .
                Html::button('Close',['data-bs-dismiss'=>"modal"])
            ];
            
        }//if isAjax
    }
    
    /**
     * Displays list cua thuoc ke hoach theo kieu hien thi.
     * @param integer $id
     * @return mixed
     */
    public function actionGetViewHienThiCua($idKeHoach, $type)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = DuAn::findOne($idKeHoach);
        if($model !=null){
            $session = Yii::$app->session;
            $session->set('default-view-list', $type);
            if($type == "danhSach"){
                $session = Yii::$app->session;
                $cookieSearch = isset($_SESSION['search-dsCua-enable']) ? $_SESSION['search-dsCua-enable'] : '';
                return [
                    'status'=>'success',
                    'content' => $this->renderAjax('view_cua_item_ds', [
                        'model' => $model,
                        'cookieSearch'=>$cookieSearch
                    ])
                ];
            } else if ($type == "anhLon"){
                return [
                    'status'=>'success',
                    'content' => $this->renderAjax('view_cua_item_anh_lon', [
                        'model' => $model
                    ])
                ];
            }
        } else {
            return [
                'status'=>'failed',
                'content' => 'Phiếu xuất kho không tồn tại!'
            ];
        }
    }
    /**
     * Lưu trạng thái khi click nút search.
     * @param integer $id
     * @return mixed
     */
    public function actionSetShowSearch($type)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $session = Yii::$app->session;
        if($type == "dsCua"){
            $session->set('search-dsCua-enable', 1);
            return [
                'status'=>'success',
                'content' => ''
            ];
        } else {
            if ($session->has('search-dsCua-enable')){
                $session->remove('search-dsCua-enable');
            }
            return [
                'status'=>'success',
                'content' => ''
            ];
        }
    }

    /**
     * Creates a new DuAn model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new DuAn();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm Kế hoạch sản xuất",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .                      
                        Html::button('Close',['data-bs-dismiss'=>"modal"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm Kế hoạch sản xuất",
                    'content'=>'<span class="text-success">Thêm mới Kế hoạch sản xuất thành công!</span>',
                    'footer'=> Html::a('Create More',['create'],['role'=>'modal-remote']) . '&nbsp;' . 
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];         
            }else{           
                return [
                    'title'=> "Thêm Kế hoạch sản xuất",
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
     * Updates an existing DuAn model.
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
                    'title'=> "Chỉnh sửa Kế hoạch sản xuất",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                                Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thông tin Kế hoạch sản xuất",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::a('<i class="fa-solid fa-calendar-plus"></i> Thêm cửa vào KHSX',
                        ['them-mau-cua-vao-ke-hoach','idkh'=>$id],
                        [
                            'role'=>'modal-remote',
                            'class' => 'btn btn-sm btn-primary'
                        ]
                        ). '&nbsp;' .
                        Html::a('Edit',['update','id'=>$id],['role'=>'modal-remote']) . '&nbsp;' .
                        Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];    
            }else{
                 return [
                    'title'=> "Chỉnh sửa Kế hoạch sản xuất",
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
     * Delete an existing DuAn model.
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
     * Delete multiple existing DuAn model.
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
     * Finds the DuAn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DuAn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DuAn::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
