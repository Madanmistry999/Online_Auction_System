<?php
    include "../../config/connect.php";

    $categoryid=$_POST['categories'];
    $category=$_POST['subcategory'];

    $fetch_category=mysqli_query($con,"SELECT * from item_subcategory where subcategory_name='$category'");

    if($fetch_category){

        if(isset($_REQUEST['subcategory'])){

            while($data=mysqli_fetch_assoc($fetch_category)){
                $subcategory_name[]=$data['subcategory_name'];
            }

            $notmatch=true;

            foreach($subcategory_name as $subcategory){

                if($subcategory == $category){
                    $notmatch=false;
                }

            }

            if($notmatch == false){

                if(isset($_REQUEST['subcategory'])){

                    ?>
                
                <script>
                alert('Subcategory name is Already Exist....!!!');
                location.href='../auctions.php';
                </script>
        
        <?php
                }
                
            }
            else if($notmatch == true){


                if(isset($_REQUEST['subcategory'])){

                    $sql=mysqli_query($con,"INSERT into item_subcategory VALUES ('$categoryid','$category')");

                    $category=null;

                    header('location:../auctions.php');
                }

            }

        }

    }else{

        ?>
                
        <script>
        alert('Data is not inserted....!!!');
        location.href='../auctions.php';
        </script>

<?php
    }

    // if(isset($_REQUEST['add_category'])){

    //     $sql=mysqli_query($con,"INSERT into item_category VALUES (null,'$category')");

    //     $category=null;

    //     header('location:../auctions.php');
    // }
?>