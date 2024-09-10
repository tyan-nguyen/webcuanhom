<?php

namespace app\modules\maucua\models;

use Yii;
use app\custom\CustomFunc;
use app\modules\maucua\models\base\DanhGiaBase;
use app\modules\users\models\TaiKhoan;
use app\modules\users\models\TaiKhoanInfo;

class DanhGia extends DanhGiaBase
{ 
    /**
     * Gets query for [[MauCua]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMauCua()
    {
        return $this->hasOne(MauCua::class, ['id' => 'id_mau_cua']);
    }
    /** After record is saved
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $danhGia = new DanhGia();
        $arr = TaiKhoanInfo::getListEmailNhanThongBao();
        if($arr!=null){
            $html = '<b>Kết quả kiểm tra mẫu cửa không đạt</b>';
            $html .= '<br/>Tên mẫu cửa: ' . $this->mauCua->code;
            $html .= '<br/>Kế hoạch sản xuất: ' . ($this->mauCua->duAn!=NULL?$this->mauCua->duAn->ten_du_an:'');
            $html .= '<br/>Tên công trình: ' . ($this->mauCua->congTrinh!=NULL?$this->mauCua->congTrinh->ten_cong_trinh:'');
            $html .= '<br/>Lần kiểm tra thứ: '. $this->lan_thu;
            $html .= '<br/>Người đánh giá: '.$this->ten_nguoi_danh_gia;
            $html .= '<br/>Kết quả đánh giá:';
            $html .= '<ul>';
            $html .= '<li>'. $danhGia->getAttributeLabel('check_he_nhom') . ': ' . ($this->check_he_nhom?'Đạt':'Không đạt') . '</li>';
            $html .= '<li>'. $danhGia->getAttributeLabel('check_kich_thuoc_phu_bi') . ': ' . ($this->check_kich_thuoc_phu_bi?'Đạt':'Không đạt') . '</li>';
            $html .= '<li>'. $danhGia->getAttributeLabel('check_kich_thuoc_thuc_te') . ': ' . ($this->check_kich_thuoc_thuc_te?'Đạt':'Không đạt') . '</li>';
            $html .= '<li>'. $danhGia->getAttributeLabel('check_nhan_hieu') . ': ' . ($this->check_nhan_hieu?'Đạt':'Không đạt') . '</li>';
            $html .= '<li>'. $danhGia->getAttributeLabel('check_chu_thich') . ': ' . ($this->check_chu_thich?'Đạt':'Không đạt') . '</li>';
            $html .= '<li>'. $danhGia->getAttributeLabel('check_tham_my') . ': ' . ($this->check_tham_my?'Đạt':'Không đạt') . '</li>';
            $html .= '</ul>';
            $html .= 'Vui lòng đăng nhập phần mềm để kiểm tra chi tiết!';
            
            Yii::$app->mailer->compose() // Sử dụng nếu có template
            ->setFrom('notification@vnweb.online') // Mail sẽ gửi đi
            ->setTo($arr) // Mail sẽ nhận
            ->setSubject('[PM Cửa nhôm] Mẫu cửa #'. $this->mauCua->code .' kiểm tra không đạt') // tiêu đề mail
            ->setHtmlBody($html) // Nội dung mail dạng Html nếu không muốn dùng html thì có thể thay thế bằng setTextBody('Nội dung gửi mail trong Yii2') để chỉ hiển thị text
            ->send();
        }
        
    }
    /**
     * Gets query for [[TaiKhoan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaiKhoan()
    {
        return $this->hasOne(TaiKhoan::class, ['id' => 'id_nguoi_danh_gia']);
    }
    /**
     * trang thai danh gia, tong hop tu cac checklist
     * neu tat ca check list deu check thi ket qua dat, nguoc lai khong dat
     */
    public function getTrangThai(){
        $trangThai = true;
        if(!$this->check_he_nhom || !$this->check_kich_thuoc_phu_bi || !$this->check_kich_thuoc_thuc_te || !$this->check_nhan_hieu || !$this->check_chu_thich || !$this->check_tham_my){
            $trangThai = false;
        }
        return $trangThai;
    }
    public function getTrangThaiText(){
        if($this->trangThai == true)
            return 'Đạt';
        else if($this->trangThai == false)
            return 'Không đạt';
        else 
            return 'Chưa xác định';
    }
    /**
     * get lần đánh giá tiếp theo
     */
    public function getLanDanhGiaTiepTheo($idMauCua){
        $danhGia =  DanhGia::find()->where(['id_mau_cua'=>$idMauCua])->orderBy(['lan_thu'=>SORT_DESC])->one();
        if($danhGia){
            return ($danhGia->lan_thu + 1);
        } else {
            return 1;
        }
    }
}