<?php

declare(strict_types=1);

namespace CupNoodles\ItemSales\Http\Controllers;

use CupNoodles\ItemSales\Models\ItemSale;
use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Facades\Template;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Cart\Models\Menu;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\System\Models\Settings;
use Illuminate\Support\Facades\DB;

/**
 * Item Sales report: one row per menu item with orders, quantity and revenue for the chosen
 * dates, and a page listing the orders behind each row.
 *
 * Both lists follow the admin's location switcher (like the Orders list) and count only placed,
 * non-cancelled orders (like the dashboard's sales figures).
 */
class ItemSales extends AdminController
{
    public array $implement = [
        ListController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => ItemSale::class,
            'title' => 'lang:cupnoodles.itemsales::default.text_title',
            'emptyMessage' => 'lang:cupnoodles.itemsales::default.text_empty',
            'defaultSort' => ['quantity_sold', 'DESC'],
            'showPagination' => false,
            'showCheckboxes' => false,
            'configFile' => 'itemsale',
        ],
        'orders' => [
            'model' => ItemSale::class,
            'title' => 'lang:cupnoodles.itemsales::default.text_orders_title',
            'emptyMessage' => 'lang:cupnoodles.itemsales::default.text_empty',
            'defaultSort' => ['order_id', 'DESC'],
            'showCheckboxes' => false,
            'configFile' => 'itemsaleorder',
        ],
    ];

    protected null|string|array $requiredPermissions = 'CupNoodles.ItemSales.View';

    /** Menu item whose orders are listed on the orders page */
    protected ?int $menuId = null;

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('itemsales');
    }

    /**
     * Orders that included one menu item, for the dates and location chosen on the report.
     */
    public function orders(?string $context = null, mixed $menuId = null): void
    {
        $this->menuId = (int)$menuId;
        $menuName = Menu::find($this->menuId)?->menu_name
            ?? ItemSale::query()->where('menu_id', $this->menuId)->value('name')
            ?? lang('cupnoodles.itemsales::default.text_deleted_item');

        $title = sprintf(lang('cupnoodles.itemsales::default.text_orders_title'), $menuName);
        Template::setTitle($title);
        Template::setHeading($title);
        AdminMenu::setPreviousUrl('cupnoodles/itemsales/item_sales');

        $this->asExtension(ListController::class)->makeLists();

        // Use the report's date filter so the order list matches the row that was clicked
        $reportFilter = $this->widgets['list_filter'] ?? null;
        $this->getListWidget('orders')->addFilter(function($query) use ($reportFilter): void {
            $reportFilter?->applyAllScopesToQuery($query);
        });
    }

    /**
     * Open the report on today's sales. Only on a page load, so a date filter cleared by the
     * admin stays cleared until they come back to the page.
     */
    public function listFilterExtendScopes($filter, $scopes): void
    {
        if (!request()->ajax() && is_null($filter->getScopeValue('date'))) {
            $filter->setScopeValue('date', [now()->toDateString(), now()->toDateString()]);
        }
    }

    public function listExtendQuery($query, $alias): void
    {
        $query->join('orders', 'orders.order_id', '=', 'order_menus.order_id')
            ->where('orders.status_id', '>', 0)
            ->where('orders.status_id', '!=', (int)Settings::get('canceled_order_status'));

        if ($locationIds = LocationFacade::currentOrAssigned()) {
            $query->whereIn('orders.location_id', $locationIds);
        }

        if ($alias === 'orders') {
            $query->where('order_menus.menu_id', $this->menuId)->with('order');

            return;
        }

        // One row per item. Replaces the list's select so only grouped and aggregate columns are
        // selected, which also works on MySQL with ONLY_FULL_GROUP_BY.
        $query->select([
            'order_menus.menu_id',
            DB::raw('MAX('.DB::getTablePrefix().'order_menus.name) as name'),
            DB::raw('COUNT(DISTINCT '.DB::getTablePrefix().'order_menus.order_id) as number_of_orders'),
            DB::raw('SUM('.DB::getTablePrefix().'order_menus.quantity) as quantity_sold'),
            DB::raw('SUM('.DB::getTablePrefix().'order_menus.subtotal) as revenue'),
        ])->groupBy('order_menus.menu_id');
    }
}
