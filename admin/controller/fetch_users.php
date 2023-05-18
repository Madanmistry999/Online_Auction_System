<?php

    include "../../config/connect.php";

    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }
    else{
        $page=1;
    }



    if(!empty($_POST['num'])){

        $num_per_page=$_POST['num'];
        
    }

    $start_from=($page-1)*$num_per_page;


    if(!empty($_POST['verify'])){
        $verify=$_POST['verify'];
    }
    
    if(empty($verify)){
        $sql="SELECT * from users INNER JOIN users_imgs on users.u_id=users_imgs.u_id LIMIT $start_from,$num_per_page";
    }else{
        $sql="SELECT * from users INNER JOIN users_imgs on users.u_id=users_imgs.u_id where verification='$verify' LIMIT $start_from,$num_per_page";
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
                <th>User Image</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>

              </tr>

            </thead>

            <tbody>

            <?php    
                    while($data=mysqli_fetch_assoc($queryrun)){

                        echo $num_per_page;
                        echo $verify;

                // echo $total_page;

            ?>

                <tr>

                    <td><?php echo $data['u_id'];?></td>
                    <td><img src="<?php echo 'data:image;base64,'.base64_encode($data['profile_pic']).''?>" /></td>
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

                                // if(empty($_POST['num'])){
                                    echo "<a href='?page=".($page-1)." class='btn btn-danger'><button type='button'>Previous</button></a>";
                                // }else{
                                //     echo "<a href='users.php?page=".($page-1)."' class='btn btn-danger'><button type='button'>Previous</button></a>";
                                // }
                            }
                           
                        ?>
                    </td>

                    <td></td>
                    <td></td>
                    <td></td>

            <?php

                }else{
                echo "<h1 class='text-center'>Not Found An Unverified Users List...!!!!</h1>";
                }//if condition

                if(empty($_POST['verify'])){

                    $res1=mysqli_query($con,"SELECT * from users INNER JOIN users_imgs on users.u_id=users_imgs.u_id");
                }else{
                    //this is for counting number of pages
                    $res1=mysqli_query($con,"SELECT * from users INNER JOIN users_imgs on users.u_id=users_imgs.u_id where verification='$verify'");
                }

                $count=mysqli_num_rows($res1);

                if(!empty($_POST['num'])){
                    $total_page=$count/$num_per_page;
                }

                $pages=ceil($total_page);

                
                for($i=1;$i<=$pages;$i++){
            ?> 

                    <a href="?page=<?php echo $i;?>"><?php echo $i; ?></a>

            <?php
                }
            ?>
                    <td>
                    <?php

                        if(($i > $page))
                        {
                                echo "<a href='?page=".($page+1)."' class='btn btn-danger'><button type='button'>Next</button></a>";
                           
                        }
                        else{
                            echo "";
                        }
                      
                    ?>
                    </td>
                </tr>

            </tbody>

        </table>

      </div>
                    

