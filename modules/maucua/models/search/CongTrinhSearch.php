<?php

namespace app\modules\maucua\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\maucua\models\CongTrinh;

/**
 * CongTrinhSearch represents the model behind the search form about `app\modules\maucua\models\CongTrinh`.
 */
class CongTrinhSearch extends CongTrinh
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_created'], 'integer'],
            [['code', 'ten_cong_trinh', 'id_khach_hang', 'ngay_bat_dau', 'ngay_hoan_thanh', 'ghi_chu', 'date_created'], 'safe'],
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
        $query = CongTrinh::find();

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
            'code_mau_thiet_ke' => $this->code_mau_thiet_ke,
            'ngay_bat_dau' => $this->ngay_bat_dau,
            'ngay_hoan_thanh' => $this->ngay_hoan_thanh,
            'date_created' => $this->date_created,
            'user_created' => $this->user_created,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'ten_cong_trinh', $this->ten_cong_trinh])
            ->andFilterWhere(['like', 'id_khach_hang', $this->id_khach_hang])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);

        return $dataProvider;
    }
}
