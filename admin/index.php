<?php error_reporting(0);

  session_start();

  include '../config/connect.php';

  $id=$_SESSION['id'];
  
  if(!isset($id)){
    header('location:../index.php');
  }
  // include 'controller/fetch_category.php';

  if(!empty($_GET['page'])){
    $page=$_GET['page'];
  }else{
      $page=1;
  }

  // Fetching Total count of Users
    $user_count=mysqli_query($con,"SELECT COUNT(*) as total_user from users");

    $user_result=mysqli_fetch_assoc($user_count);

    //Fetching Total Count of Auctioned Product 

    $product_count=mysqli_query($con,"SELECT COUNT(*) as total_product from products");

    $product_result=mysqli_fetch_assoc($product_count);

    $complaints_count=mysqli_query($con,"SELECT COUNT(*) as total_complaints from complaints");

    $complaints_result=mysqli_fetch_assoc($complaints_count);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>ONLINE AUCTION</title>
    <link rel="website icon" type='png' href="images/logo.png"/>


    <!-- <link rel="website icon" type="png" sizes="196*196" href='images/logo.png' /> -->

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/auctions.css">
    <link rel="stylesheet" href="css/users.css">
    <link rel="stylesheet" href="css/complaints.css">
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
      <!-- <aside id="sidebar">
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

          <li class="sidebar-list-item">
            <a href="#">
              <span class="material-icons-outlined">settings</span> Profile
            </a>
          </li> 

          <br><br><br>
          <li class="sidebar-list-item">
            <a href="controller/logout.php?logout_id=<?php echo $id; ?>">
              <span class="material-icons-outlined">logout</span> Log OUT
            </a>
          </li>

        </ul>

      </aside> -->
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
      <main class="main-container">
        <div class="main-title">
          
          <p class="font-weight-bold">DASHBOARD</p>
        </div>

        <div class="main-cards">

          <div class="card">
            <div class="card-inner">
              <p class="text-primary">PRODUCTS</p>
              <span class="material-icons-outlined text-blue">inventory_2</span>
            </div>
            <span class="text-primary font-weight-bold">
              <?php
                echo $product_result['total_product'];
              ?>
            </span>
          </div>

          <div class="card">
            <div class="card-inner">
              <p class="text-primary">Registered Users</p>
              <span class="material-icons-outlined text-orange">group</span>
            </div>
            <span class="text-primary font-weight-bold">
              <?php
                  echo $user_result['total_user'];
              ?>
            </span>
          </div>

          <div class="card">
            <div class="card-inner">
              <p class="text-primary">Total Complaints</p>
              <span class="material-icons-outlined text-green">report</span>
            </div>
            <span class="text-primary font-weight-bold">
                <?php
                    echo $complaints_result['total_complaints'];
                ?>
            </span>
          </div>

          <!-- <div class="card">
            <div class="card-inner">
              <p class="text-primary">INVENTORY ALERTS</p>
              <span class="material-icons-outlined text-red">notification_important</span>
            </div>
            <span class="text-primary font-weight-bold">56</span>
          </div> -->

        </div>

        <div class="content">

          <div class="cards" id="category">
            
            

            
          </div>

          <div class="cards" id="subcategory">
            
          </div>

        </div>
      </main>
      <!-- End Main -->

    </div>

    <!-- Scripts -->
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>

    <script>
       
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                document.getElementById("category").innerHTML = this. responseText;
              }
            };
            xmlhttp.open("POST","controller/fetch_registered.php");
            xmlhttp.send();

            var xmlhttp1 = new XMLHttpRequest();
            xmlhttp1.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                document.getElementById("subcategory").innerHTML = this. responseText;
              }
            };
            xmlhttp1.open("POST","controller/fetch_subcategory.php?page=<?php echo $page;?>");
            xmlhttp1.send();
          
        
      </script>
  </body>
</html>