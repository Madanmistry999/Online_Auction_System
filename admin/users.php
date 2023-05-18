<?php
  session_start();

  $id=$_SESSION['id'];

  include "../config/connect.php";

  if(!empty($_GET['page'])){
    $page=$_GET['page'];
  }else{
    $page=1;
  }

  if(!isset($id)){
    header('location:../index.php');
  }

  error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="website icon" type='png' href="images/logo.png"/>


    <!-- Montserrat Font -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> -->

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    

    <!-- Bootstrap 5 -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->

    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <!-- <link rel="stylesheet" href="css/auctions.css"> -->
    <link rel="stylesheet" href="css/users.css">
    <!-- <link rel="stylesheet" href="css/complaints.css"> -->
  </head>
  <body>


    <div class="grid-container">

      <!-- Header -->
      <header class="header">

        <div class="menu-icon" onclick="openSidebar()">
          <span class="material-icons-outlined">menu</span>
        </div>


      </header>
      <!-- End Header -->

      <!-- Sidebar -->
      <aside id="sidebar">

<div class="sidebar-title">
  <div class="sidebar-brand">
          <image src="images/logo.png" height="50px" width="50px"> Auction System
  </div>
  <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
</div>

<ul class="sidebar-list">

  <li class="sidebar-list-item">
    <a href="index.php">
      <span class="material-icons-outlined">dashboard</span> Dashboard
    </a>
  </li>

  <li class="sidebar-list-item">
    <a href="auctions.php">
      <span class="material-icons-outlined">inventory_2</span> Auctions
    </a>
  </li>

  <li class="sidebar-list-item">
    <a href="users.php">
      <span class="material-icons-outlined">person</span> Users
    </a>
  </li>

  <li class="sidebar-list-item">
    <a href="complaints.php">
      <span class="material-icons-outlined">report</span> Complaints
    </a>
  </li>

  <!-- <li class="sidebar-list-item">
    <a href="#">
      <span class="material-icons-outlined">settings</span> Profile
    </a>
  </li> -->

  <br><br><br>
  <li class="sidebar-list-item">
    <a href="controller/logout.php?logout_id=<?php echo $id; ?>">
      <span class="material-icons-outlined">logout</span> Log OUT
    </a>
  </li>

</ul>

</aside>
      <!-- End Sidebar -->


      <!-- Main -->
      <main class="main-container"  >

      <?php
        if(empty($_GET['u_id'])){
      ?>


        <div id="users-list">

                <?php

                if (isset($_REQUEST['displayAmount'])) {
                  // $selected = $_REQUEST['displayAmount'];
                  $num_per_page=$_REQUEST['displayAmount'];
                } else {
                // $selected = 10;
                $num_per_page=05;
                }

                //statuus selection
                if(isset($_REQUEST['status'])){
                  $select=$_REQUEST['status'];
                }else{
                  $select="All";

                }

                if(isset($_REQUEST['search'])){
                  $search=$_REQUEST['search'];

                }


                //Create array of display amount option for user to choose
                $options = array(5,10,15,20,50);

                //selection of active & closed auction
                $verification = array('All','Verified','Unverified');


                echo '<form method="post">
              <select name="displayAmount" class="box" onchange="this.form.submit();">';

            //iterate through the option and set current option as selected.
              foreach ($options as $option) {
                if($option == $num_per_page){
                    echo "<option selected='selected'> $option </option>";
                }else{
                    echo "<option> $option </option>";
                }
              }
  
              echo  '</select> ';

              echo '<select name="status" class="box" onchange="this.form.submit();">';

            //iterate through the option and set current option as selected.
              foreach ($verification as $status) {
                if($status == $select){
                    echo "<option selected='selected'> $status </option>";
                }else{
                    echo "<option> $status </option>";
                }
              }

              echo '</select>';
?>
                <input type="text" name="search" id="search" class='search' onchange="this.form.submit();" placeholder="Search By Email">

              </form>



<?php

                $start_from=($page-1)*$num_per_page;

                if($select == 'All' && empty($search)){

                  $sql="SELECT * from users LIMIT $start_from,$num_per_page";
                  
                }
                elseif(!empty($search) && $select !== 'All'){
                  $sql="SELECT * from users where verification='$select' AND email like '%$search%' LIMIT $start_from,$num_per_page";
                }
                else if($select !== 'All'){
                  $sql="SELECT * from users where verification='$select' LIMIT $start_from,$num_per_page";
                }
                else if(!empty($_REQUEST['search'])){
                  $sql="SELECT * from users where email like '%$search%' LIMIT $start_from,$num_per_page";
                }

                $queryrun=mysqli_query($con,$sql);

                $rows=mysqli_num_rows($queryrun);

                      if($rows > 0){
                ?>
                  <div class="main-title">
                      <p class="font-weight-bold">All Registered Users</p>
                  </div>

                  <div class="table_responsive">

                      <table>

                          <thead>

                            <tr>

                              <th>User ID</th>
                              <th>User Profile Pic</th>
                              <th>Name</th>
                              <th>Phone</th>
                              <th>Address</th>
                              <th>Action</th>

                            </tr>

                          </thead>

                          <tbody>

                      <?php    
                              while($data=mysqli_fetch_assoc($queryrun)){

                                  // echo $num_per_page;
                                $uid=$data['u_id'];

                                $select_img=mysqli_query($con,"SELECT * from users_imgs where u_id='$uid'"); 

                                $disp_img=mysqli_fetch_assoc($select_img);

                      ?>

                            <tr>

                                <td><?php echo $data['u_id'];?></td>

                                <?php
                                  if($data['verification'] !== 'Unverified'){
                                ?>
                                  <td><img src="<?php echo 'data:image;base64,'.base64_encode($disp_img['profile_pic']).''?>" /></td>
                                <?php
                                  }else{
                                ?>
                                  <td><img src="images/usr.jpg" /></td>
                                <?php
                                  }
                                ?>

                                <td><?php echo $data['name'];?></td>
                                <td><?php echo $data['contact_no'];?></td>
                                <td><?php echo $data['address'];?></td>
                                <td>
                                <span class="action_btn">
                                    <a href="users.php?u_id=<?php echo $data['u_id'];?>">View</a>
                                </span>
                                </td>

                            </tr>

                        <?php
                                
                            }//while loop

                        ?>

                            <tr>

                              <td>

                                <?php
                                if($page>1){

                                ?>
                                  <a href="users.php?page=<?php echo $page-1;?>&displayAmount=<?php echo $num_per_page; ?>&status=<?php echo $select;?>" class='btn btn-danger'><button >Previous</button></a>
                                <?php
                                    }
                                ?>

                              </td>

                                <td colspan='4'><?php //echo "<button>Page:$page</button>";?></td>
                                

                        <?php

                              }else{
                                  echo "<h1 class='text-center'>Not Found An Users List...!!!!</h1>";                              
                              }//if condition

                                  //this is for counting number of pages
                              if($select == 'All' && empty($search)){
                                $res1=mysqli_query($con,"SELECT * from users");
                              }
                              else if(!empty($search) && $select !== 'All'){
                                $res1=mysqli_query($con,"SELECT * from users where verification='$select' And email LIKE '%$search%'");
                              }
                              else if($select !== 'All'){
                                $res1=mysqli_query($con,"SELECT * from users where verification='$select'");
                              }
                              else if(!empty($_REQUEST['search'])){
                                $res1=mysqli_query($con,"SELECT * from users where email LIKE '%$search%'");
                              }
                            
                              $count=mysqli_num_rows($res1);

                              $total_page=$count/$num_per_page;

                              $pages=ceil($total_page);

                              //forloop to calculate pages   
                              for($i=1;$i<=$pages;$i++){

                                if($i < $pages){
                                  ?> 
                                    <a href="auctions.php?page=<?php echo $i;?>&displayAmount=<?php echo $num_per_page; ?>&status=<?php echo $select;?>&search=<?php echo $search; ?>"></a>
                       
                                 <?php
                                    }
                                    else if($page == $pages){
                                      break;
                                    }
                                    else if($page > $i){
                                 ?>
                                      <a href="users.php?page=<?php echo $i;?>&displayAmount=<?php echo $num_per_page; ?>&status=<?php echo $select;?>&search=<?php echo $search; ?>"><button>Click Here To Back</button> </a>
                       
                          <?php
                              }//end
                          }
                          ?>
                          <!-- displaying next button -->
                              <td>
                                <?php
                                    if($i > $page){
                                ?>
                                      <a href="users.php?page=<?php echo $page+1;?>&displayAmount=<?php echo $num_per_page; ?>&status=<?php echo $select;?>&search=<?php echo $search; ?>"  class='btn btn-danger' id='next'><button type='button' >Next</button></a>
                                <?php
                                      //}//next button condition
                                    }
                                ?>
                              </td>
                          </tr>

                            </tbody>

                        </table>

                  </div>

              </div>
      <?php
        }
        else{

          $uid=$_GET['u_id'];

          $sql=mysqli_query($con,"SELECT * from users where u_id='$uid'");

          $fetch_profile=mysqli_query($con,"SELECT * from users_imgs where u_id='$uid'");

          $display1=mysqli_fetch_assoc($sql);

          $verification=$display1['verification'];

          $display2=mysqli_fetch_assoc($fetch_profile);

          $verify=$display2['verify'];

      ?>
        <div class="card">

        <?php
          if($verification !== 'Unverified'){
        ?>
            <img src="<?php echo 'data:image;base64,'.base64_encode($display2['profile_pic']).''?>" style="width:30%">
        <?php
          }
          else{
        ?>
            <img src="images/usr.jpg" style="width:30%">
        <?php    
          }
        ?>
          <h1><?php echo $display1['name'];?></h1>
          <p class="title">
            <?php
              if($display1['account_status'] == '1'){
            ?>
              <a href="controller/status_user.php?u_id=<?php echo $display1['u_id'];?>"><button>Block Account</button></a>
            <?php
              }
              else{
                echo '<button>Blocked</button>';
            ?>
              <!-- <a href="controller/status_user.php?u_id=<?php echo $display1['u_id'];?>"><button>Active Account</button></a> -->
            <?php
              }
            ?>
          </p>

        <!-- qrcode image verification code -->
        <?php
          if($verification !== 'Unverified'){

            //codition if qrcode pic is unverified by system
            if($verify !== 'true' && !empty($display2['qrcode_pic'])){
        ?>
            <p>QRCode Image</p>
            <img src="<?php echo 'data:image;base64,'.base64_encode($display2['qrcode_pic']).''?>" alt="John" style="width:30%">
        <?php
        
            }
            else if($verify == 'true'){
        ?>
            <p>QRCode Image</p>
            <img src="<?php echo 'data:image;base64,'.base64_encode($display2['qrcode_pic']).''?>" alt="John" style="width:30%">
        <?php
            }
            else{
              echo "";
            }

          }
          else{
            echo "<h2>Image not Uploaded...!!!</h2>";
          }
        ?>
          <p>Email:<?php echo $display1['email'];?></p>

          <p>Address:<?php echo $display1['address'];?></p>

        <?php
        if($verification !== 'Unverified'){

          if(!empty($display2['qrcode_pic']) && $display2['verify'] !== 'true'){
        ?>
          <p>
          <a href="controller/verifyqr.php?u_id=<?php echo $display1['u_id']; ?>&verify=true"><button>Verify Images</button></a><br><br>
          <a href="controller/verifyqr.php?u_id=<?php echo $display1['u_id']; ?>&verify=false"><button>Cancel</button></a><br><br>
          </p>

        <?php
          }//buttons for qrcode pic verification condition

          if($display2['verify'] !== 'false'){
        ?>
          <p>
            <button>Verified QRcode</button>
          </p>
        <?php
          }
          else {
        
          }//verified or unverified qrcode pic

        }//if verified condition

        if($verification !== 'Verified'){
          echo "<h1>User Is Unverified...</h1>";
        }
        ?>


        <?php
          if($verification !== 'Verified'){
        ?>
          <p>
              <a href="controller/remove_user.php?u_id=<?php echo $display1['u_id']; ?>"><button>Remove</button></a>
          </p>
        <?php
          }
        ?>

          <p><a href="users.php"><button>Done</button></a></p>
        </div>
      <?php

      }


      ?>
       
      </main>
      <!-- End Main -->

        
      <!-- </div>

    </div> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
    if(window.history.replaceState){
        window.history.replaceState(null,null,window.location.href);
    }
</script>

<?php
  include "footer.php";
?>