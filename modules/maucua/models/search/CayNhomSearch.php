<?php

namespace app\modules\maucua\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\maucua\models\CayNhom;

/**
 * CayNhomSearch represents the model behind the search form about `app\modules\maucua\models\CayNhom`.
 */
class CayNhomSearch extends CayNhom
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_he_nhom', 'so_luong', 'user_created'], 'integer'],
            [['code', 'ten_cay_nhom', 'for_cua_so', 'for_cua_di', 'date_created'], 'safe'],
            [['don_gia', 'khoi_luong', 'chieu_dai', 'min_allow_cut', 'do_day'], 'number'],
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
        $query = CayNhom::find();

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
            'id_he_nhom' => $this->id_he_nhom,
            'so_luong' => $this->so_luong,
            'don_gia' => $this->don_gia,
            'khoi_luong' => $this->khoi_luong,
            'chieu_dai' => $this->chieu_dai,
            'do_day' => $this->do_day,
            'min_allow_cut' => $this->min_allow_cut,
            'date_created' => $this->date_created,
            'user_created' => $this->user_created,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'ten_cay_nhom', $this->ten_cay_nhom])
            ->andFilterWhere(['like', 'for_cua_so', $this->for_cua_so])
            ->andFilterWhere(['like', 'for_cua_di', $this->for_cua_di]);

        return $dataProvider;
    }
}
