<?php

    include '../../config/connect.php';

    // $page=$_GET['page'];

    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }
    else{
        $page=1;
    }


    $start_from=($page-1)*05;

    $num_per_page=05;


    //Fetching Category from DB
    $sql="SELECT * from item_subcategory INNER JOIN item_category on item_subcategory.c_id=item_category.c_id LIMIT $start_from,$num_per_page";

    $res=mysqli_query($con,$sql);

?>

    
    <table>

        <thead>
      
                <tr>

                    <th>Category ID</th>
                    <th>Category </th>
                    <th>Sub-Category </th>
                    <th >Action </th>

                </tr>
                    
        </thead>

        <tbody>


        <?php

        while($row=mysqli_fetch_assoc($res)){
        
        ?>

            <tr>

                <td><?php echo $row['c_id']; ?></td>
                <td><?php echo $row['category_name']; ?></td>
                <td><?php echo $row['subcategory_name']; ?></td>
                <td><a href="controller/remove_subcategory.php?c_id=<?php echo $row['c_id']; ?>&subcategory=<?php echo $row['subcategory_name']?>"><button type="button">Remove</button></a></td>
               
            </tr>
        
        <?php

        }     
        
        ?>

            <tr>

                <td>
                    <?php
                        if($page>1){
                            echo "<a href='index.php?page=".($page-1)."' class='btn btn-danger'><button>Previous</button></a>";
                        }
                    ?>
                </td> 
                
                <td></td>
                <td></td>

<?php



    //this is for counting number of pages
    $res1=mysqli_query($con,"SELECT * from item_subcategory INNER JOIN item_category on item_subcategory.c_id=item_category.c_id");

    $count=mysqli_num_rows($res1);

    $total_page=$count/$num_per_page;

    $pages=ceil($total_page);

    for($i=1;$i<=$pages;$i++){

        if($i < $pages){
?>     
            <a href="index.php?page=<?php echo $i;?>"></a>
<?php
        }
        elseif ($page == $pages) {
            break;
        }

    }

?>
                <td>
                    <?php
                        if($i>$page)
                        {
                            echo "<a href='index.php?page=".($page+1)."' class='btn btn-danger'><button>Next</button></a>";
                        }
                    ?>
                </td>

            </tr>

        </tbody>

    </table>