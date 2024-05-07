<?php

use frontend\components\DateHelper;
use frontend\models\Order;
use yii\helpers\Url;

?>

<div class="list-group">

    <h3>Даты</h3>
    <?php
        $yearsWithCounters = Order::getYearsForList();
        $monthsWithCounter = [];
        $listStr = '';
        foreach ($yearsWithCounters as $value)
        {
            $yearUrl = Url::to([
                'order/index',
                'SearchOrder[year]' => $value['orderyear']
            ]);
            $listStr .= '<a href="' . $yearUrl . '"';
            $listStr .= ' class="list-group-item list-group-item-action text-start">' . $value['orderyear'];
            $listStr .= ' <span class="badge bg-secondary rounded-pill">' . $value['ordercount'] . '</span></a>';
            $monthsWithCounter = Order::getMonthsForList($value['orderyear']);
            $listStr .= count($monthsWithCounter) > 0 ? '<div class="list-group">' : '';
            foreach ($monthsWithCounter as $monthValue)
            {
                $monthUrl = Url::to([
                    'order/index',
                    'SearchOrder[year]' => $value['orderyear'],
                    'SearchOrder[month]' => $monthValue['monthinyear'],
                ]);

                $listStr .= '<a href="' . $monthUrl . '"';
                $listStr .= ' class="list-group-item list-group-item-action text-end">';
                $listStr .= DateHelper::getLocalizedFullMonthName($monthValue['monthinyear']);
                $listStr .= ' <span class="badge bg-secondary rounded-pill">' . $monthValue['ordercount'] . '</span></a>';
                $monthsWithCounter = Order::getMonthsForList($value['orderyear']);
            }
            $listStr .= count($monthsWithCounter) > 0 ? '</div>' : '';
        }
        echo $listStr;
    ?>
</div>