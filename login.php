<?php

    require_once('dbinit.php'); 
    require_once('employee.php');
    require_once('customer.php');
    
    // Format an array of error messages for HTML display
    function displayErrors($errorMessages) {
        $messageListHtml =
                '<p class="errormessage">' .
                implode('<br>', $errorMessages) .
                '</p>';
        return $messageListHtml;
    }
    
    /*
     * Check if given ID and password exist and match, returning an error message 
     * 
     */
    function getPWError($employeeId) {
        $error = '';
        if (!Employee::exists($employeeId)) {
            $error = "Password is incorrect";
        }
        return $error;
    }
    
    function getIDError($employeeEmail) {
        $error = '';
        if (!Employee::existsId($employeeEmail)) {
            $error = "Unknown user:".$employeeEmail;
        }
        return $error;
    }
    
    function checkError($employeeId, $employeeEmail){
        $error = '';
         $emp = Employee::read($employeeId);
         $email = $emp -> email;
        if ($email != $employeeEmail) {
            $error = "User Id or password is incorrect";
        }
        return $error;
    }
    
    $customers = Customer::getAllCustomers();

    //Check ID and Password
    $errorMessages = array();
    $successMessage = '';
    $employeeId = '';
    $employeeEmail = '';
    $submissionCount = 0;
    $user = '';
    $postback = isset($_POST['employeeEmail']);
    $password = isset($_POST['employeeId']) && isset($_POST['submit']);
    $employeeName = 'user';
    
    if ($postback) {
	
        $submissionCount = $_POST['submissioncount'];
        
        session_start();
        
        if (isset($_SESSION['employeeId'])) {
            $user = $_SESSION['employeeId'];
        }else {
            $user = 'visitor';
            $_SESSION['employeeId'] = $user;
        }
        
        $user = $_SESSION['employeeId'] = $_POST['employeeId'];
        
        if(!isset($_POST['employeeEmail']) || trim($_POST['employeeEmail']) == ''){
            $errorMessages[] = 'You must provide a Employee email address';
        }
        if (!isset($_POST['employeeId']) || trim($_POST['employeeId']) == '') {
            $errorMessages[] = 'You must provide a password';
        } 
        if(trim($_POST['employeeEmail']) != '' && trim($_POST['employeeId']) != ''){
            $employeeId = $_POST['employeeId'];
            $employeeEmail = $_POST['employeeEmail'];
            $employeeEmail = mysql_real_escape_string($employeeEmail);
            $employeeId = mysql_real_escape_string($employeeId);
            $errorP = getPWError($employeeId);
            $errorI = getIDError($employeeEmail);
            $errorW = checkError($employeeId, $employeeEmail);
            
            if ($errorP) {
                $errorMessages[] = $errorP;
            }
            if($errorI){
               $errorMessages[] = $errorI; 
            }
            if($errorW){
                $errorMessages[] = $errorW;
            }
            else{
                $employee = Employee::read($employeeId);
                $employeeName = $employee-> lastName;
            }
                        
        }
        
        if($submissionCount > 2){
            $errorMessages[] = 'You entered wrong ID or Password more than 3 times. 
            <br>Please phone our help desk, 0800 123 4567, if you need assistance.';
        }
    
        if (count($errorMessages) == 0) {
            header("Location: home_view.php?user=".$employeeName);
        }else{
            $submissionCount = $submissionCount+1;
        };
    }

    $DB->close();

?>

    <link rel="stylesheet" type="text/css" href="login.css">
        <div id="container">
            <div id="content">
                <?php
                if ($successMessage) {
                    
                }else { ?>
                    <form id="browser-form" action="index.php" method="post">
                        
                        <input type="hidden" name="submissioncount" value="<?php echo $submissionCount; ?>" >
                        
                        <p class="input">ID : <input type="text" name="employeeEmail" value="<?php echo $employeeEmail ?>">
                        Password : <input type="text" name="employeeId" value="<?php echo $employeeId ?>">
                        
                        <input type="submit" name="submit" value="Submit"></p>
                        <?php echo displayErrors($errorMessages); ?>
                        <p class="gate"><img src="gate.jpg" alt="door" width="900" height="530"></p>
                        
                    </form>

                <?php
                }?>
            </div>

