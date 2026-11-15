<?php

use CupNoodles\ItemSales\Models\ItemSale;

$config['list']['filter'] = [
    'search' => [
        'prompt' => 'lang:cupnoodles.itemsales::default.text_filter_search',
        'mode' => 'all',
    ],
    'scopes' => [
        'date' => [
            'label' => 'lang:igniter::admin.text_filter_date',
            'type' => 'daterange',
            'conditions' => 'orders.order_date >= CAST(:filtered_start AS DATE) AND orders.order_date <= CAST(:filtered_end AS DATE)',
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [],
];

$config['list']['columns'] = [
    'orders' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-list',
        'attributes' => [
            'class' => 'btn btn-edit',
            'href' => 'cupnoodles/itemsales/item_sales/orders/{menu_id}',
            'title' => 'lang:cupnoodles.itemsales::default.button_view_orders',
        ],
    ],
    'name' => [
        'label' => 'lang:cupnoodles.itemsales::default.column_item',
        'type' => 'text',
        'searchable' => true,
    ],
    'number_of_orders' => [
        'label' => 'lang:cupnoodles.itemsales::default.column_orders',
        'type' => 'number',
    ],
    'quantity_sold' => [
        'label' => 'lang:cupnoodles.itemsales::default.column_quantity',
        'type' => 'text',
        'formatter' => fn($record, $column, $value) => ItemSale::formatQuantity($value),
    ],
    'revenue' => [
        'label' => 'lang:cupnoodles.itemsales::default.column_revenue',
        'type' => 'currency',
    ],
];

return $config;
