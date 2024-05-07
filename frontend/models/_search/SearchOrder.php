<?php

namespace frontend\models\_search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Order;
use yii\db\Query;
use frontend\components\DateHelper;

/**
 * SearchOrder represents the model behind the search form of `frontend\models\Order`.
 */
class SearchOrder extends Order
{
    private Query $query;
    public $year;
    public $month;

    private const SORTABLE_FIELD_NAME = 'created_at';

    public function __construct(array $config = [])
    {
        $this->query = new Query();
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year'], 'integer'],
            [['month'], 'integer']
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
        $orders = ($this->query)
            ->select($this->attributes())
            ->from(Order::tableName())
            ->orderBy(self::SORTABLE_FIELD_NAME . ' desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $orders
        ]);

        if (!($this->load($params)) && $this->validate()) {
            return $dataProvider;
        }

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->year && $this->month) {
            $dateArr = DateHelper::getDbWhereConditionForYearAndMonth($this->year, $this->month);
            $dataProvider->query->andFilterWhere([
                'between', 'created_at', $dateArr['startDate'], $dateArr['endDate']
            ]);
        } else if ($this->year) {
            $dateArr = DateHelper::getDbWhereConditionForYear($this->year);
            $dataProvider->query->andFilterWhere([
                'between', 'created_at', $dateArr['startDate'], $dateArr['endDate']
            ]);
        }

        return $dataProvider;
    }
}
