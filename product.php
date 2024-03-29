<?php
/*
 * Declare the Product class, representing a row of the products table.
 * Since the database was imported from elsewhere and has capital letters
 * at the start of each field name, an internal tweak is used to convert
 * column names to php lower-case-first format.
 */
class Product {
    public $id;
    public $productCode;
    public $productName;
    public $productLineId;
    public $productScale;
    public $productVendor;
    public $productDescription;
    public $quantityInStock;
    public $buyPrice;
    public $msrp;
    
    /*
     * Return a Product object read from the database for the given product.
     * Throws an exception if no such product exists in the database.
     */
    public static function read($id) {
        global $DB;
        $prod = new Product();
        $sql = "SELECT * FROM Ass1_Products WHERE Id='$id'";
        $result = $DB->query($sql);
        Product::checkResult($result);
        if ($result->num_rows !== 1) {
            throw new Exception("Product ID $id not found in database");
        }

        $prod->load($result->fetch_array(MYSQLI_ASSOC));
        return $prod;
    }


    /** Return an associative array id=>productName for all products in the
     *  database, or all matching a given categoryId (if given).
     * @global mysqli $DB
     * @param int $lindId
     * @return associative array mapping productLineId to product
     */
    public static function listAll($lindId=NULL) {
        global $DB;
        $sql = "SELECT Id as id, ProductName as productName FROM Ass1_Products";
        if ($lindId) {
            $sql .= " WHERE productLineId = '$lindId' ORDER BY ProductName";
        }
        $result = $DB->query($sql);
        Product::checkResult($result);
        $list = array();
        while (($row = $result->fetch_object()) !== NULL) {
            $list[$row->id] = $row->productName;
        }
        return $list;
    }


    /** Return an array of all products in the database, for use by
     *  classModel.
     * @global mysqli $DB
     * @return an array of Product objects containing all products, ordered
     * by product name.
     */
    public static function getAllProducts() {
        global $DB;
        $sql = "SELECT * FROM Ass1_Products ORDER BY ProductName";
        $result = $DB->query($sql);
        Product::checkResult($result);
        $list = array();
        while (($row = $result->fetch_array(MYSQLI_ASSOC)) !== NULL) {
            $prod = new Product();
            $prod->load($row);
            $list[] = $row;
        }
        return $list;
    }


    // Given a row from the database, copy all database column values
    // into 'this', converting column names to fields names by converting
    // first char to lower case.
    private function load($row) {
        foreach ($row as $field => $value) {
            $fieldName = strtolower($field[0]) . substr($field, 1);
            $this->$fieldName = $value;
        }
    }


    // Check that the result from a DB query was OK
    private static function checkResult($result) {
        global $DB;
        if (!$result) {
            die("DB error ({$DB->error})");
        }
    }
};


