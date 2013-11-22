<?php
/*
 * Declare the Productline class, representing a row of the ProductLine table.
 *
 */
class Productline {
    public $id;
    public $productLine;
    public $description;

    /*
     * Return a Category object read from the database for the given category.
     * Throws an exception if no such product exists in the database.
     */
    public static function read($id) {
        global $DB;
        $prod = new Productline();
        $sql = "SELECT * FROM Ass1_ProductLines WHERE Id='$id'";
        $result = $DB->query($sql);
        Productline::checkResult($result);
        if ($result->num_rows !== 1) {
            throw new Exception("Product ID $id not found in database");
        }

        // Copy all database column values into this, converting column names
        // to fields names by converting first char to lower case.
        $row = $result->fetch_array(MYSQLI_ASSOC);
        foreach ($row as $field => $value) {
            $fieldName = strtolower($field[0]) . substr($field, 1);
            $prod->$fieldName = $value;
        }
        return $prod;
    }



    public static function listAll() {
        global $DB;
        $sql = "SELECT Id, productLine FROM Ass1_ProductLines ORDER BY productLine";
        $result = $DB->query($sql);
        Productline::checkResult($result);
        $list = array();
        while ($row = $result->fetch_object()) {
            $list[$row->Id] = $row->productLine;
        }
        return $list;
    }



    // Check that the result from a DB query was OK
    private static function checkResult($result) {
        global $DB;
        if (!$result) {
            die("DB error ({$DB->error})");
        }
    }
};

