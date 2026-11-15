# Item Sales for TastyIgniter

A sales report broken down by menu item. For each item it shows how many orders included it, the
quantity sold and the revenue, for the dates you choose. Click an item to see the orders behind it.

> Using TastyIgniter v3? Use the [`v3` branch](https://github.com/CupNoodles/ti-ext-itemsales/tree/v3).

## Requirements

- TastyIgniter v4 with the Cart and Local extensions (installed by default)

## Installation

### From GitHub (git clone)

From your TastyIgniter root folder, clone the extension into `extensions/cupnoodles/itemsales`. The
folder name matters: TastyIgniter finds extensions at `extensions/<vendor>/<name>`.

```bash
git clone https://github.com/CupNoodles/ti-ext-itemsales.git extensions/cupnoodles/itemsales
php artisan igniter:up
```

To update later:

```bash
cd extensions/cupnoodles/itemsales
git pull
cd ../../..
php artisan igniter:up
```

### With Composer, from GitHub

```bash
composer config repositories.cupnoodles-itemsales vcs https://github.com/CupNoodles/ti-ext-itemsales
composer require cupnoodles/ti-ext-itemsales:dev-master
php artisan igniter:up
```

Once a version is tagged, you can require `^4.0` instead of `dev-master`.

## Usage

Open **Item Sales** in the admin menu, below Orders. Staff need the "View the item sales report"
permission.

- The report opens on today's sales. Change the dates with the date filter, and search by item name.
- It covers the location selected in the admin header. With no location selected, admins see the
  locations they're assigned to, and super admins see all of them.
- Sort by any column, for example by revenue to see your best sellers.
- Click the list icon on a row to see that item's orders for the same dates.

Only placed orders are counted: abandoned checkouts and cancelled orders are left out, the same as
the dashboard's sales figures. Quantities are shown without trailing zeros, so items sold by weight
(eg. 2.5 kg) display correctly.

## Upgrading from v3

There's no data to migrate. Differences from v3:

- The location filter is replaced by the admin's location switcher, like the Orders list.
- Cancelled orders and abandoned checkouts are no longer counted.
- An item's orders open on their own page instead of expanding inside the table.
- The report has its own menu entry below Orders.

## License

MIT. See [LICENSE](LICENSE).
