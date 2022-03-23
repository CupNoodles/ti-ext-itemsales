<?php

namespace CupNoodles\ItemSales\Models;


use Admin\Models\Locations_model;
use Admin\Models\Orders_model;
use Model;


class ItemSales extends Model{


    protected $table = 'order_menus';

    protected $primaryKey = 'order_menu_id';

    public $relation = [
        'belongsTo' => [
            'order' => [
                'Admin\Models\Orders_model',
                'key' => 'order_id',
                'foreignKey' => 'order_id'
            ],
            'menu' => [
                'Admin\Models\Menus_model',
                'key' => 'menu_id',
                'foreignKey' => 'menu_id'
            ],
        ]
    ];


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('group_by_menu_id', function ($builder) {
            $builder->groupBy('menu_id');
        });

        static::addGlobalScope('order_exists', function ($builder) {
            $builder->whereHas('order');
        });


    }

    public function scopeWhereFromLocation($query, $locationId)
    {   
        if($locationId != ''){
            return $query->whereRelation('order', 'location_id', $locationId);
        }
        else{
            return $query;
        }
        
    }

    public function scopeWhereBetweenDates($query, $args)
    {   
        $query->whereRelation('order', 'order_date', '>=', $args[0]);
        $query->whereRelation('order', 'order_date', '<=', $args[1]);
        return $query;
    }

}