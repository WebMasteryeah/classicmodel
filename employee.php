<?php

class Employee {
    public $id;            
    public $employeeNo;     
    public $lastName;
    public $firstName;
    public $extension;
    public $email;
    public $officeId;
    public $reportsTo;
    public $jobTitle;

    /** Constructor for an employee.
     *  Used only to construct an empty Student object.
     */
    public function __construct() {
    }


    // Construct a student object, write it to DB and return it.
    public static function create($employeeNo, $lastName, $firstName, $extension,
            $email, $officeId, $reportsTo, $jobTitle) {
        global $DB;
        $employee = new Employee();
        unset($stud->id);  // Not defined yet. Leave that to DB
        $employee->employeeNo = $studentNo;
        $employee->lastName = $username;
        $employee->firstName = $firstName;
        $employee->extension = $lastName;
        $employee->email = $address1;
        $employee->officeId = $address2;  // Ignore possibility it's NULL. [Hack]
        $employee->jobTitle = $jobTitle;
        
        $fields = $stud->makeSetString();
        $query = "INSERT INTO Ass1_Employees $fields";
        $result = $DB->query($query);
        Employee::checkResult($result);
        return $employee;
    }


    /*
     * Return a Student object read from the database for the given student.
     * Throws an exception if no such student exists in the database.
     */
    public static function read($employeeNo) {
        global $DB;
        $employee = new Employee();
        $sql = "SELECT * FROM Ass1_Employees WHERE employeeNumber='$employeeNo'";
        $result = $DB->query($sql);
        Employee::checkResult($result);
        if ($result->num_rows !== 1) {
            return 0;
            //throw new Exception("Employee $employeeNo not found in database");
        }

        // Copy all database column values into this.
        $row = $result->fetch_array(MYSQLI_ASSOC);
        foreach ($row as $field => $value) {
            $employee->$field = $value;
        }
        return $employee;
    }


    /*
     * Writes this student to the database.
     */
    public function update() {
        global $DB;  
        $fields = $this->makeSetString();
        $query = "UPDATE Ass1_Employees $fields WHERE id = {$this->id}";
        $result = $DB->query($query);
        Employee::checkResult($result);
    }

    /*
     * Return true if the given username exists in the students table
     * of the database.
     */
    public static function exists($employeeNo) {
        global $DB;
        $sql = "select employeeNumber from Ass1_Employees where employeeNumber='$employeeNo'";
        $result = $DB->query($sql);
        Employee::checkResult($result);
        return $result->num_rows === 1;
    }
    
    public static function existsId($employeeEmail) {
        global $DB;
        $sql = "select email from Ass1_Employees where email='$employeeEmail'";
        $result = $DB->query($sql);
        Employee::checkResult($result);
        return $result->num_rows === 1;
    }

    // ============== Private support methods follow ============

    // Build a string of "SET field='value', ..." for all existing object
    // attributes (except id). Doing it this way makes it easy to add
    // attributes, without having to update all the database queries.
    private function makeSetString() {
        global $DB;
        $s = "SET ";
        $separator = '';
        foreach ($this as $name=>$value) {
            if ($name !== 'id') {  // Don't try updating id!
                $escapedValue = $DB->escape_string($value);
                $s .= $separator . "$name='$escapedValue'";
                $separator = ',';  // ',' for all except first
            }
        }
        return $s;
    }

    // Check that the result from a DB query was OK
    private static function checkResult($result) {
        global $DB;
        if (!$result) {
            die("DB error ({$DB->error})");
        }
    }
};
