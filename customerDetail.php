<?php

header("Content-type: application/xml; charset=utf-8");

require_once('dbinit.php'); 
require_once('customer.php');

$cust = Customer::read($_GET['customerId']);
?>
    
<!DOCTYPE customer >
<customerDetail>
    <customer>
        <id><?php echo $cust->id; ?></id>
        <customerNo><?php echo $cust->customerNumber; ?></customerNo>
        <customerName><?php echo preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $cust->customerName); ?></customerName>
        <contactLastName><?php echo $cust->contactLastName; ?></contactLastName>
        <contactFirstName><?php echo $cust->contactFirstName; ?></contactFirstName>
        <phone><?php echo $cust->phone; ?></phone>
        <address1><?php echo $cust->addressLine1; ?></address1>
        <address2><?php echo $cust->addressLine2; ?></address2>
        <city><?php echo $cust->city; ?></city>
        <state><?php echo $cust->state; ?></state>
        <postalCode><?php echo $cust->postalCode; ?></postalCode>
        <country><?php echo $cust->country; ?></country>
        <salesRepNo><?php echo $cust->salesRepNumber; ?></salesRepNo>
        <creditLimit><?php echo $cust->creditLimit; ?></creditLimit>
    </customer>
</customerDetail>


