<?php

namespace app\modules\template\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\template\models\Template;

/**
 * TemplateSearchAjax3 represents the model behind the search form about `app\modules\template\models\Template`.
 */
class TemplateSearchAjax3 extends Template
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_created'], 'integer'],
            [['code', 'name', 'summary', 'datetime_created'], 'safe'],
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
        $query = Template::find();

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
            'user_created' => $this->user_created,
            'datetime_created' => $this->datetime_created,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'summary', $this->summary]);

        return $dataProvider;
    }
}
