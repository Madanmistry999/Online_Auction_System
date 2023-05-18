<?php
    session_start();

    include '../config/connect.php';

    $uid=$_SESSION['u_id'];

    if(empty($uid)){
        header('location:../index.php');
    }

    $qry=mysqli_query($con,"SELECT * from users,state where u_id='$uid' and users.pincode=state.pincode");

	$imgs=mysqli_query($con,"SELECT * from users_imgs where u_id='$uid'");

    $row=mysqli_fetch_assoc($qry);

    $row_img=mysqli_fetch_assoc($imgs);

	$verify=$row_img['verify'];
    

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONLINE AUCTION</title>
    <link rel="website icon" type='png' href="images/logo.png"/>

        <!-- cusom css file link  -->
        <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

	
	<!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- bootstrap cdn -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

</head>
<body>

    
<!-- header section starts  -->


<header class="header">

    <a href="index.php" class="logo" style="text-decoration:none;">
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

                    <a style="color:white;">
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

   

    
    <!-- <div class="profile"> -->

    <!-- </div> -->

   

</header>

<!-- header section ends -->

<!-- side-bar section starts -->

<div class="side-bar">

    <div id="close-side-bar" class="fas fa-times"></div>

	<div class="user">
        <img src="<?php echo 'data:image;base64,'.base64_encode($row_img['profile_pic']).''?>" height="100" width="100" />'
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

<div class="profile-container">

		<div class="profile-data row col-lg-8 rounded mx-auto ">
			<div class="col-md-4 text-center">

			

				<img src="<?php echo 'data:image;base64,'.base64_encode($row_img['profile_pic']).''?>" class="img-fluid rounded profile-img" >
			
			

				<div>


						<a href="profile_edit.php?profileedit=<?php echo md5(uniqid());?>">
							<button class="mx-auto m-1 btn-lg btn btn-primary">Edit</button>
						</a>
						
						<a href="db_operations/logout.php">
							<button class="mx-auto m-1 btn-lg btn btn-info text-white ">Logout</button>
						</a>

                        
				</div>
			</div>
			<div class="col-md-8">

				<div class="h2">User Profile</div>

				<table class="table table-striped">

					<tr colspan="2"> <th  class="text-center">User Details:</th> <td></td> </tr>

					<tr>
						<th><span class="material-icons-outlined ">email</span>Email</th>
						
						<td><?php echo $row['email']; ?></td>
					</tr>

					<tr>
						<th><span class="material-icons-outlined ">badge</span> Full name</th>
						
						<td><?php echo $row['name']; ?></td>
					</tr>

					<tr>
						<th><span class="material-icons-outlined ">edit_note</span> Address</th>
						
						<td><?php echo $row['address']; ?></td>
					</tr>

					<tr>
						<th><span class="material-icons-outlined ">phone_iphone</span>Contact Number</th>
						
						<td><?php echo $row['contact_no']; ?></td>
					</tr>

					<tr>
						<th><span class="material-icons-outlined ">tag</span> Pincode</th>
						
						<td><?php echo $row['pincode']; ?></td>
					</tr>

					<tr>
						<th><span class="material-icons-outlined ">location_city</span> City </th>
						
						<td><?php echo $row['city']; ?></td>
					</tr>

					<tr>
						<th><span class="material-icons-outlined ">place</span> State</th>
						
						<td><?php echo $row['state']; ?></td>
					</tr>

					<tr>
						<th><span class="material-icons-outlined ">qr_code_scanner</span>QR Code</th>

						<?php
							if($verify == 'false'){
								echo "<td><h3>Your QR Is In Verification.</h3></td>";
							}else{
						?>
						
								<td><img src="<?php echo 'data:image;base64,'.base64_encode($row_img['qrcode_pic']).''?>" class="img-fluid rounded profile-img" ></td>

						<?php
							}
						?>
					</tr>

				</table>
			</div>
		</div>
</div>


<!-- footer section starts  -->

<section class="credit">

    <p> created by <span>TYBCA Student</span> | all rights reserved! </p>


</section>

<!-- footer section ends -->

<script src="js/script.js"></script>

</body>
</html>