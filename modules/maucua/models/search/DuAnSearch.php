<?php

namespace app\modules\maucua\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\maucua\models\DuAn;

/**
 * DuAnSearch represents the model behind the search form about `app\modules\maucua\models\DuAn`.
 */
class DuAnSearch extends DuAn
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_created'], 'integer'],
            [['code', 'ten_du_an', 'ten_khach_hang', 'dia_chi', 'so_dien_thoai', 'email', 'trang_thai', 'ngay_bat_dau_thuc_hien', 'ngay_hoan_thanh_du_an', 'ghi_chu', 'date_created'], 'safe'],
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
        $query = DuAn::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'ngay_bat_dau_thuc_hien' => $this->ngay_bat_dau_thuc_hien,
            'ngay_hoan_thanh_du_an' => $this->ngay_hoan_thanh_du_an,
            'date_created' => $this->date_created,
            'user_created' => $this->user_created,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'ten_du_an', $this->ten_du_an])
            ->andFilterWhere(['like', 'ten_khach_hang', $this->ten_khach_hang])
            ->andFilterWhere(['like', 'dia_chi', $this->dia_chi])
            ->andFilterWhere(['like', 'so_dien_thoai', $this->so_dien_thoai])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'trang_thai', $this->trang_thai])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);

        return $dataProvider;
    }
}
