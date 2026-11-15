<?php

use CupNoodles\ItemSales\Models\ItemSale;

$config['orders']['columns'] = [
    'edit' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-pencil',
        'attributes' => [
            'class' => 'btn btn-edit',
            'href' => 'orders/edit/{order_id}',
        ],
    ],
    'order_id' => [
        'label' => 'lang:igniter::admin.column_id',
        'type' => 'number',
    ],
    'customer_name' => [
        'label' => 'lang:cupnoodles.itemsales::default.column_customer',
        'relation' => 'order',
        'select' => "concat(first_name, ' ', last_name)",
        'sortable' => false,
    ],
    'order_date' => [
        'label' => 'lang:cupnoodles.itemsales::default.column_date',
        'relation' => 'order',
        'select' => 'order_date',
        'type' => 'date',
        'sortable' => false,
    ],
    'order_time' => [
        'label' => 'lang:cupnoodles.itemsales::default.column_time',
        'relation' => 'order',
        'select' => 'order_time',
        'type' => 'time',
        'sortable' => false,
    ],
    'quantity' => [
        'label' => 'lang:cupnoodles.itemsales::default.column_quantity',
        'type' => 'text',
        'formatter' => fn($record, $column, $value) => ItemSale::formatQuantity($value),
    ],
    'subtotal' => [
        'label' => 'lang:cupnoodles.itemsales::default.column_revenue',
        'type' => 'currency',
    ],
];

return $config;
