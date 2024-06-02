<?php 

$arrayLoaiTru = [1];

//$arrayLoaiTru = array_push($arrayLoaiTru, 2);
array_push($arrayLoaiTru, 2);
echo 'id NOT IN (' . implode(',', $arrayLoaiTru ) . ')';
/* use app\modules\maucua\models\NhomSuDung;
use app\modules\maucua\models\KhoNhom;
use app\modules\maucua\models\CayNhom;

$cayNhom = CayNhom::findOne(161);

$thanhNhom = KhoNhom::find()->where([
    'id_cay_nhom'=>$cayNhom->id,
])->andWhere('so_luong>0')
->andWhere('chieu_dai>='.(634+$cayNhom->min_allow_cut))
->orderBy('chieu_dai ASC')->one();

$soLuongDangNgam = NhomSuDung::find()->alias('t')->joinWith(['mauCua as mc'])->where([
    't.id_kho_nhom' => $thanhNhom->id,
])->andWhere("mc.status IN ('KHOI_TAO', 'TOI_UU')")->count();

echo 'So luong ton kho: ' . $thanhNhom->so_luong;

echo '<br/>';

echo 'So luong dang ngam: ' . $soLuongDangNgam;

echo '<br/>';

if($thanhNhom->so_luong - $soLuongDangNgam > 0){
    echo 'HOP LE';
} else {
    echo 'Khong hop le';
} */


?>