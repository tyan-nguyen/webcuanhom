<td></td>
<td><a class="a-edit-wrap" href="/maucua/mau-cua-nhom/sua-nhom-popup?id=<?= $model->id ?>" role="modal-remote-2"><?= $model->cayNhom->code ?></a></td>
<td><?= $model->cayNhom->ten_cay_nhom ?></td>
<td><?= $model->cayNhom->heNhom->code ?></td>
<td><?= $model->cayNhom->do_day ?></td>
<td><?= $model->chieu_dai ?></td>
<td><?= $model->so_luong  ?></td>
<td><?= $model->kieu_cat  ?></td>
<td><?= $model->khoi_luong  ?></td>
<td><?= $model->cayNhom->checkTonKhoNhom($model->chieu_dai) ?></td>