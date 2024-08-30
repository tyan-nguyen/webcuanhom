<?php

namespace app\modules\dungchung\controllers;


use app\modules\dungchung\models\Import;
use app\modules\dungchung\models\imports\ImportBoPhan;
use app\modules\dungchung\models\imports\ImportNhanVien;
use app\modules\dungchung\models\imports\ImportThietBi;


use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use app\modules\dungchung\models\imports\ImportDoiTac;
use app\modules\dungchung\models\imports\ImportLoaiThietBi;
use app\modules\dungchung\models\imports\ImportHeThong;
use app\modules\dungchung\models\imports\ImportViTri;
use app\modules\kho\models\KhoVatTu;
use app\modules\dungchung\models\imports\ImportKhoVatTu;
use app\modules\kho\models\PhuKien;
use app\modules\dungchung\models\imports\ImportPhuKien;
use app\modules\kho\models\VatTu;
use app\modules\dungchung\models\imports\ImportVatTu;
use app\modules\kho\models\ThietBi;
use app\modules\maucua\models\KhoNhom;
use app\modules\dungchung\models\imports\ImportKhoNhom;

/**
 * Default controller for the `dungchung` module
 */
class ImportAllController extends Controller
{
     /**
     * Upload file to import
     * @param string $type
     * @return mixed
     */
    public function actionUpload($type,$showOverwrite=false)
    {   
        $model = new Import();
        $request = Yii::$app->request;
        
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                
                return [
                    'title'=> "Upload file",
                    'content'=>$this->renderAjax('upload', compact('model', 'showOverwrite')),
                    'footer'=> 
                    Html::button('Tải lên',['class'=>'btn btn-primary','type'=>"submit"]) . '&nbsp;' .
                    Html::button('Close',['data-bs-dismiss'=>"modal"])
                    
                ];
            }else if($model->load($request->post())){
                $file = UploadedFile::getInstance($model, 'file');
                if (!empty($file)){
                    $fileName = md5(Yii::$app->user->id . date('Y-m-d H:i:s')) . '.' . $file->extension;
                    $file->saveAs(Yii::getAlias('@webroot') . Import::FOLDER_EXCEL_UP .  $fileName);
                    
                    //checkfile
                    if($type==KhoVatTu::MODEL_ID){
                        $rt = ImportKhoVatTu::checkFile($type, $fileName);
                    } else if($type==PhuKien::MODEL_ID){
                        $rt = ImportPhuKien::checkFile($type, $fileName, $model->isOverwrite);                           
                    } else if($type==VatTu::MODEL_ID){
                        $rt = ImportVatTu::checkFile($type, $fileName, $model->isOverwrite);  
                    }else if($type==ThietBi::MODEL_ID){
                        $rt = ImportThietBi::checkFile($type, $fileName, $model->isOverwrite);
                    }else if($type==KhoNhom::MODEL_ID){
                        $rt = ImportKhoNhom::checkFile($type, $fileName);
                    }
                    /* else if($type==ThietBi::MODEL_ID){
                        $rt = ImportThietBi::checkFile($type, $fileName);
                    } else if($type==BoPhan::MODEL_ID){
                        $rt = ImportBoPhan::checkFile($type, $fileName);
                    } else if ($type == NhanVien::MODEL_ID){
                        $rt = ImportNhanVien::checkFile($type, $fileName);
                    } else if ($type == DoiTac::MODEL_ID){
                        $rt = ImportDoiTac::checkFile($type, $fileName);
                    } else if ($type == LoaiThietBi::MODEL_ID){
                        $rt = ImportLoaiThietBi::checkFile($type, $fileName);
                    } else if ($type == HeThong::MODEL_ID){
                        $rt = ImportHeThong::checkFile($type, $fileName);
                    } else if ($type == ViTri::MODEL_ID){
                        $rt = ImportViTri::checkFile($type, $fileName);
                    } */
                    
                    $status = false;
                    if(empty($rt)){
                        $status = true;
                    }
                    if($status == true){
                        return [
                            'title'=> "Kiểm tra file dữ liệu",
                            'content'=>$this->renderAjax('checkSuccess'),
                            'footer'=> 
                            Html::a('Tiến hành upload',['import?type='.$type.'&file=' . $fileName . '&isOverwrite='.$model->isOverwrite],['class'=>'btn btn-sm btn-primary','role'=>'modal-remote']) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                            
                        ];
                    } else {
                        Import::deleteFileTemp($fileName);
                        return [
                            'title'=> "Test file dữ liệu",
                            'content'=>$this->renderAjax('error', compact('rt')),
                            'tcontent'=>'File có lỗi! Vui lòng kiểm tra dữ liệu',
                            'footer'=> Html::a('<i class="fa-solid fa-upload"></i> Upload lại', Yii::getAlias('@web/dungchung/import-all/upload?type='). $type . '&showOverwrite=1', [ 'class'=>'btn btn-primary btn-sm', 'role'=>'modal-remote']) . '&nbsp;' .                            
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                            
                        ];
                    }
                    
                    
                }
            }
        }
    }
    
    /**
     * import file was checked to db
     * @param string $type
     * @param string $file
     * @return string[]
     */
    public function actionImport($type, $file, $isOverwrite=NULL){
        $request = Yii::$app->request;
        
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                if(Import::checkFileExist($file)){
                    
                    if($type==KhoVatTu::MODEL_ID){
                        $result = ImportKhoVatTu::importFile($file);
                    } else if($type==PhuKien::MODEL_ID){
                        $result = ImportPhuKien::importFile($file, $isOverwrite);                    
                    }else if($type==VatTu::MODEL_ID){
                        $result = ImportVatTu::importFile($file, $isOverwrite);
                    }else if($type==ThietBi::MODEL_ID){
                        $result = ImportThietBi::importFile($file, $isOverwrite);
                    }else if($type==KhoNhom::MODEL_ID){
                        $result = ImportKhoNhom::importFile($file, $isOverwrite);
                    }/* else if($type==ThietBi::MODEL_ID){
                        $result = ImportThietBi::importFile($file);
                    } else if($type==BoPhan::MODEL_ID){
                        $result = ImportBoPhan::importFile($file);
                    } else if ($type == NhanVien::MODEL_ID){
                        $result = ImportNhanVien::importFile($file);
                    } else if ($type == DoiTac::MODEL_ID){
                        $result = ImportDoiTac::importFile($file);
                    } else if ($type == LoaiThietBi::MODEL_ID){
                        $result = ImportLoaiThietBi::importFile($file);
                    } else if ($type == HeThong::MODEL_ID){
                        $result = ImportHeThong::importFile($file);
                    } else if ($type == ViTri::MODEL_ID){
                        $result = ImportViTri::importFile($file);
                    } */
                    
                    Import::deleteFileTemp($file);
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Kết quả import dữ liệu",
                        'content'=>$this->renderAjax('result', [
                            'success'=>$result['success'],
                            'error'=>$result['error'],
                            'errorArr'=>$result['errorArr']
                        ]),
                        'abc'=>$result['errors'],
                        'footer'=> Html::button('Close',['data-bs-dismiss'=>"modal"])
                        
                    ];
                }
            }
        }
    }

}
