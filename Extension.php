<?php 

namespace CupNoodles\ItemSales;


use System\Classes\BaseExtension;
use DB;
use Event;
use App;
use Igniter\Flame\Exception\ApplicationException;

/**
 * Item Sales Extension Information File
 */
class Extension extends BaseExtension
{
    /**
     * Returns information about this extension.
     *
     * @return array
     */
    public function extensionMeta()
    {
        return [
            'name'        => 'ItemSales',
            'author'      => 'CupNoodles',
            'description' => 'Filterable sales report page broken down by item.',
            'icon'        => 'fa-list-alt',
            'version'     => '1.0.0'
        ];
    }

    /**
     * Register method, called when the extension is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return void
     */
    public function boot()
    {


    }


    public function registerSchedule($schedule)
    {



    }

    public function registerSettings()
    {

    }



    public function registerNavigation()
    {
        return [
            'sales' => [
                'child' => [
                    'itemsales' => [
                        'priority' => 20,
                        'class' => 'pages',
                        'href' => admin_url('cupnoodles/itemsales/itemsales'),
                        'title' => lang('cupnoodles.itemsales::default.side_menu'),
                        'permission' => 'Admin.ItemSales',
                    ],
                ],
            ],
        ];
    }
}
