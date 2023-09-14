<?php

namespace app\modules\template\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\template\models\TemplatePages;

/**
 * TemplatePagesSearch represents the model behind the search form of `app\modules\template\models\TemplatePages`.
 */
class TemplatePagesSearch extends TemplatePages
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_template', 'is_dynamic', 'user_created'], 'integer'],
            [['code', 'name', 'file', 'datetime_created'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = TemplatePages::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_template' => $this->id_template,
            'is_dynamic' => $this->is_dynamic,
            'user_created' => $this->user_created,
            'datetime_created' => $this->datetime_created,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'file', $this->file]);

        return $dataProvider;
    }
}
