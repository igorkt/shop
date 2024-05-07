<?php

namespace frontend\models;

use Exception as GlobalException;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\Exception;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property float|null $sum
 * @property string $created_at
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sum'], 'number'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sum' => 'Сумма',
            'created_at' => 'Создано',
        ];
    }

    /**
     * Get list of years with count of orders
     * @return array
     * @throws InvalidConfigException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws Exception
     * @throws GlobalException
     */
    public static function getYearsForList(): array
    {
        $yearAlias = 'orderyear';
        $selectExpression = new Expression(
            "date_part('year', created_at) as " . $yearAlias . ", COUNT(id) as ordercount"
        );
        return (new Query())
                    ->select($selectExpression)
                    ->from(self::tableName())
                    ->groupBy($yearAlias)
                    ->orderBy($yearAlias .' DESC')
                    ->all();   
    }

    /**
     * Get list of months with orders in year with count of orders
     * @return array
     * @throws InvalidConfigException
     * @throws NotSupportedException
     * @throws InvalidArgumentException
     * @throws Exception
     * @throws GlobalException
     */
    public static function getMonthsForList(int $year): array
    {
        $monthAlias = 'monthinyear';
        $selectExpression = new Expression(
            "date_part('month', created_at) as " . $monthAlias . ", COUNT(id) as ordercount"
        );
        $whereExpression = new Expression(
            "date_part('year', created_at) = " . $year
        );
        return (new Query())
                    ->select($selectExpression)
                    ->from(self::tableName())
                    ->where($whereExpression)
                    ->groupBy($monthAlias)
                    ->orderBy($monthAlias .' DESC')
                    ->all();   
    }
}
