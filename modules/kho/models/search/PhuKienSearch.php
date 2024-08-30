<?php

namespace app\modules\kho\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\kho\models\PhuKien;

/**
 * PhuKienSearch represents the model behind the search form about `app\modules\kho\models\PhuKien`.
 */
class PhuKienSearch extends PhuKien
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_nhom_vat_tu', 'user_created', 'xuat_xu'], 'integer'],
            [['code', 'ten_vat_tu', 'la_phu_kien', 'dvt', 'date_created', 'thuong_hieu', 'model'], 'safe'],
            [['so_luong', 'don_gia'], 'number'],
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
        $query = PhuKien::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['code' => SORT_ASC]],
        ]);
        
        $this->load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'id_nhom_vat_tu' => 1,//1 is phu kien
            'so_luong' => $this->so_luong,
            'don_gia' => $this->don_gia,
            'xuat_xu' => $this->xuat_xu,
            'date_created' => $this->date_created,
            'user_created' => $this->user_created,
        ]);
        
        $query->andFilterWhere(['like', 'code', $this->code])
        ->andFilterWhere(['like', 'ten_vat_tu', $this->ten_vat_tu])
        ->andFilterWhere(['like', 'la_phu_kien', $this->la_phu_kien])
        ->andFilterWhere(['like', 'thuong_hieu', $this->thuong_hieu])
        ->andFilterWhere(['like', 'model', $this->model])
        ->andFilterWhere(['like', 'dvt', $this->dvt]);
        
        return $dataProvider;
    }
}
