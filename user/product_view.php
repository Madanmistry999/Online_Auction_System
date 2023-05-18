<?php

session_start();

include '../config/connect.php';
require 'db_operations/auction_close.php';

$uid=$_SESSION['u_id'];

if(empty($uid)){
    header('location:../index.php');
}
else if(empty($_GET['p_id'])){
    header('location:product_history.php');
}

error_reporting(0);

$qry=mysqli_query($con,"SELECT * from users WHERE u_id='{$uid}'");

if(mysqli_num_rows($qry) > 0){

    $row=mysqli_fetch_assoc($qry);

    if($row){

        if($row['verification'] != 'Verified'){

            echo "Not Verified Email Address....!!!";
            header('location:../verify.php');
        }
        else{

            $imgs=mysqli_query($con,"SELECT * from users_imgs WHERE u_id='{$uid}'");


            $res=mysqli_num_rows($imgs);

            if(empty($res)){

                $_SESSION['u_id']=$uid;
        
                header('location:imageupload.php');
            }

            if($res > 0){
                $row1=mysqli_fetch_assoc($imgs);
            }
       
        }
    }
    
}

  $pid=$_GET['p_id'];

  //fetching product data
  $sql=mysqli_query($con,"SELECT * from products INNER JOIN auction on products.p_id=auction.p_id INNER JOIN product_imgs on products.p_id=product_imgs.p_id where products.p_id='$pid' AND product_imgs.p_id='$pid'");
  
  $product_data=mysqli_fetch_assoc($sql);
 
  //fetching product images
  $product_imgs=mysqli_query($con,"SELECT product_imgs from product_imgs where p_id='$pid'");
  $product_imgs1=mysqli_query($con,"SELECT product_imgs from product_imgs where p_id='$pid'");

  $data_imgs=mysqli_fetch_assoc($product_imgs);

  date_default_timezone_set('Asia/Kolkata');
  $end_time=$product_data['end_time'];
  $ending=date("Y-m-d H:i:s", strtotime($end_time));
  $aid=$product_data['a_id'];
 
  //Todays Date
  $today=date('Y-m-d H:i:s');
  $today_date=date('Y-m-d H:i:s',strtotime($today));

  $auction_status=$product_data['auction_status'];
  $wining_bidder=$product_data['wining_bidder'];
  $owner=$product_data['owner'];
  $paid_amount=$product_data['paid_amount'];
  $price=$product_data['price'];

  $bid_amount=mysqli_query($con,"SELECT bid_amount from bids where u_id='$wining_bidder' and p_id='$pid'");
  $fetch=mysqli_fetch_assoc($bid_amount);
  $bid=$fetch['bid_amount'];

  //fetching users name and profile pic
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


    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- swiper css link  -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- cusom css file link  -->
    <link rel="stylesheet" href="css/product_view.css">
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
<!-- 
<form action="" class="search-form">
    <input type="search" id="search-box" placeholder="search here...">
    <label for="search-box" class="fas fa-search"></label>
</form> -->

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
        <img src="<?php echo 'data:image;base64,'.base64_encode($row1['profile_pic']).''?>" height="100" width="100" />'
        <h3><?php echo $row['name'];?></h3>
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

  <section>
    <div class="container flex">
      <div class="left">
        <div class="main_image">
          <img src="<?php echo 'data:image;base64,'.base64_encode($data_imgs['product_imgs']).''?>" class="slide product-img">
        </div>
        <div class="option flex">

          <?php
            while($data_imgs1=mysqli_fetch_assoc($product_imgs1)){
          ?>

          <img src="<?php echo 'data:image;base64,'.base64_encode($data_imgs1['product_imgs']).''?>" onclick="img('<?php echo 'data:image;base64,'.base64_encode($data_imgs1['product_imgs']).''?>')">
         
          <?php
            }
          ?>
          
        </div>
      </div>
      <div class="right">

        <?php
          

        ?>

       
        <h3><?php echo $product_data['product_name']; ?></h3>

        <!-- Script for display countdown -->
        <script type="text/javascript" >

          var count_id='<?php echo $ending; ?>';

          var countDownDate=new Date(count_id).getTime();

          var x=setInterval(function(){

              //get today date and time
              var now=new Date().getTime();

              //find the diffrence between now and count down date
              var distance=countDownDate - now;

              // document.write(distance);

              //Time Calculation for day,hour,minutes and second
              var days = Math.floor(distance / (1000 * 60 * 60 * 24));
              var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
              var seconds = Math.floor((distance % (1000 * 60)) / 1000);

              // Output the result in an element with id="demo"
              document.getElementById("countdown").innerHTML = "Auction Ends in " + days + " Days " + hours + " Hours " + minutes + " Minutes " + seconds + " s";

              // If the count down is over, write some text 
              if (distance < 0) {
                  clearInterval(x);
                  document.getElementById("countdown").innerHTML = "Auction Ended...";
              }
              
          }, 1000);

        </script>
        <!-- End countdown script -->

        <h1 class="timer"> <span class="material-icons-outlined">timer</span> <span id="countdown"></span> </h1>

        <h4>Price:<small><span class="material-icons-outlined">currency_rupee</span></small><?php echo number_format($product_data['price']); ?> </h4>

        <div>

          <h1>Product Details </h1>

          <textarea cols="50" rows="20" disabled>
            <?php 
            $desc=$product_data['product_desc'];
            $description=preg_replace('#\[nl\]#','<br>',$desc);
            $description=preg_replace('#\[sp\]#',"&nbsp",$desc);
            echo ltrim($description);
            
            ?>
          </textarea>

        </div>

        <!-- bidders display -->
        <div class="highest-bid" id="bidders">  
        </div>


        <?php
          if(!empty($product_data['googlepay_ss'])){
        ?>

            <div class="highest-bid1">

            <h1>Payment Confirmation:</h1>
            <img src="<?php echo 'data:image;base64,'.base64_encode($product_data['googlepay_ss']).''?>" height="300px" alt="">
            <h3>Payment Recieved From Winner Of Product:-<?php echo $paid_amount; ?></h3>

            <?php

              if($paid_amount < $bid){
            ?>
            <h3>Pending Amount for Product:-<?php echo $paid_amount-$bid; ?></h3>
            <?php
              }
            ?>

            <?php
              //if condition for displaying confirm button
              if($product_data['confirm'] == 'recieved'){

            ?>

                <a href="db_operations/payment_recieved.php?recieve=true&wining_bidder=<?php echo $wining_bidder; ?>&p_id=<?php echo $pid; ?>"><button>Accept</button></a>
                <a href="db_operations/payment_recieved.php?recieve=false&wining_bidder=<?php echo $wining_bidder; ?>&p_id=<?php echo $pid; ?>"><button>Cancel</button></a>

            <?php
              }//payment confirmation button conditions

              if($product_data['confirm'] == 'done' && $paid_amount == $price){
            ?>
                <button>Payment Done</button>
            <?php
              }
              else if($paid_amount == $price){
                echo "";
              }
            ?>
            </div>
        <?php
          }else{
            echo "";
          }
        ?>

        <div>
            <a href="product_history.php"> <button type="button" class="btn" name="done" id="done"> Done </button> </a>
        </div>

      </div>

    </div>

  </section>


<!-- footer section starts  -->
<section class="credit">
    <p> created by <span>TYBCA Student</span> | all rights reserved! </p>
</section>
<!-- footer section ends -->




<!-- swiper js link      -->
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>
    function img(anything) {
      document.querySelector('.slide').src = anything;
    }

    function change(change) {
      const line = document.querySelector('.home');
      line.style.background = change;
    }
  </script>

  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <script>
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                document.getElementById("bidders").innerHTML = this.responseText;
              }
            };
            xmlhttp.open("POST","db_operations/get_bidders.php?p_id=<?php echo $pid; ?>",true);
            xmlhttp.send();  
      </script>
</body>

</html>