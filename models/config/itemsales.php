<?php


$config['list']['filter'] = [
    'search' => [
        'prompt' => 'cupnoodles.itemsales::default.search_placeholder',
        'mode' => 'all'
    ],
    'scopes' => [
        'location' => [
            'label' => 'lang:admin::lang.text_filter_location',
            'type' => 'select',
            'modelClass' => 'Admin\Models\Locations_model',
            'scope' => 'whereFromLocation',
            'nameFrom' => 'location_name',
            'locationAware' => TRUE
        ],
        'date' => [
            'label' => 'lang:admin::lang.text_filter_date',
            'type' => 'daterange',
            'scope' => 'whereBetweenDates',
            'default' => ['value' => [date('Y-m-d'), date('Y-m-d')]],
            'value' => [date('Y-m-d'), date('Y-m-d')]
        ],
    ],
];

$config['list']['toolbar'] = [
    'buttons' => [
    ],
];


$config['list']['columns'] = [

    'expand' => [
        'type' => 'button',
        'iconCssClass' => 'fa fa-chevron-right',
        'attributes' => [
            'class' => 'btn btn-edit expand-menu-item',
            'data-menu-id' => '{menu_id}'
        ],
    ],
    'name' => [
        'label' => 'cupnoodles.itemsales::default.item_name',
        'relation' => 'menu',
        'select' => 'IF(print_docket = "", name, print_docket)',
        'searchable' => TRUE,
        'sortable' => TRUE
    ],
    'number_of_orders' => [
        'label' => 'cupnoodles.itemsales::default.number_of_orders',
        'type' => 'text',
        'select' => "count(order_id)",
    ],
    'ordered_total' => [
        'label' => 'cupnoodles.itemsales::default.ordered_total',
        'type' => 'number',
        'select' => "replace(format(sum(quantity), 2), '.00', '')",
    ],
    'ordered_total_value' => [
        'label' => 'cupnoodles.itemsales::default.ordered_total_value',
        'type' => 'currency',
        'select' => 'sum(subtotal)',

    ]

];


return $config;
