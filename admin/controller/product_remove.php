<?php

    include "../../config/connect.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require '../../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
    require '../../vendor/autoload.php';

    $pid=$_GET['p_id'];
    $product=mysqli_query($con,"SELECT * from products where p_id='$pid'");
    $data=mysqli_fetch_assoc($product);

    $product_name=$data['product_name'];
    $product_price=$data['price'];

    $email=$_GET['email'];

    $sql=mysqli_query($con,"SELECT * from bids INNER JOIN users on bids.u_id=users.u_id where bids.p_id='$pid'");
    
    if(mysqli_num_rows($sql) > 0){
    
        while($row=mysqli_fetch_assoc($sql)){
            $emails[]=$row['email'];
        }

        foreach($emails as $send){
            $sendmail=$send;
        }

        $delete=mysqli_query($con,"DELETE from products where p_id='$pid'");

        if($delete){
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
                $mail->addAddress($sendmail);
                            // $mail->addAddress($email,$name);

                $mail->IsHTML(true);
                $mail->Subject ="Product Removed From Auction List";
                $mail->Body ="Product Removed From Auction List";
                $mail->AltBody ="$sendmail We Have Been Removed $product_name from Auction That You Have Been Bidded For inaccurate Details of Product.";
                $mail->MsgHTML("<h1>$sendmail <br> We Have Been Removed $product_name from Auction That You Have Been Bidded For inaccurate Details of Product. <br> Bid For Another Products...</h1>
                                <br><br><br><br><br>
                                <h5>From:</h5>
                                <h3>Online Auction System</h3>");

                if(!$mail->Send()){


                      echo "Error Sending Mail";

                }
                else{
                    //send mail to owner of product
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
                    $mail->Subject ="Your Product Removed From Auction List";
                    $mail->Body ="Your Product Removed From Auction List";
                    // $mail->AltBody ="$email We Have Been Removed $product_name from Auction List For Adding Product With inaccurate Details of Product.";
                    $mail->MsgHTML("<h3>$email <br> We Have Been Removed $product_name from Auction List.<br>
                                    Product has inappropriate details.");
                
                    if(!$mail->Send()){
                        echo "Error Sending Mail";
                    }
                    else{
                        header("location:../auctions.php");
                    }

                }
        }
        else{
            echo "Try again later...";
        }
    }
    else{
        $delete=mysqli_query($con,"DELETE from products where p_id='$pid'");

        if($delete){
            

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
                    $mail->Subject ="Your Product Removed From Auction List";
                    $mail->Body ="Your Product Removed From Auction List";
                    $mail->AltBody ="$email We Have Been Removed $product_name from Auction List For Adding Product With inaccurate Details of Product.";
                    $mail->MsgHTML("<h1>$email <br> We Have Been Removed $product_name from Auction List For Adding Product With inaccurate Details of Product. <br> Bid For Another Products...</h1>");
                
                    if(!$mail->Send()){


                        echo "Error Sending Mail";
  
                    }
                    else{
                        header("location:../auctions.php");
                    }
        }
    }
?>