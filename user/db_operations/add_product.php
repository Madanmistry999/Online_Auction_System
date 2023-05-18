<?php
    session_start();

    $uid=$_SESSION['u_id'];
    $email=$_SESSION['email'];

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require '../../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
    require '../../vendor/autoload.php';

    include '../../config/connect.php';

    $product_name=$_POST['product_name'];
    $category=$_POST['category'];
    $subcategory=$_POST['subcategory'];
    $product_desc=$_POST['product_desc'];
    $productid=uniqid();

    // $product_desc="<pre>$desc</pre>";
    date_default_timezone_set('Asia/Kolkata');
    $end_time=$_POST['end_time'];
    $ending=date('d-m-Y h:i:sa',strtotime($end_time));
    $today=date('Y-m-d H:i:s');
    $today_date=date('Y-m-d H:i:s',strtotime($today));
    $price=$_POST['price'];
    $auction_status="active";
    $insert=false;

    //image extensions
    $extensions=array("jpeg","jpg","png");  //Valid Image Uploading Extensions

    if(!empty($product_name) && !empty($category) && !empty($subcategory) && !empty($product_desc) && !empty($end_time) && !empty($price)){

        
        if(!($ending < $today_date)){


                foreach($_FILES['product_imgs']['name'] as $key=>$image){


                        $product_img=$_FILES['product_imgs']['name'][$key];

                            $product_img_size=$_FILES['product_imgs']['size'][$key]; //Getting img size
                            $product_img_tmpname=addslashes(file_get_contents($_FILES['product_imgs']['tmp_name'][$key]));
                            $product_img_type=$_FILES['product_imgs']['type'][$key]; //Getting img type

                            $product_img_explode=explode('.',$product_img);
                            $product_img_extension=strtolower(end($product_img_explode));  //Getting img extension

                            if((in_array($product_img_extension,$extensions) === true)){

                                if((count($_FILES['product_imgs']['name']) <= 2 && (count($_FILES['product_imgs']['name']) >= 7))){

                                    echo "Please Select Maximum 3 Images OR Less Than 7 Images";
                                    break;

                                }else{

                                    $sql3=mysqli_query($con,"INSERT into product_imgs Values('$productid','$product_img_tmpname')");
                                    $insert=true;

                                }

                            }
                            else{
                                echo "Please Select Files in ~ JPG,PNG,JPEG";
                            }


                    }

                   
                    if($insert !== false){

                        //Inserting Data into Product Table
                        $sql=mysqli_query($con,"INSERT into products (p_id,product_name,product_desc,category,subcategory,price,owner) Values ('$productid','$product_name','$product_desc','$category','$subcategory','$price','$uid')");

                        $sql2=mysqli_query($con,"INSERT into auction (a_id,p_id,end_time,auction_status) Values (null,'$productid','$end_time','$auction_status')");



                        $mail=new PHPMailer(true);

                        $mail->IsSMTP();
                                
                        $mail->Mailer="smtp";

                        $mail->SMTPDebug =0;
                        $mail->SMTPAuth =TRUE;
                        $mail->SMTPSecure ='tls';
                        $mail->Port =587;
                        $mail->Host ="smtp.gmail.com";
                        $mail->Username ="mistrymadan699@gmail.com";
                        $mail->Password ="qmskesryhgwkihzw";

                        $mail->SetFrom('mistrymadan699@gmail.com','Auction System');
                        $mail->addAddress($email);
                                            // $mail->addAddress($email,$name);

                        $mail->IsHTML(true);
                        $mail->Subject ="$product_name Added To An Auction";
                        $mail->Body ="$product_name Added to An Auction";
                        $mail->AltBody ="Your Product $product_name is Added to an Auction With Base Price $price";
                        $mail->MsgHTML("<h3>Your Product $product_name is Added to an Auction With Base Price $price <br> Auction Ends On $ending.</h3> <h1> Wait for Getting Bidders.....!!! </h1>");

                        if(!$mail->Send()){
                            echo "Error Sending Mail";
                        }
                        else{

                            $product_name='';
                            $category='';
                            $subcategory='';
                            $product_desc='';
                            $end_time='';

                            echo "success";
                        }
                    }//$insert true condition

                }else{
                    echo "Select Future Date & Time";
                }//date time condition

    
    }
    else{
        echo "All input fields required...!";
    }


    //$sql=mysqli_query($con,"INSERT INTO products Values('','$product_name','$category','$subcategory','$pro')");
?>