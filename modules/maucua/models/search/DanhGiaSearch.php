<?php

namespace app\modules\maucua\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\maucua\models\DanhGia;

/**
 * DanhGiaSearch represents the model behind the search form about `app\modules\maucua\models\DanhGia`.
 */
class DanhGiaSearch extends DanhGia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_mau_cua', 'id_nguoi_danh_gia', 'lan_thu', 'user_created'], 'integer'],
            [['ten_nguoi_danh_gia', 'ngay_danh_gia', 'ghi_chu', 'date_created', 'check_he_nhom', 'check_kich_thuoc_phu_bi', 'check_kich_thuoc_thuc_te', 'check_nhan_hieu', 'check_chu_thich', 'check_tham_my'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DanhGia::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_mau_cua' => $this->id_mau_cua,
            'id_nguoi_danh_gia' => $this->id_nguoi_danh_gia,
            'lan_thu' => $this->lan_thu,
            'ngay_danh_gia' => $this->ngay_danh_gia,
            'date_created' => $this->date_created,
            'user_created' => $this->user_created,
        ]);

        $query->andFilterWhere(['like', 'ten_nguoi_danh_gia', $this->ten_nguoi_danh_gia])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu])
            ->andFilterWhere(['like', 'check_he_nhom', $this->check_he_nhom])
            ->andFilterWhere(['like', 'check_kich_thuoc_phu_bi', $this->check_kich_thuoc_phu_bi])
            ->andFilterWhere(['like', 'check_kich_thuoc_thuc_te', $this->check_kich_thuoc_thuc_te])
            ->andFilterWhere(['like', 'check_nhan_hieu', $this->check_nhan_hieu])
            ->andFilterWhere(['like', 'check_chu_thich', $this->check_chu_thich])
            ->andFilterWhere(['like', 'check_tham_my', $this->check_tham_my]);

        return $dataProvider;
    }
}
