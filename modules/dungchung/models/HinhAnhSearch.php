<?php

namespace app\modules\dungchung\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * HinhAnhSearch represents the model behind the search form about `app\modules\dungchung\models\HinhAnh`.
 */
class HinhAnhSearch extends HinhAnh
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_tham_chieu', 'nguoi_tao'], 'integer'],
            [['loai', 'ten_hien_thi', 'duong_dan', 'ten_file_luu', 'img_extension', 'img_wh', 'ghi_chu', 'thoi_gian_tao'], 'safe'],
            [['img_size'], 'number'],
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
    public function search($params, $cusomSearch=NULL)
    {
        $query = HinhAnh::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		if($cusomSearch != NULL){
			$query->andFilterWhere ( [ 'OR' ,['like', 'loai', $cusomSearch],
            ['like', 'ten_hien_thi', $cusomSearch],
            ['like', 'duong_dan', $cusomSearch],
            ['like', 'ten_file_luu', $cusomSearch],
            ['like', 'img_extension', $cusomSearch],
            ['like', 'img_wh', $cusomSearch],
            ['like', 'ghi_chu', $cusomSearch]] );
 
		} else {
        	$query->andFilterWhere([
            'id' => $this->id,
            'id_tham_chieu' => $this->id_tham_chieu,
            'img_size' => $this->img_size,
            'thoi_gian_tao' => $this->thoi_gian_tao,
            'nguoi_tao' => $this->nguoi_tao,
        ]);

        $query->andFilterWhere(['like', 'loai', $this->loai])
            ->andFilterWhere(['like', 'ten_hien_thi', $this->ten_hien_thi])
            ->andFilterWhere(['like', 'duong_dan', $this->duong_dan])
            ->andFilterWhere(['like', 'ten_file_luu', $this->ten_file_luu])
            ->andFilterWhere(['like', 'img_extension', $this->img_extension])
            ->andFilterWhere(['like', 'img_wh', $this->img_wh])
            ->andFilterWhere(['like', 'ghi_chu', $this->ghi_chu]);
		}
        return $dataProvider;
    }
}
