<?php
    session_start();

    include '../config/connect.php';
    require 'db_operations/auction_close.php';

    $uid=$_SESSION['u_id'];


    if(empty($uid)){
        header('location:../index.php');
    }
 

    $qry=mysqli_query($con,"SELECT * from users WHERE u_id='{$uid}'");


    //condition if user is unverified user or image is not uploadded by user
    if(mysqli_num_rows($qry) > 0){



        $row=mysqli_fetch_assoc($qry);

        if($row){


            if($row['verification'] == 'Unverified'){

                echo "Not Verified Email Address....!!!";
                header('location:../verify.php');
            }
            else{

                $imgs=mysqli_query($con,"SELECT * from users_imgs WHERE u_id='$uid'");
    
                $res=mysqli_num_rows($imgs);
    
                if(empty($res)){
    
                    $_SESSION['u_id']=$uid;
            
                    header('location:imageupload.php');

                }
                else{

                    if($res > 0){

                        $row1=mysqli_fetch_assoc($imgs);

                    }

                }
           
            }
        }
        
    }

    $disp2=mysqli_fetch_assoc($qry);

    $sql=mysqli_query($con,"SELECT  products.p_id,products.product_name,products.price,products.confirm,product_imgs.product_imgs,auction.end_time,auction.auction_status FROM products INNER JOIN product_imgs on products.p_id=product_imgs.p_id INNER JOIN auction on products.p_id=auction.p_id Where owner !='$uid' AND auction_status='active' GROUP BY p_id ORDER BY rand() LIMIT 3");

    $qry=mysqli_query($con,"SELECT * from users,state where u_id='$uid' and users.pincode=state.pincode");
	$imgs1=mysqli_query($con,"SELECT * from users_imgs where u_id='$uid'");
    $row=mysqli_fetch_assoc($qry);
    $row_img=mysqli_fetch_assoc($imgs1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONLINE AUCTION</title>

    <link rel="website icon" type='png' href="images/logo.png"/>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- swiper css link  -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- cusom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    
<!-- header section starts  -->

<header class="header">

    <a href="index.php" class="logo">
        <table>
            <tr>
                <td><image src="images/logo.png" /></td>
                <td><span>ONLINE AUCTION</span></td>
            </tr>
        </table>
    </a>

    <table class="button-header">

        <tr>

            <td>
                <div class="icons">
                    <div id="menu-btn" class="fas fa-bars"></div>
                </div>
            </td>

            <td>

            <ul>
                
                <!-- <li><a href="#">Update</a></li> -->
                <li>

                    <a>
                        <img src="<?php echo 'data:image;base64,'.base64_encode($row_img['profile_pic']).''?>" />

                        <?php echo $row['name'];?>
                    </a>
                    <ul class="dropdown">
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="db_operations/logout.php?logout_id=<?php echo $uid;?>">Log out</a></li>
                    </ul>
                </li>
            </ul>

            

            </td>

        </tr>

    </table>


</header>

<!-- header section ends -->

<!-- side-bar section starts -->

<div class="side-bar">

    <div id="close-side-bar" class="fas fa-times"></div>

    <div class="user">
        <img src="<?php echo 'data:image;base64,'.base64_encode($row_img['profile_pic']).''?>" height="100" width="100" />'
        <h3><?php echo $row['name'];?></h3>
        <!-- <a href="db_operations/logout.php?logout_id=<?php// echo $uid;?>">log out</a> -->
    </div>


    <nav class="navbar1">
        <a href="index.php"> <i class="fas fa-angle-right"></i> Home </a>
        <a href="auction.php"> <i class="fas fa-angle-right"></i> Auction </a>
        <a href="bids.php"> <i class="fas fa-angle-right"></i> Bids </a>
        <a href="product_history.php"> <i class="fas fa-angle-right"></i>History </a>
        <a href="complaint.php"> <i class="fas fa-angle-right"></i> Complaint</a>
        <a href="profile.php"> <i class="fas fa-angle-right"></i> Profile</a>
    </nav>

</div>

<!-- side-bar section ends -->

<!-- home section starts  -->

<section class="home">

    <h1 id="message_display" style="display:none;">Welcome to the Online Auction <?php echo $row['name']; ?>. Enjoy Bidding.....!</h1>
    
    
   
    <div class="swiper home-slider">

        <div class="swiper-wrapper">

        <?php

            if(mysqli_num_rows($sql) > 0){

                $data=mysqli_fetch_assoc($sql);


                $pid=$data['p_id'];

                //fetching product images
                $p_img=mysqli_query($con,"SELECT product_imgs from product_imgs where p_id='$pid'");

                $disp=mysqli_fetch_assoc($p_img);
        ?>

            <div class="swiper-slide slide">
                <div class="image">
                    <img src="<?php echo 'data:image;base64,'.base64_encode($disp['product_imgs']).''?>" alt="">
                </div>
                <div class="content">
                    
                    <h3><?php echo $data['product_name']; ?></h3>
                    <h4>Price:-<?php echo number_format($data['price']); ?></h4>

                    <?php
                        $enddate=$data['end_time'];

                        $enddate_format=date("d/m/Y h:i:sa", strtotime($enddate));
                    ?>

                    <h4>Auction End Date: <?php echo $enddate_format;?></h4>
                    <a href="product_detail.php?p_id=<?php echo $pid; ?>" class="btn">View Deatail</a>
                </div>
            </div>
        
        <?php
            }
        ?>

        </div>

    </div>

</section>

<!-- home section ends -->


<section class="arrivals">

    <div class="box-container">

    <?php

        if(mysqli_num_rows($sql) > 0){

            while($data=mysqli_fetch_assoc($sql)){

            $pid=$data['p_id'];

            $p_img=mysqli_query($con,"SELECT product_imgs from product_imgs where p_id='$pid'");

            $disp=mysqli_fetch_assoc($p_img);
    ?>


        <div class="box">
            <div class="image">
                <img src="<?php echo 'data:image;base64,'.base64_encode($disp['product_imgs']).''?>" class="main-img" alt="">
                <img src="<?php echo 'data:image;base64,'.base64_encode($disp['product_imgs']).''?>" class="hover-img" alt="">
            </div>
            <div class="content">
                <h3><?php echo $data['product_name']; ?></h3>
                <div class="price">Price:- <?php echo number_format($data['price']); ?></div>

                
                <?php
                    $enddate=$data['end_time'];

                    $end=date("d/m/Y h:i:sa", strtotime($enddate));
                ?>

                <div class="price"> Auction End Date:-<?php echo $end; ?></div>
                <br><br>
                <a href="product_detail.php?p_id=<?php echo $pid; ?>"> <button>View Detail</button> </a>
                
            </div>
        </div>

    <?php
            }
        
        }
        else{
            echo "djdkkkd";
            echo "djdkkkd";
        }
    
    ?>

    </div>

</section>

<!-- arrivals section ends -->

<!-- footer section starts  -->
<section class="credit" align="center">
    <p> created by <span>TYBCA Student</span> | all rights reserved! </p>
</section>
<!-- footer section ends -->




<!-- swiper js link      -->
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        //When the page has loaded.
        $( document ).ready(function(){
            $('#message_display').fadeIn('slow', function(){
            $('#message_display').delay(5000).fadeOut(); 
            });
        });
    </script>

</body>
</html>