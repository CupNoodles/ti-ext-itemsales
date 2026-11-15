<?php

declare(strict_types=1);

namespace CupNoodles\ItemSales\Models;

use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Model;

/**
 * A sold order line (order_menus), used read-only by the Item Sales report.
 *
 * Quantities are summed and formatted without assuming whole numbers, so items sold by weight
 * (decimal quantities) report correctly.
 *
 * @property int $order_menu_id
 * @property int $order_id
 * @property int $menu_id
 * @property string $name
 * @property int|float $quantity
 * @property float $subtotal
 * @property-read Order|null $order
 */
class ItemSale extends Model
{
    protected $table = 'order_menus';

    protected $primaryKey = 'order_menu_id';

    public $timestamps = false;

    public $relation = [
        'belongsTo' => [
            'order' => [Order::class, 'foreignKey' => 'order_id'],
            'menu' => [Menu::class, 'foreignKey' => 'menu_id'],
        ],
    ];

    /**
     * 3, 2.5 or 0.125, without trailing zeros.
     */
    public static function formatQuantity(mixed $quantity): string
    {
        $formatted = number_format((float)$quantity, 3, '.', ',');

        return rtrim(rtrim($formatted, '0'), '.');
    }
}
