<?php

namespace app\modules\banle\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\banle\models\HoaDon;

/**
 * HoaDonSearch represents the model behind the search form about `app\modules\banle\models\HoaDon`.
 */
class HoaDonSearch extends HoaDon
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ma_hoa_don', 'so_vao_so', 'nam', 'id_nguoi_lap', 'id_nguoi_lap', 'user_created', 'edit_mode', 'id_khach_hang'], 'integer'],
            [['ghi_chu', 'ngay_ban', 'ngay_lap', 'trang_thai', 'date_created'], 'safe'],
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
        $query = HoaDon::find();

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
            'ma_hoa_don' => $this->ma_hoa_don,
            'so_vao_so' => $this->so_vao_so,
            'nam' => $this->nam,
            'id_nguoi_ban' => $this->id_nguoi_ban,
            'ngay_ban' => $this->ngay_ban,
            'id_nguoi_lap' => $this->id_nguoi_lap,
            'ngay_lap' => $this->ngay_lap,
            'edit_mode' => $this->edit_mode,
            'id_khach_hang' => $this->id_khach_hang,
            'date_created' => $this->date_created,
            'user_created' => $this->user_created,
        ]);

        $query->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu])
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai]);

        return $dataProvider;
    }
}
