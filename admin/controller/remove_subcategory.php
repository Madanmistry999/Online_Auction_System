<?php
    include '../../config/connect.php';

    $cid=$_GET['c_id'];
    $subcategory=$_GET['subcategory'];

    $sql=mysqli_query($con,"DELETE from item_subcategory WHERE c_id='$cid' AND subcategory_name='$subcategory'");

    if($sql){
        header('location:../index.php');
    }
    else{
        echo "error";
    }
?>