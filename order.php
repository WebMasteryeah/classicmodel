<?php
/*
 * Declare the Product class, representing a row of the products table.
 * Since the database was imported from elsewhere and has capital letters
 * at the start of each field name, an internal tweak is used to convert
 * column names to php lower-case-first format.
 *
 * Implements only the Read function, since we're just implementing a product
 * browser, plus a listAll function that returns a map from productID to
 * productName for all products in the database.
 *
 * This class requires that a global mysqli variable $DB exists.
 */
class Order {
    public $id;
    public $orderNumber;
    public $orderDate;
    public $requiredDate;
    public $shippedDate;
    public $status;
    public $comments;
    public $customerId;
    
    /*
     * Return a Product object read from the database for the given product.
     * Throws an exception if no such product exists in the database.
     */
    public static function read($id) {
        global $DB;
        $order = new Order();
        $sql = "SELECT * FROM Ass1_Orders WHERE Id='$id'";
        $result = $DB->query($sql);
        Order::checkResult($result);
        if ($result->num_rows !== 1) {
            throw new Exception("Order ID $id not found in database");
        }

        $order->load($result->fetch_array(MYSQLI_ASSOC));
        return $order;
    }
    
    /** Return an associative array id=>productName for all products in the
     *  database, or all matching a given categoryId (if given).
     * @global mysqli $DB
     * @param int $catId
     * @return associative array mapping productId to product
     */
    public static function listAll($custid=NULL) {
        global $DB;
        $sql = "SELECT id as id, orderNumber as orderNumber FROM Ass1_Orders";
        if ($custid) {
            $sql .= " WHERE customerId = '$custid'";
        }
        $result = $DB->query($sql);
        Order::checkResult($result);
        $list = array();
        while (($row = $result->fetch_object()) !== NULL) {
            $list[$row->id] = $row->orderNumber;
        }
        return $list;
    }


    /** Return an array of all products in the database, for use by
     *  nwproductBrowser3.
     * @global mysqli $DB
     * @return an array of Product objects containing all products, ordered
     * by name.
     */
    public static function getAllOrders($orderId=NULL) {
        global $DB;
        $sql = "SELECT * FROM Ass1_Orders";
        if ($orderId) {
            $sql .= " WHERE customerId='$orderId'";
        }
        $sql .= " ORDER BY customerId";
        $result = $DB->query($sql);
        Order::checkResult($result);
        $list = array();
        while (($row = $result->fetch_array(MYSQLI_ASSOC)) !== NULL) {
            $prod = new Order();
            $prod->load($row);
            $list[] = $prod;
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



