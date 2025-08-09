<?php

namespace app\modules\banle\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\kho\models\KhoVatTu;
use app\modules\banle\models\HoaDon;
use app\modules\banle\models\HoaDonChiTiet;
use app\modules\dungchung\models\History;
use app\modules\maucua\models\KhoNhom;
use app\modules\maucua\models\CayNhom;
use app\modules\banle\models\KhachHang;

/**
 * HoaDonController implements the CRUD actions for HoaDon model.
 */
class HoaDonChiTietController extends Controller
{
    /**
     * lấy danh sách vật tư đổ vào dropdownlist
     * @param int $selected: nếu thêm mới thì là null, còn sửa vật tư thì truyền vào id của vật tư đang chọn
     * @return string[]
     */
    public function actionGetListVatTu($selected){
        Yii::$app->response->format = Response::FORMAT_JSON;
        //lay list vat tu
        $options = '<option>--Select--</option>';
        $lvts = [0,1,2,3];
        foreach ($lvts as $lvt){
            $vts = KhoVatTu::find()->where(['id_nhom_vat_tu'=>$lvt])->all();
            if($vts != null){
                $options .= '<optgroup label="'. KhoVatTu::getDmNhomVatTuLabel($lvt) .'">';
                foreach ($vts as $vt){
                     $options .= '<option value="'. $vt->id .'" '. ($vt->id==$selected ? 'selected' : '') .'>'. $vt->ten_vat_tu . ' - ' . $vt->codeByColor .'</option>';
                }
                $options .= '</optgroup>';
            }
        }
        return ['options' => $options];
    }
    /**
     * lấy thông tin vật tư để tự động điền vào vật tư chi tiết khi chọn vật tư bằng dropdownlist
     * @param int $idvt
     * @return string[]|NULL[]|string[]
     */
    public function actionGetVatTuAjax($idvt){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $vt = KhoVatTu::findOne($idvt);
        if($vt != null){
            return [
                'status'=>'success',
                'donGia' => $vt->don_gia,
                'dvt' => $vt->donViTinh->ten_dvt,
                'loaiVatTu' => $vt->tenNhomVatTu
            ];
        } else {
            return ['status'=>'failed'];
        }
    }
    
    /**
     * lấy danh sách nhôm đổ vào dropdownlist
     * @param int $selected: nếu thêm mới thì là null, còn sửa vật tư thì truyền vào id của vật tư đang chọn
     * @return string[]
     */
    public function actionGetListNhom($selected){
        Yii::$app->response->format = Response::FORMAT_JSON;
        //lay list vat tu
        $options = '<option>--Select--</option>';
        $cayNhoms = CayNhom::find()->all();
        foreach ($cayNhoms as $cayNhom){
            $khoNhoms = KhoNhom::find()->where(['id_cay_nhom'=>$cayNhom->id])->all();
            if($khoNhoms != null){
                $options .= '<optgroup label="'. $cayNhom->code . ' - ' . $cayNhom->ten_cay_nhom .'">';
                foreach ($khoNhoms as $khoNhom){
                    $options .= '<option value="'. $khoNhom->id .'" '. ($khoNhom->id==$selected ? 'selected' : '') .'>'. $khoNhom->cayNhom->code . ' - ' . $khoNhom->cayNhom->ten_cay_nhom . ' (' . $khoNhom->chieu_dai . ')' .'</option>';
                }
                $options .= '</optgroup>';
            }
        }
        return ['options' => $options];
    }
    /**
     * lấy thông tin vật tư để tự động điền vào vật tư chi tiết khi chọn vật tư bằng dropdownlist
     * @param int $idvt
     * @return string[]|NULL[]|string[]
     */
    public function actionGetNhomAjax($idvt){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $vt = KhoNhom::findOne($idvt);
        if($vt != null){
            return [
                'status'=>'success',
                'donGia' => $vt->cayNhom->don_gia,
                'khoiLuong'=>$vt->khoiLuong,
                'dvt' => 'Cây',
                'loaiVatTu' => 'NHOM'
            ];
        } else {
            return ['status'=>'failed'];
        }
    }
    
    /**
     * lấy thông tin khách hàng để tự động điền vào vật tư chi tiết khi chọn vật tư bằng dropdownlist
     * @param int $idvt
     * @return string[]|NULL[]|string[]
     */
    public function actionGetKhachHangAjax($idkh){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $vt = KhachHang::findOne($idkh);
        if($vt != null){
            return [
                'status'=>'success',
                'tenKhachHang' => $vt->ten_khach_hang,
                'diaChiKhachHang' => $vt->dia_chi,
                'sdtKhachHang' => $vt->so_dien_thoai,
                'emailKhachHang' => $vt->email,
            ];
        } else {
            return ['status'=>'failed'];
        }
    }
    
    public function actionSaveVatTu($id){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $hoaDon = HoaDon::findOne($id);
        if($hoaDon != null){
            if(isset($_POST['id']) && $_POST['id'] != null){
                //update
                $model= HoaDonChiTiet::findOne($_POST['id']);
                $contentHistory = '';
                if(isset($_POST['soLuong'])){
                    if($hoaDon->trang_thai != 'BAN_NHAP' && $hoaDon->edit_mode == 1 && $model->so_luong != $_POST['soLuong']){
                        $contentHistory .= 'Thay đổi Số lượng từ ' . $model->so_luong . ' -> ' . $_POST['soLuong'];
                    }
                    $model->so_luong = $_POST['soLuong'];
                }
                
                // $model->id_vat_tu = $_POST['idVatTu'];
                
                if(isset($_POST['donGia'])){
                    if($hoaDon->trang_thai != 'BAN_NHAP' && $hoaDon->edit_mode == 1 && $model->don_gia != $_POST['donGia']){
                        if($contentHistory != '')
                            $contentHistory .= '<br/>';
                            $contentHistory .= 'Thay đổi Đơn giá từ ' . $model->don_gia . ' -> ' . $_POST['donGia'];
                    }
                    $model->don_gia = $_POST['donGia'];
                }
                if(isset($_POST['ghiChu'])){
                    if($hoaDon->trang_thai != 'BAN_NHAP' && $hoaDon->edit_mode == 1 && $model->ghi_chu != $_POST['ghiChu']){
                        if($contentHistory != '')
                            $contentHistory .= '<br/>';
                            $contentHistory .= 'Thay đổi Ghi chú từ ' . $model->ghi_chu . ' -> ' . $_POST['ghiChu'];
                    }
                    $model->ghi_chu =$_POST['ghiChu'];
                }
                
                if($model->save()){
                    $hoaDon->refresh();
                    
                    if($contentHistory != ''){
                        $contentHistory = $model->vatTu->ten_vat_tu . ': ' . $contentHistory;
                        History::addManualHistory(HoaDon::MODEL_ID, $hoaDon->id, $contentHistory);
                    }
                    
                    return [
                        'type'=>'update',
                        'status'=>'success',
                        'results'=>$hoaDon->dsVatTuYeuCau(),
                        'vatTuXuat'=>$model->danhSachJson()
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'message' => 'can not save from update'
                    ];
                }
            } else {
                //check vat tu da co trong hoa don chua
                $vatTu = HoaDonChiTiet::find()->where([
                    'id_hoa_don' => $id,
                    'id_vat_tu' => $_POST['idVatTu'],
                ])->one();
                if($vatTu != null){
                    return [
                        'status' => 'error',
                        'message' => 'Vật tư đã tồn tại trong hóa đơn. Vui lòng cập nhật lại số lượng!'
                    ];
                } else {
                    //create
                    $model = new HoaDonChiTiet();
                    $model->id_hoa_don = $id;
                    $model->id_vat_tu = $_POST['idVatTu'];
                    
                    if($_POST['loaiVatTu'] == 'VAT-TU'){
                        $vatTuModel = KhoVatTu::findOne($_POST['idVatTu']);
                        if($vatTuModel != null)
                            $model->loai_vat_tu = $vatTuModel->tenNhomVatTu;
                    } else  if($_POST['loaiVatTu'] == 'NHOM'){
                        $model->loai_vat_tu = 'NHOM';
                    }
                    
                    $model->don_gia = $_POST['donGia'];
                    $model->so_luong = $_POST['soLuong'];
                    
                    $model->ghi_chu = isset($_POST['ghiChu'])?$_POST['ghiChu']:'';
                    if($model->save()){
                        $hoaDon->refresh();
                        return [
                            'type'=>'create',
                            'status'=>'success',
                            'results'=>$hoaDon->dsVatTuYeuCau(),
                            'vatTuXuat'=>$model->danhSachJson()
                        ];
                    } else {
                        return [
                            'status' => 'error',
                            'message'=>'can not save from create'
                        ];
                    }
                }
            }
        }else{
            return [
                'status' => 'error',
                'message'=>'Hóa đơn không tồn tại!'
            ];
        }
    }
    
    public function actionDeleteVatTu($id){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $vatTu = HoaDonChiTiet::findOne($id);
        if($vatTu != null){
            $hoaDonId = $vatTu->id_hoa_don;
            if($vatTu->delete()){
                $hoaDon = HoaDon::findOne($hoaDonId);
                return [
                    'type'=>'delete',
                    'status'=>'success',
                    'results'=>$hoaDon->dsVatTuYeuCau(),
                ];
            } else {
                return [
                    'type'=>'delete',
                    'status'=>'error',
                    'message'=>'Có lỗi xảy ra!',
                    'results'=>$hoaDon->dsVatTuYeuCau(),
                ];
            }
        }
    }
}