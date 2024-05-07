<?php

namespace frontend\components;

use DateTime;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;

final class DateHelper
{
    /**
     * Get search condition if only year is given
     * @param int $year
     * @return array
     */
    public static function getDbWhereConditionForYear(int $year): array
    {
        $startDate = $year . '-01-01 00:00:00.000';
        $endDate = $year . '-12-31 23:59:59.000';
        return [
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
    }

    /**
     * Get search condition if only year and month is given
     * @param int $year
     * @param int $month
     * @return array
     */
    public static function getDbWhereConditionForYearAndMonth(int $year, int $month): array
    {
        $nextMonthNum = $month + 1;
        $endYear = $year;
        if ($nextMonthNum > 12) {
            $nextMonthNum = 1;
            $endYear += 1;
        }
        $endDateNotNormalized = $endYear . '-' . $nextMonthNum . '-01 00:00:00.000';
        $endDate =  date('Y-m-d H:i:s', strtotime($endDateNotNormalized) - 1) . '.000';
        $startDate = $year . '-' . $month . '-01 00:00:00.000';
        return [
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
    }

    /**
     * Get localized month name from month number 
     * @param int $monthNumber
     * @return string
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     */
    public static function getLocalizedFullMonthName(int $monthNumber): string
    {
        $monthNum  = $monthNumber;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        return \Yii::$app->formatter->asDate($dateObj, 'LLLL');
    }
}

?>