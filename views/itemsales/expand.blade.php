<table style="width: 100%" class="table-secondary">
    <thead>
        <tr>
            <th></th>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Order Date</th>
            <th>Order Time</th>
            <th>Qty Ordered</th>
        </tr>
    </thead>
    @foreach( $orders as $order )

    <tr>
        <td>
            <a class="btn btn-edit" href="{{ site_url('admin/orders/edit') . '/' .$order->order->order_id }}" data-original-title="" title="" style="padding: 0">
                    <i class="fa fa-pencil"></i>
            </a>
        </td>
        <td>
            {{ $order->order->order_id }}
        </td>
        <td>
            {{ $order->order->first_name }} {{ $order->order->last_name }}
        </td>
        <td>
            {{ date('M d, Y', strtotime($order->order->order_date)) }}
        </td>
        <td>
            {{ date('H:i', strtotime($order->order->order_time)) }}
        </td>
        <td>
            {{ str_replace('.00', '', number_format($order->quantity, 2)) }}
        </td>
    </tr>
    @endforeach
</table>
