<?php

namespace app\modules\maucua\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\maucua\models\KhoNhom;

/**
 * KhoNhomSearch represents the model behind the search form about `app\modules\maucua\models\KhoNhom`.
 */
class KhoNhomSearch extends KhoNhom
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_cay_nhom', 'so_luong', 'user_created'], 'integer'],
            [['chieu_dai'], 'number'],
            [['date_created', 'code'], 'safe'],
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
        $query = KhoNhom::find()->joinWith(['cayNhom as cn']);

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
            'id_cay_nhom' => $this->id_cay_nhom,
            'chieu_dai' => $this->chieu_dai,
            'so_luong' => $this->so_luong,
            'date_created' => $this->date_created,
            'user_created' => $this->user_created,
            'cn.code' => $this->code,
        ]);

        return $dataProvider;
    }
}
