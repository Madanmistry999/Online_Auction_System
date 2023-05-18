<?php

    include '../../config/connect.php';

    // $page=$_GET['page'];

    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }
    else{
        $page=1;
    }


    $num_per_page=05;


    //Fetching Category from DB
    $sql="SELECT * from users order by u_id desc LIMIT $num_per_page ";

    $res=mysqli_query($con,$sql);

?>

    
    <table>

        <thead>
      
                <tr>

                    <th>User ID</th>
                    <th colspan='2'>Name of User</th>
                    <th></th>
                    <th>Email</th>
                    <th>Verication</th>
                    <th>Option</th>

                </tr>
                    
        </thead>

        <tbody>


        <?php

        while($row=mysqli_fetch_assoc($res)){

            $uid=$row['u_id'];

            $sql2=mysqli_query($con,"SELECT * from users_imgs where u_id=$uid");

            $imgs=mysqli_fetch_assoc($sql2);

        ?>

            <tr>

                <td><?php echo $row['u_id']; ?></td>

                <?php
                    if(!empty($imgs['profile_pic'])){
                ?>
                    <td colspan='2'><img src="<?php echo 'data:image;base64,'.base64_encode($imgs['profile_pic']).''?>" height='40px' width='50px' /></td>
                <?php
                    }else{
                ?>
                    <td colspan='2'><img src="images/usr.jpg" height='40px' width='50px' /></td>
                <?php
                    }
                ?>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['verification']; ?></td>
                <td>
                    <a href="users.php?u_id=<?php echo $row['u_id']; ?>"><button>View</button></a>
                </td>
               
            </tr>
        
        <?php

        }     
        
        ?>

            <tr>

                <td colspan='7'><a href="users.php"><button>View All</button></a></td>

            </tr>

        </tbody>

    </table>