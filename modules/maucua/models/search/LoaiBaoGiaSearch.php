<?php

namespace app\modules\maucua\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\maucua\models\LoaiBaoGia;

/**
 * LoaiBaoGiaSearch represents the model behind the search form about `app\modules\maucua\models\LoaiBaoGia`.
 */
class LoaiBaoGiaSearch extends LoaiBaoGia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['code', 'ten_loai_bao_gia', 'nhom_bao_gia', 'ghi_chu'], 'safe'],
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
        $query = LoaiBaoGia::find();

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
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'ten_loai_bao_gia', $this->ten_loai_bao_gia])
            ->andFilterWhere(['like', 'nhom_bao_gia', $this->nhom_bao_gia])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);

        return $dataProvider;
    }
}
