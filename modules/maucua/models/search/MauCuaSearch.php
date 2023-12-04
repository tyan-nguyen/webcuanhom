<?php

namespace app\modules\maucua\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\maucua\models\MauCua;

/**
 * MauCuaSearch represents the model behind the search form about `app\modules\maucua\models\MauCua`.
 */
class MauCuaSearch extends MauCua
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_he_nhom', 'id_loai_cua', 'id_parent', 'user_created'], 'integer'],
            [['code', 'ten_cua', 'kich_thuoc', 'date_created', 'ngang', 'cao'], 'safe'],
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
        $query = MauCua::find();

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
            'id_loai_cua' => $this->id_loai_cua,
            'id_parent' => $this->id_parent,
            'date_created' => $this->date_created,
            'user_created' => $this->user_created,
            'ngang'=>$this->ngang,
            'cao'=>$this->cao
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'ten_cua', $this->ten_cua])
            ->andFilterWhere(['like', 'kich_thuoc', $this->kich_thuoc]);

        return $dataProvider;
    }
}
