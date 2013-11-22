<?php
if(isset($_GET['user'])){
    session_start();
    $name = $_GET['user'];
}
else{
    $name = 'Visitor';
}
?>
        <div>
            <nav style="text-align:center">
                <?php echo "<a href='home_view.php?user=$name'> Home </a> | ";
                echo "<a href='customers_view.php?user=$name'> Customers </a> | ";
                echo "<a href='classicModel_view.php?user=$name'> Products </a> | ";
                echo "<a href='orders_view.php?user=$name'> Orders </a> | ";
                echo "<a href='about_view.php?user=$name'> About this site </a>"; ?>
            </nav>
        </div>
        <div>
            <p style="text-align:center">Welcome <?php echo $name; ?>
            <a href="logout.php">Logout</a></p>
        </div>
