<?php

header("Content-type: application/xml; charset=utf-8");

require_once('dbinit.php');
require_once('order.php');

if (!isset($_GET['orderId']) || !is_numeric($orderId = $_GET['orderId'])) {
    die("Bad parameter");
}

$orders = Order::getAllOrders($_GET['orderId']);
?>
<!DOCTYPE orderList >
<orderList>
    <?php
    // Load the orders for the given customerId into the table
    foreach ($orders as $order) {
        ?>
        <order>
            <id><?php echo $order->id; ?></id>
            <name><?php echo $order->orderNumber; ?></name>
		</order>
        <?php
    }
    ?>
</orderList>


