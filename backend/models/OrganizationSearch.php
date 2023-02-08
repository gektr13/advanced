<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * OrganizationSearch represents the model behind the search form of `backend\models\Organization`.
 */
class OrganizationSearch extends Organization
{
    public $balance;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'created_at', 'updated_at', 'balance'], 'safe'],
            //[['balance'], 'number'],
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
        $query = Organization::find()->select('organizations.id, organizations.name,transaction.balance as balance, organizations.created_at, organizations.updated_at');

        $augQuery = Transaction::find()
            ->select('organization_id, SUM(value) as sum')
            ->where(['type' => Transaction::TYPE_AUGMENT])
            ->groupBy('organization_id');

        $dedQuery = Transaction::find()
            ->select('organization_id, SUM(value) as sum')
            ->where(['type' => Transaction::TYPE_DEDUCT])
            ->groupBy('organization_id');

        $subQuery = Transaction::find()->from(['AUG' => $augQuery])
            ->select('AUG.organization_id, (AUG.sum - DED.sum) as balance')
            ->leftJoin(['DED' => $dedQuery], '`AUG`.`organization_id` = `DED`.`organization_id`')
            ->groupBy('organization_id');

        $query->join('LEFT OUTER JOIN', ['transaction' => $subQuery], 'transaction.organization_id = id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'name',
                'balance' => [
                    'asc' => ['transaction.balance' => SORT_ASC],
                    'desc' => ['transaction.balance' => SORT_DESC],
                    'label' => 'Balance'
                ],
                'created_at',
                'updated_at',
            ]
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        $query->andFilterWhere(['like', 'transaction.balance', $this->balance]);
        // print_r( $query->createCommand()->getRawSql());
        return $dataProvider;
    }
}
