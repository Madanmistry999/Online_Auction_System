<?php
    include "../../config/connect.php";

    $categoryname=$_POST['category'];
    // $status=$_POST['status'];
    
    $fetch_category=mysqli_query($con,"SELECT * from item_category");

    while($data=mysqli_fetch_assoc($fetch_category)){
        $category_name[]=$data['category_name'];
    }

    $notmatch=true;

    foreach($category_name as $category){

        if($categoryname == $category){
            $notmatch=false;
        }

    }

    if($notmatch == false){

        if(isset($_REQUEST['add_category'])){
            echo "Please Enter New Category";
            unset($_POST['category']);
            $_POST['category']=null;
        }
        
    }
    else if($notmatch == true){

        if(isset($_REQUEST['add_category'])){

            $sql=mysqli_query($con,"INSERT into item_category VALUES (null,'$categoryname')");

            $categoryname=null;

            header('location:../auctions.php');
        }

    }

?>