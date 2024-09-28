<?php 
    include 'dbcon.php';

    if(isset($_GET['order_id'])){
        $order_id = $_GET['order_id'];

        $cancel = "UPDATE `orders` SET `status`='return' WHERE order_id = '$order_id'";

        if (!mysqli_query($connection, $cancel)) {
            echo "<script>alert('Return Failed!'); 
            window.location.href='mypurchase.php';
            </script>";
        }else{
            // Redirect to order confirmation page
            echo "<script>alert('You successfully return your order!'); 
            window.location.href='mypurchase.php';</script>";
            exit;
        }
    
        

    }

    



?>