<?php
if(isset($_GET['user'])){
    $name = $_GET['user'];
}
else{
    $name = 'Visitor';
}
?>
            
            <p>Welcome <?php echo $name; ?>
            <a href="logout.php">Logout</a></p>
