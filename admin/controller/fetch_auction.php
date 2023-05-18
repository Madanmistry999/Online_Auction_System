<?php

include "../../config/connect.php";

if(isset($_GET['page'])){
  $page=$_GET['page'];
}
else{
  $page=1;
}


if(empty($_POST['select'])){
  $select="";
}else{
  $select=$_POST['select'];
}
?>

            <!-- <form method="POST">
              
              <div class="select">
                <div>
                    <select name="select" id="color" class="box">
                        <option value="">All</option>
                        <option value="active">Verified</option>
                        <option value="close">UnVerified</option>
                    </select>
                </div>
                    <input type="submit" Value="seletc">
              </div>
            </form> -->


<?php

$num_per_page=5;

$start_from=($page-1)*$num_per_page;

echo $num_per_page;

// $sql="SELECT DISTINCT * from products INNER JOIN auction on products.p_id=auction.p_id INNER JOIN product_imgs on products.p_id=product_imgs.p_id INNER JOIN users on products.owner=users.u_id GROUP BY a_id LIMIT $start_from,$num_per_page";

if(empty($select)){
  $sql="SELECT DISTINCT * from products INNER JOIN auction on products.p_id=auction.p_id INNER JOIN product_imgs on products.p_id=product_imgs.p_id INNER JOIN users on products.owner=users.u_id  GROUP BY a_id LIMIT $start_from,$num_per_page";

}else if(!empty($select)){
  $sql="SELECT DISTINCT * from products INNER JOIN auction on products.p_id=auction.p_id INNER JOIN product_imgs on products.p_id=product_imgs.p_id INNER JOIN users on products.owner=users.u_id where auction.auction_status='$select' GROUP BY a_id LIMIT $start_from,$num_per_page";

}

$queryrun=mysqli_query($con,$sql);

$rows=mysqli_num_rows($queryrun);

if($rows > 0){

?>
<h1 class="text-center">Active Auction Lists</h1>



<div class="header_fixed">
<table>
  <thead>
    <tr>
        <th>Product ID</th>
        <th>Product Image</th>
        <th>Product Name</th>
        <th>Product Description</th>
        <th>Price</th>
        <th>Owner</th>
        <th>Auction select</th>
        <th>Action</th>
    </tr>
  </thead>
 
  <tbody>

  <?php    
        while($data=mysqli_fetch_assoc($queryrun)){
  ?>
    <tr>
        <td><?php echo $data['p_id'];?></td>
        <td> <img src="<?php echo 'data:image;base64,'.base64_encode($data['product_imgs']).''?>" /></td>
        <td><?php echo $data['product_name'];?></td>
        <td>
          <?php 
            $desc= $data['product_desc'];

            $description=str_replace('\n','<br>',$desc);

            echo $description;
          ?>
        </td>
        <td><?php echo $data['price'];?></td>
        <td><?php echo $data['name'];?></td>
        <td><?php echo $data['auction_status'];?></td>
        <td><a href="auctions.php?p_id=<?php echo $data['p_id']; ?>"><button>View</button></a></td>
    </tr>

    <?php
        
        }//while loop

    ?>

      <tr>

        <td>
            <?php
                if($page>1){
                    echo "<a href='../auctions.php?page=".($page-1)."' class='btn btn-danger'><button >Previous</button></a>";
                }
            ?>
        </td>

        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>

<?php

      }else{
        echo "<h1 class='text-center'>Not Found An Active Auction List...!!!!</h1>";
      }//if condition

       //this is for counting number of pages
       if(empty($select)){
      $res1=mysqli_query($con,"SELECT DISTINCT * from products INNER JOIN auction on products.p_id=auction.p_id INNER JOIN product_imgs on products.p_id=product_imgs.p_id INNER JOIN users on products.owner=users.u_id GROUP BY a_id");
       }
       else{
      $res1=mysqli_query($con,"SELECT DISTINCT * from products INNER JOIN auction on products.p_id=auction.p_id INNER JOIN product_imgs on products.p_id=product_imgs.p_id INNER JOIN users on products.owner=users.u_id where auction.auction_status='$select' GROUP BY a_id");
       }

      $count=mysqli_num_rows($res1);

      $total_page=$count/$num_per_page;

      $pages=ceil($total_page);

      for($i=1;$i<=$pages;$i++){
?> 

        <a href="../auctions.php?page=<?php echo $i;?>"><?php echo $i;?></a>

<?php
      }
?>
        <td>
        <?php
            if($i>$page){
               echo "<a href='../auctions.php?page=".($page+1)."' class='btn btn-danger'><button type='button' >Next</button></a>";
           
            }
        ?>
        </td>

      </tr>


    </tbody>

</table>
</div>