<?php

include 'config.php';
if(isset($_GET['delete'])){
    $delete_id=$_GET['delete'];
    $delete_query=mysqli_query($conn,"Delete from `orders` where id=$delete_id") or
    die("Query failed");

    if($delete_query){
        echo "Product deleted";
        header('location:orders.php');
    }else{
        echo "Product Not deleted";
        header('location:orders.php');
    }
}

?>