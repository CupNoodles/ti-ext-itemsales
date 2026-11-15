<?php

declare(strict_types=1);

namespace CupNoodles\ItemSales;

use Igniter\System\Classes\BaseExtension;
use Override;

class Extension extends BaseExtension
{
    #[Override]
    public function registerPermissions(): array
    {
        return [
            'CupNoodles.ItemSales.View' => [
                'description' => 'lang:cupnoodles.itemsales::default.permission_view',
                'group' => 'igniter.cart::default.text_permission_order_group',
            ],
        ];
    }

    #[Override]
    public function registerNavigation(): array
    {
        return [
            'itemsales' => [
                'priority' => 11,
                'class' => 'itemsales',
                'icon' => 'fa-chart-bar',
                'href' => admin_url('cupnoodles/itemsales/item_sales'),
                'title' => lang('cupnoodles.itemsales::default.side_menu'),
                'permission' => 'CupNoodles.ItemSales.View',
            ],
        ];
    }
}
