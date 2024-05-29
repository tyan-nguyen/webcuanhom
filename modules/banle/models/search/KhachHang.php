<?php

namespace app\modules\banle\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\banle\models\KhachHang as KhachHangModel;

/**
 * KhachHang represents the model behind the search form about `app\modules\banle\models\KhachHang`.
 */
class KhachHang extends KhachHangModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_loai_khach_hang', 'user_created'], 'integer'],
            [['ten_khach_hang', 'dia_chi', 'so_dien_thoai', 'email', 'ghi_chu', 'date_created'], 'safe'],
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
        $query = KhachHangModel::find();

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
            'id_loai_khach_hang' => $this->id_loai_khach_hang,
            'date_created' => $this->date_created,
            'user_created' => $this->user_created,
        ]);

        $query->andFilterWhere(['like', 'ten_khach_hang', $this->ten_khach_hang])
            ->andFilterWhere(['like', 'dia_chi', $this->dia_chi])
            ->andFilterWhere(['like', 'so_dien_thoai', $this->so_dien_thoai])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);

        return $dataProvider;
    }
}
