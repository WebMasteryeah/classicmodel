<?php

require_once('dbinit.php');
require_once('customer.php');

function comboBoxHtml($label, $map, $selectedRowId) {
    $html = "<select id='$label' name='$label'>";
    foreach ($map as $id => $name) {
        $selected = $id === intval($selectedRowId) ? 'selected' : '';
        $html .= "<option value='$id' $selected>$name</option>\n";
    }
    $html .= "</select>\n</p>";
    return $html;
}

// Get a map from ProductId to ProductName for all products in the current
// category, for use with the Product combo box.

$customerMap = Customer::listAll();

// The currently selected product is just the first product in the first category

$customerIds = array_keys($customerMap);
$customerId = $customerIds[0]; 
$customer = Customer::read($customerId);

$cName = $customer->customerName;

// =========== THE MAIN FORM =================
?>
    

    <link rel="stylesheet" type="text/css" href="home.css">
        <div id="container">
            <div id="content">
                <h1>Customer Details</h1>
                <p>Customer Name: <?php echo comboBoxHtml('Customer ID', $customerMap, $customerId); ?></p>
                <table id='CustomerDetails'>
                    <tr>
                        <td>Customer Name</td>
                        <td><?php echo $customer->customerName; ?></td>
                    </tr>
                    <tr>
                        <td>Contact Name</td>
                        <td><?php echo $customer->contactLastName,' ',$customer->contactFirstName; ?></td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td><?php echo $customer->phone; ?></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><?php echo $customer->addressLine1; ?></td>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td><?php echo $customer->city; ?></td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td><?php echo $customer->country; ?></td>
                    </tr>
                    <tr>
                        <td>Credti Limit</td>
                        <td><?php echo $customer->creditLimit; ?></td>
                    </tr>
                </table>

                <script type='text/javascript' src="home.js" ></script>
            </div>


