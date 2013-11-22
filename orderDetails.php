<?php

header("Content-type: application/xml; charset=utf-8");

require_once('dbinit.php');
require_once('orderDetail.php');

$orderD = OrderDetail::read($_GET['moreId']);
?>

<!DOCTYPE moreDetail>
<moreDetail>
	<id><?php echo $orderD->id; ?></id>
	<orderId><?php echo $orderD->orderId; ?></orderId>
	<productId><?php echo $orderD->productId; ?></productId>
	<quantityOrdered><?php echo $orderD->quantityOrdered; ?></quantityOrdered>
	<priceEach><?php echo $orderD->priceEach; ?></priceEach>
	<orderLineNo><?php echo $orderD->orderLineNumber; ?></orderLineNo>
</moreDetail>


