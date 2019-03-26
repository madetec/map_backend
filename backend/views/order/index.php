<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * @var $this \yii\web\View
 * @var $dataProvider \backend\forms\OrderSearch
 * @var $searchModel \backend\forms\OrderSearch
 */

use uztelecom\entities\orders\Order;
use uztelecom\helpers\OrderHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    [
        'class' => 'yii\grid\SerialColumn',
        'options' => [
            'style' => 'width: 10px;'
        ],
    ],
    [
        'attribute' => 'user',
        'value' => function (Order $order) {
            return $order->user->profile->fullName;
        },
        'format' => 'raw',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'driver',
        'value' => function (Order $order) {
            return $order->driver ? $order->driver->profile->fullName : null;
        },
        'format' => 'raw',
        'filterInputOptions' => ['class' => 'form-control input-sm'],
    ],
    [
        'attribute' => 'from',
        'value' => function (Order $order) {
            return Html::tag('p',
                \yii\helpers\StringHelper::truncate($order->from_address, '20'), [
                "data-toggle" => "tooltip",
                "data-placement" => "top",
                "title" => $order->from_address
            ]);
        },
        'format' => 'raw',
    ],
    [
        'attribute' => 'to',
        'value' => function (Order $order) {
            return Html::tag('p',
                \yii\helpers\StringHelper::truncate($order->to_address, '20'), [
                    "data-toggle" => "tooltip",
                    "data-placement" => "top",
                    "title" => $order->to_address
                ]);
        },
        'format' => 'raw',
    ],
    [
        'attribute' => 'created_at',
        'value' => function (Order $order) {
            return $order->created_at;
        },
        'format' => 'datetime',
    ],
    [
        'attribute' => 'status',
        'value' => function (Order $order) {
            return OrderHelper::getStatusLabel($order->status);
        },
        'format' => 'raw',
        'filter' => OrderHelper::getStatusList(),
        'filterInputOptions' => ['class' => 'form-control input-sm'],
        'options' => [
            'style' => 'width: 150px;'
        ]
    ],
    [
        'attribute' => 'view-map',
        'label' => 'Карта',
        'value' => function (Order $order) {
            return Html::a(Html::tag('i', null, ['class' => 'fa fa-map-marker']) . ' Посмотреть', Url::to(['order/view-map', 'id' => $order->id]));
        },
        'format' => 'html'
    ]
];


try {
    $exportMenu = Html::tag('b', 'Экспорт данных: ') . \kartik\export\ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'fontAwesome' => true,
            'exportConfig' => [
                'Csv' => false,
                'Html' => false,
                'Txt' => false,
            ],
            'columnSelectorOptions' => [
                'class' => 'btn-sm'
            ],
            'dropdownOptions' => [
                'class' => 'btn-sm'
            ]
        ]);

    $templateArr = [
        Html::beginTag('div', ['class' => 'row']),
        Html::beginTag('div', ['class' => 'col-md-12']),
        Html::beginTag('div', ['class' => 'box']),
        Html::beginTag('div', ['class' => 'box-header']),
        Html::tag('div', $exportMenu),
        Html::tag('div', '{pager}', ['class' => 'box-tools']),
        Html::endTag('div'),
        Html::beginTag('div', ['class' => 'table-responsive']),
        Html::tag('div', '{items}', ['class' => 'box-body no-padding']),
        Html::endTag('div'),
        Html::endTag('div'),
        Html::endTag('div'),
        Html::endTag('div'),
    ];

    $layout = implode("\n", $templateArr);

    echo \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => $layout,
        'pager' => [
            'options' => [
                'class' => 'pagination pagination-sm no-margin pull-right'
            ],
        ],
        'tableOptions' => [
            'class' => 'table'
        ],
        'columns' => $gridColumns,
    ]);
} catch (\Exception $e) {
    echo $e->getMessage();
}


$script = <<<JS
$('[data-toggle="tooltip"]').tooltip()
JS;

$this->registerJs($script);
