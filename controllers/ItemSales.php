<?php

namespace CupNoodles\ItemSales\Controllers;

use AdminMenu;
use DB;

use Admin\Classes\FilterScope;


class ItemSales extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController'
    ];

    public $listConfig = [
        'list' => [
            'model' => 'CupNoodles\ItemSales\Models\ItemSales',
            'title' => 'lang:admin::lang.orders.text_title',
            'emptyMessage' => 'lang:admin::lang.orders.text_empty',
            'defaultSort' => ['order_menu_id', 'DESC'],
            'showPagination' => FALSE,
            'configFile' => 'itemsales',
            'bulkActions' => []
        ],
    ];



    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('orders', 'itemsales');
    }


    public function index()
    {
        $this->addJs('extensions/cupnoodles/itemsales/assets/js/itemsales.js', 'cupnoodles-itemsales');

        
        $index = $this->asExtension('ListController');

        $index->index();
    }


    public function expand($route){
        $post = post();
        
        $orders = \CupNoodles\ItemSales\Models\ItemSales::withoutGlobalScope('group_by_menu_id')
        ->where('menu_id', $post['menu_id'])
        ->with('order');
        
        if($post['location']){
            $orders->whereRelation('order', 'location_id', $post['location']);
        }
        if($post['dates'][0] != '' && $post['dates'][1] != ''){
            $orders->whereBetweenDates($post['dates']);
        }

        



        $this->vars['orders'] = $orders->get();
        return [
            '#orders' => $this->makePartial('expand')
        ];
    }

}
