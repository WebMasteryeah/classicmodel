<?php

require_once('dbinit.php');
require_once('product.php');
require_once('productline.php');

function comboBoxHtml($label, $map, $selectedRowId) {
    $html = "<select id='$label' name='$label' size='14'>";
    foreach ($map as $id => $name) {
        if ($id === intval($selectedRowId)) {
            $selected = 'selected';
        } else {
            $selected = '';
        }
        $html .= "<option value='$id' $selected>$name</option>\n";
    }
    $html .= "</select>";
    return $html;
}

// MAIN CODE BODY STARTS HERE

$isReload = isset($_GET['ProductLine']) && isset($_GET['Product']);
$ischanged = isset($_GET['whatChanged']);

$pLineQuery = 'select id, productLine from Ass1_ProductLines';
$pLineMap = Productline::listAll();

if ($isReload) {
    $pLineId = $_GET['ProductLine'];
} else {
    $keyL = array_keys($pLineMap);
    $pLineId = array_shift($keyL);
}

$productMap = Product::listAll($pLineId);

if ($isReload) {
    $prodId = $_GET['Product'];
}
else {
    $keyP = array_keys($productMap);
    $prodId = array_shift($keyP);
}
if($ischanged){
    if($_GET['whatChanged']  == 'ProductLine'){
        $keyP = array_keys($productMap);
        $prodId = array_shift($keyP);
    }
};

$product = Product::read($prodId);
$productLine = Productline::read($pLineId);

?>
    <link rel="stylesheet" type="text/css" href="product.css">
        <div id="container">
            <div id="content">
                <h1>Classic Models: Products</h1>

                <form id="browser-form" action="classicModel_view.php" method="get">
                    <h3>&nbsp;Product Lines&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Products<br>
                    <?php echo comboBoxHtml('ProductLine', $pLineMap, $pLineId);?>
                    <?php echo comboBoxHtml('Product', $productMap, $prodId);?>
                    </h3>
                    
                    <h2>Selected Product</h2>
                    <table id='ProductDetails'>
                        <tr>
                            <td>Product Code</td>
                            <td><?php echo $product->productCode; ?></td>
                        </tr>
                        <tr>
                            <td>Product Name</td>
                            <td><?php echo $product->productName; ?></td>
                        </tr>
                        <tr>
                            <td>Product Line</td>
                            <td><?php echo $productLine->productLine; ?></td>
                        </tr>
                        <tr>
                            <td>Product Scale</td>
                            <td><?php echo $product->productScale; ?></td>
                        </tr>
                        <tr>
                            <td>Product Vendor</td>
                            <td><?php echo $product->productVendor; ?></td>
                        </tr>
                        <tr>
                            <td>Product Description</td>
                            <td><?php echo $product->productDescription; ?></td>
                        </tr>
                        <tr>
                            <td>Quantity In Stock</td>
                            <td><?php echo $product->quantityInStock; ?></td>
                        </tr>
                        <tr>
                            <td>Buy Price</td>
                            <td><?php echo $product->buyPrice; ?></td>
                        </tr>
                        <tr>
                            <td>MSRP</td>
                            <td><?php echo $product->mSRP; ?></td>
                        </tr>
                    </table>

                    <div>
                        <input type='hidden' id='whatChanged' name='whatChanged' />
                    </div>
                    <script src="classicModel.js" ></script>
                </form>
            </div>

