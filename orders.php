<?php

require_once('dbinit.php');
require_once('customer.php');
require_once('order.php');
require_once('orderDetail.php');

function comboBoxHtml($label, $map, $selectedRowId) {
    $html = "<select id='$label' name='$label'>";
    foreach ($map as $id => $name) {
        $selected = $id === intval($selectedRowId) ? 'selected' : '';
        $html .= "<option value='$id' $selected>$name</option>\n";
    }
    $html .= "</select>\n</p>";
    return $html;
}

// Get a map for all customers.
$customerMap = Customer::listAll();

// The currently selected customer is just the first customer in the first list
$customerIds = array_keys($customerMap);
$customerId = $customerIds[0]; 
$customer = Customer::read($customerId);

// Get a map for all orders which related to the selected customer.
$orderMap = Order::listAll($customerId);

// The currently selected order is just the first order in the first list
$orderIds = array_keys($orderMap);
$orderId = $orderIds[0]; 
$order = Order::read($orderId);
 
$orderDetailMap = OrderDetail::listAll($orderId);

$orderDetailIds = array_keys($orderDetailMap);
$orderDetailId = $orderDetailIds[0]; 
$orderDetail = OrderDetail::read($orderDetailId);

// =========== THE MAIN FORM =================
?>
    

    <link rel="stylesheet" type="text/css" href="orders.css">
        <div id="container">
            <div id="content">
                <h1>Order Details</h1>
                
                <p><?php echo 'Customer Name:'.comboBoxHtml('CustomerName', $customerMap, $customerId); ?></p>
                <p><?php echo 'Order Number:'.comboBoxHtml('OrderNumber', $orderMap, $orderId); ?></p>
                <p><?php echo 'Ordered Product:'.comboBoxHtml('OrderedProduct', $orderDetailMap, $orderDetailId); ?></p>
                
                <table id='CustomerDetails'>
                    <!-- Customers -->
                    <tr>
                        <td>Customer Name</td>
                        <td><?php echo $customer->customerName; ?></td>
                    </tr>
                    <!-- Orders -->
                    <tr>
                        <td>Order Number</td>
                        <td><?php echo $order->orderNumber; ?></td>
                    </tr>
                    <tr>
                        <td>Order Date</td>
                        <td><?php echo $order->orderDate; ?></td>
                    </tr>
                    <tr>
                        <td>Shipped Date</td>
                        <td><?php echo $order->shippedDate; ?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><?php echo $order->status; ?></td>
                    </tr>
                    <tr>
                        <td>Product Id</td>
                        <td><?php echo $orderDetail->productId; ?></td>
                    </tr>
                    <tr>
                        <td>Quantity Ordered</td>
                        <td><?php echo $orderDetail->quantityOrdered; ?></td>
                    </tr>
                    <tr>
                        <td>Price Each</td>
                        <td><?php echo $orderDetail->priceEach; ?></td>
                    </tr>
                </table>

                <script type='text/javascript' src="orders.js" ></script>
            </div>

