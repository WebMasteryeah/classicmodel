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
class Customer {
    public $id;
    public $customerNumber;
    public $customerName;
    public $contactLastName;
    public $contactFirstName;
    public $phone;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $postalCode;
    public $country;
    public $salesRepNumber;
    public $creditLimit;
    
    
    /*
     * Return a Product object read from the database for the given product.
     * Throws an exception if no such product exists in the database.
     */
    public static function read($customerNumber) {
        global $DB;
        $customer = new Customer();
        $sql = "SELECT * FROM Ass1_Customers WHERE Id='$customerNumber'";
        $result = $DB->query($sql);
        Customer::checkResult($result);
        if ($result->num_rows !== 1) {
            throw new Exception("CustomerID $id not found in database");
        }

        $customer->load($result->fetch_array(MYSQLI_ASSOC));
        return $customer;
    }

    /** Return a list of customerName
     */
    public static function listAll() {
        global $DB;
        $sql = "SELECT Id as id, CustomerName as customerName FROM Ass1_Customers";
        $result = $DB->query($sql);
        Customer::checkResult($result);
        $list = array();
        while (($row = $result->fetch_object()) !== NULL) {
            $list[$row->id] = $row->customerName;
        }
        return $list;
    }


    /** Return an array of all customer's names
     * 
     */
    public static function getAllCustomers() {
        global $DB;
        $sql = "SELECT * FROM Ass1_Customers ORDER BY customerNumber";
        $result = $DB->query($sql);
        Customer::checkResult($result);
        $list = array();
        while (($row = $result->fetch_array(MYSQLI_ASSOC)) !== NULL) {
            $customer = new Customer();
            $customer->load($row);
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


