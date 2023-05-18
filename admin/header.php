<?php
  session_start();

  $id=$_SESSION['id'];

  if(!isset($id)){
    header('location:../index.php');
  }
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
    <link rel="stylesheet" href="css/auctions.css">
    <link rel="stylesheet" href="css/users.css">
    <link rel="stylesheet" href="css/complaints.css">
  </head>
  <body>


    <div class="grid-container">

      <!-- Header -->
      <!-- <header class="header"> -->

        <div class="menu-icon" onclick="openSidebar()">
          <span class="material-icons-outlined">menu</span>
        </div>


      <!-- </header> -->
      <!-- End Header -->

      <!-- Sidebar -->
      <aside id="sidebar">

<div class="sidebar-title">
  <div class="sidebar-brand">
    <span><img src="images/logo-.png" height="40px" width="40px"></span> Auction System
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