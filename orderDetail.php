<?php
/*
 * Declare the OrderDetail class, representing some part of the order detail table.
 * Since the database was imported from elsewhere and has capital letters
 * at the start of each field name, an internal tweak is used to convert
 * column names to php lower-case-first format.
 */
class OrderDetail {
    public $id;
    public $orderId;
    public $productId;
    public $quantityOrdered;
    public $priceEach;
    public $orderLineNumber;
    
    /*
     * Return a Product object read from the database for the given product.
     * Throws an exception if no such product exists in the database.
     */
    public static function read($id) {
        global $DB;
        $order = new OrderDetail();
        $sql = "SELECT * FROM Ass1_OrderDetails WHERE Id='$id'";
        $result = $DB->query($sql);
        OrderDetail::checkResult($result);
        if ($result->num_rows !== 1) {
            throw new Exception("OrderDetail ID $idd not found in database");
        }

        $order->load($result->fetch_array(MYSQLI_ASSOC));
        return $order;
    }


    /** Return an associative array id=>productName for all products in the
     *  database, or all matching a given categoryId (if given).
     * @global mysqli $DB
     * @param int $orderId
     * @return associative array mapping orderId to Order detail
     */
    public static function listAll($orderId=NULL) {
        global $DB;
        $sql = "SELECT id as id, productId as productId FROM Ass1_OrderDetails";
        if ($orderId) {
            $sql .= " WHERE orderId = '$orderId'";
        }
        $result = $DB->query($sql);
        OrderDetail::checkResult($result);
        $list = array();
        while (($row = $result->fetch_object()) !== NULL) {
            $list[$row->id] = $row->productId;
        }
        return $list;
    }


    /** Return an array of all order details in the database, for use by
     *  Orders browser.
     * @global mysqli $DB
     * @return an array of OrderDetail objects containing all order details
     */
    public static function getAllOrderDetails($dtailId=NULL) {
        global $DB;
        $sql = "SELECT * FROM Ass1_OrderDetails";
        if ($orderId) {
            $sql .= " WHERE orderId='$dtailId'";
        }
        $sql .= " ORDER BY orderId";
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



