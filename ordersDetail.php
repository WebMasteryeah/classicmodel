<?php

header("Content-type: application/xml; charset=utf-8");

require_once('dbinit.php');
require_once('order.php');

if (!isset($_GET['orderId']) || !is_numeric($proId = $_GET['orderId'])) {
    die("Bad parameter");
}

$orderD = Order::read($_GET['orderId']);
?>

<!DOCTYPE orders>
<order>
    <id><?php echo $orderD->id; ?></id>
    <orderNumber><?php echo $orderD->orderNumber; ?></orderNumber>
    <orderDate><?php echo $orderD->orderDate; ?></orderDate>
    <requiredDate><?php echo $orderD->requiredDate; ?></requiredDate>
    <shippedDate><?php echo $orderD->shippedDate; ?></shippedDate>
    <status><?php echo $orderD->status; ?></status>
    <comments><?php echo $orderD->comments; ?></comments>
    <customerId><?php echo $orderD->customerId; ?></customerId>
</order>
