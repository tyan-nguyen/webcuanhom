<?php

namespace app\modules\maucua\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\maucua\models\HeMau;

/**
 * HeMauSearch represents the model behind the search form about `app\modules\maucua\models\HeMau`.
 */
class HeMauSearch extends HeMau
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_created'], 'integer'],
            [['code', 'ten_he_mau', 'ma_mau', 'for_nhom', 'for_phu_kien', 'date_created'], 'safe'],
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
        $query = HeMau::find();

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
            'date_created' => $this->date_created,
            'user_created' => $this->user_created,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'ten_he_mau', $this->ten_he_mau])
            ->andFilterWhere(['like', 'ma_mau', $this->ma_mau])
            ->andFilterWhere(['like', 'for_nhom', $this->for_nhom])
            ->andFilterWhere(['like', 'for_phu_kien', $this->for_phu_kien]);

        return $dataProvider;
    }
}
