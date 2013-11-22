<?php

header("Content-type: application/xml; charset=utf-8");

require_once('dbinit.php');
require_once('orderDetail.php');

if (!isset($_GET['dtailId']) || !is_numeric($orderId = $_GET['dtailId'])) {
    die("Bad parameter");
}

$details = OrderDetail::getAllOrders($_GET['dtailId']);
?>
<!DOCTYPE detailList >
<detailList>
    <?php
    // Load the orders for the given customerId into the table
    foreach ($orders as $order) {
        ?>
        <detail>
            <id><?php echo $order->id; ?></id>
            <name><?php echo $order->orderNumber; ?></name>
		</detail>
        <?php
    }
    ?>
</detailList>



