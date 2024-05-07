<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\_search\SearchOrder $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-index container text-center">
    <div class="row">
        <div class="col">
            <?= $this->render('sidebars/dateList') ?>
        </div>

        <div class="col-10">
            <h1><?= Html::encode($this->title) ?></h1>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'pager' => ['class' => \yii\bootstrap5\LinkPager::class],
                'columns' => [
                    'id:integer',
                    [
                        'header' => '<b>Сумма</b>',
                        'attribute' => 'sum',
                        'format' => 'currency',
                    ],
                    [
                        'header' => '<b>Оплачено</b>',
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
