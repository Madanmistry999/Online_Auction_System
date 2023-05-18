<?php
    session_start();

    include "../../config/connect.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require '../../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
    require '../../vendor/autoload.php';

    // error_reporting(0);

    $uid=$_GET['u_id'];
    $sql=mysqli_query($con,"SELECT * from users where u_id='$uid'");
    $data=mysqli_fetch_assoc($sql);
    $email=$data['email'];
    $account=true;

    if($data['account_status'] == '1'){

    //     $auction_id=mysqli_query($con,"SELECT * from bids where u_id='$uid'");
    //     $paymentWinner=false;
    //     $payment=false;

    // //if user has multiple bids
    // while($fetch1=mysqli_fetch_assoc($auction_id)){
    //     $aid[]=$fetch1['a_id'];
    //     $pWin[]=$fetch['p_id'];
    // }

    // //fetching if user has done payment
    // foreach($pWin as $win){
    //     // $product_payment=
    // }

    // foreach($aid as $auctions){
    //     echo $auctions."<br>";
    // }

    // //fetching pid from product if user added any product
    // $product_id=mysqli_query($con,"SELECT p_id,confirm from products where owner='$uid'");

    // while($fetch2=mysqli_fetch_assoc($product_id)){

    //     $pid[]=$fetch2['p_id'];

    //     $confirm[]=$fetch2['confirm'];

    // }


    // $delete=false;

    // if(!empty($products) && !empty($auctions)){


           
    //         if(!empty($a_id) && !empty($pid)){

    //             foreach($aid as $auctions){
    //                 $auctions=$aid;
    //                 $auction=mysqli_query($con,"SELECT * from auction where a_id='$auctions' and wining_bidder='$uid'");
    //             }
    
    //             while($auction_data=mysqli_fetch_assoc($auction)){
    //                 //this aid is where user is wining bidder
    //                 $a_id[]=$auction_data['a_id'];
        
    //             }
    
    //             //user product bidder from databse
    //             foreach($pid as $p){
    
    //                 $bidder=mysqli_query($con,"SELECT * from bids INNER JOIN users on bids.u_id=users.u_id where bids.p_id='$p' ");
                    
                   
    //                 while($bidders_emails=mysqli_fetch_assoc($bidder)){
    //                     $email=$bidders_emails['email'];
    //                 }
    
    //             }

    //             foreach($confirm as $c1){
    //             }
    

    //         }
    //         elseif (!empty($a_id)) {

    //         } 
    //         elseif(!empty($pid)){

    //         }
    //         else{

    //         }

            

         
        // if($data['account_status'] == '1'){

        $block=mysqli_query($con,"UPDATE users SET account_status='0' where u_id='$uid'");
        $delete=mysqli_query($con,"DELETE from products where owner='$uid'");

        if($block && $delete){
            $account=false;
        }

        if($account == false){

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
                $mail->Subject ="Account Blocked";
                $mail->Body ="Account Blocked By System";
                $mail->AltBody ="Hello User.... We Have Been Blocked Your Account for Getting Complaints Against Your Email or Unusual Activities ....!!!";
                $mail->MsgHTML("<h1>Hello User.... <br> We Have Been Blocked Your Account for Getting Complaints Against Your Email or Unusual Activities ....!!! </h1>");

                if(!$mail->Send()){
                    echo "Error Sending Mail";
                }
                else{
                    header("location:../users.php?u_id=$uid");
                }
        }
        else{
            echo "Account Block Failed....!!!";
        }
    }
    else if($data['account_status'] == '0'){

        $active=mysqli_query($con,"UPDATE users SET account_status='1' where u_id='$uid'");

        if($active){

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
                $mail->Subject ="Account Activated";
                $mail->Body ="Account Account is Activated";
                $mail->AltBody ="Hello User.... We Have Been Activated Your Account After Getting Your Reply on our Email.";
                $mail->MsgHTML("<h1>Hello User.... <br> We Have Been Activated Your Account After Getting Your Reply on our Email. </h1>");

                if(!$mail->Send()){
                    echo "Error Sending Mail";
                }
                else{
                    header('location:../users.php');
                }
        }
        else{
            echo "Account Active Failed....!!!";
        }
    }

    //fetching auction id if user place bid for any product
    
            // if(mysqli_num_rows($sql) > 0){
                //fetching all products bidders email
               
            // }

        // if(($confirm !== 'recieved') && ($confirm !== 'done') && ($confirmed !== 'recieved') && ($confirmed !== 'done')){

        //     echo 'dshdjsdkjs';
        //     if($auction_data['wining_bidder'] == $uid){

        //         //fetching other highest bidder detail

        //         $find_bid=mysqli_query($con,"SELECT * from bids where a_id='$a_id'");


        //         //set other wining bidder if user is in wining bidder of product
        //         while($disp_bid=mysqli_fetch_assoc($find_bid)){

        //             $bids[]=$disp_bid['bid_amount'];

        //         }

        //         foreach($bids as $bid_amount){
                    
                        
        //             $highbid=max($bids);

        //             echo $highbid;
        
        //             // echo $highbid;
        
        //             $find=mysqli_query($con,"SELECT u_id from bids where bid_amount='$highbid' AND a_id='$a_id'");
        
        //             $data1=mysqli_fetch_assoc($find);
        
        //             $winning_bidder=$data['u_id'];
        
        //             // echo $winning_bidder;
        //         }

        //         $delete_bid=mysqli_query($con,"UPDATE auction SET current_bid='$highbid',wining_bidder='$winning_bidder' where a_id='$a_id' AND wining_bidder='$uid'");
        //         $delete_user=mysqli_query($con,"DELETE from users where u_id='$uid'");

        //         if($delete_bid && $delete_user){
        //             $delete=true;
        //         }
        //         else{
        //             echo "";
        //         }

        //         if($delete == true){

        //             $mail=new PHPMailer(true);

        //             $mail->IsSMTP();
                                    
        //             $mail->Mailer="smtp";
        
        //             $mail->SMTPDebug =0;
        //             $mail->SMTPAuth =TRUE;
        //             $mail->SMTPSecure ='tls';
        //             $mail->Port =587;
        //             $mail->Host ="smtp.gmail.com";
        //             $mail->Username ="mistrymadan699@gmail.com";
        //             $mail->Password ="qmskesryhgwkihzw";
        
        //             $mail->SetFrom('mistrymadan699@gmail.com','Auction System');
        //             $mail->addAddress($email);
        //                                         // $mail->addAddress($email,$name);
        
        //             $mail->IsHTML(true);
        //             $mail->Subject ="Your Account is Removed from System";
        //             $mail->Body ="Your Account is Removed from System";
        //             $mail->AltBody ="Hello User Your Account is Removed from System for Registering with Incomplete Data....";
        //             $mail->MsgHTML("<h1>Hello User Your Account is Removed from System for Registering with Incomplete Data....</h1>");
        
        //             if(!$mail->Send()){
        //                 echo "Error Sending Mail";
        //             }
        //             else{
        //                 header('location:../users.php');
        //             }

        //         }


        //     }
        //     else{
        //         echo $pid;
        //     }

        // }
        // //if payment is done by user for winned product
        // else if(($confirmed == 'recieved') || ($confirmed == 'done')){
?>
                <!-- <script>
                    alert('User has Done Payment for The Product win by User...!!!');
                    location.href='../users.php';
                </script> -->
<?php
        // }
        // else if(($confirm == 'recieved') || ($confirm == 'done')){

?>
<!-- <script>
                    alert('User has Recieved Payment for The Product added by User...!!!');
                    location.href='../users.php';
                </script> -->
<?php

    //     }

    // }
    // else if(!empty($products)){

    //     $sql=mysqli_query($con,"SELECT * from bids INNER JOIN users on bids.u_id=users.u_id where bids.p_id='$pid'");

    //     if(mysqli_num_rows($sql) > 0){
        
    //         while($row=mysqli_fetch_assoc($sql)){
    //             $emails[]=$row['email'];
    //         }

    //         foreach($emails as $send){
    //             $sendmail=$send;
    //         }

    //         $delete_product=mysqli_query($con,"DELETE from users where u_id='$uid'");
    //         $delete_user=mysqli_query($con,"DELETE from users where u_id='$uid'");

    //         if($delete_product && $delete_user){
    //             $delete=true;
    //         }

    //         if($delete == true){

    //             $mail=new PHPMailer(true);

    //                 $mail->IsSMTP();
                                    
    //                 $mail->Mailer="smtp";
        
    //                 $mail->SMTPDebug =0;
    //                 $mail->SMTPAuth =TRUE;
    //                 $mail->SMTPSecure ='tls';
    //                 $mail->Port =587;
    //                 $mail->Host ="smtp.gmail.com";
    //                 $mail->Username ="mistrymadan699@gmail.com";
    //                 $mail->Password ="qmskesryhgwkihzw";
        
    //                 $mail->SetFrom('mistrymadan699@gmail.com','Auction System');
    //                 $mail->addAddress($email);
    //                                             // $mail->addAddress($email,$name);
        
    //                 $mail->IsHTML(true);
    //                 $mail->Subject ="Your Account is Removed from System";
    //                 $mail->Body ="Your Account is Removed from System";
    //                 $mail->AltBody ="Hello User Your Account is Removed from System for Registering with Incomplete Data....";
    //                 $mail->MsgHTML("<h1>Hello User Your Account is Removed from System for Registering with Incomplete Data....</h1>");
        
    //                 if(!$mail->Send()){
    //                     echo "Error Sending Mail";
    //                 }
    //                 else{
    //                     header('location:../users.php');
    //                 }

    //         }


    //     }
    //     else{

    //         $delete_product=mysqli_query($con,"DELETE from users where u_id='$uid'");
    //         $delete_user=mysqli_query($con,"DELETE from users where u_id='$uid'");

    //         if($delete_product && $delete_user){
    //             $delete=true;
    //         }

    //         if($delete == true){

    //             $mail=new PHPMailer(true);

    //                 $mail->IsSMTP();
                                    
    //                 $mail->Mailer="smtp";
        
    //                 $mail->SMTPDebug =0;
    //                 $mail->SMTPAuth =TRUE;
    //                 $mail->SMTPSecure ='tls';
    //                 $mail->Port =587;
    //                 $mail->Host ="smtp.gmail.com";
    //                 $mail->Username ="mistrymadan699@gmail.com";
    //                 $mail->Password ="qmskesryhgwkihzw";
        
    //                 $mail->SetFrom('mistrymadan699@gmail.com','Auction System');
    //                 $mail->addAddress($email);
    //                                             // $mail->addAddress($email,$name);
        
    //                 $mail->IsHTML(true);
    //                 $mail->Subject ="Your Account is Removed from System";
    //                 $mail->Body ="Your Account is Removed from System";
    //                 $mail->AltBody ="Hello User Your Account is Removed from System for Registering with Incomplete Data....";
    //                 $mail->MsgHTML("<h1>Hello User Your Account is Removed from System for Registering with Incomplete Data....</h1>");
        
    //                 if(!$mail->Send()){
    //                     echo "Error Sending Mail";
    //                 }
    //                 else{
    //                     header('location:../users.php');
    //                 }
    //         }


    //     }


    // }
    // else if(!empty($auctions)){

    // $sql=mysqli_query($con,"SELECT * from bids where a_id='$aid'");

    //     if($sql){

    //         while($disp_bid=mysqli_fetch_assoc($sql)){

    //             $bids[]=$disp_bid['bid_amount'];

    //         }

    //         foreach($bids as $sql){
                
                    
    //             $highbid=max($bids);

    //             echo $highbid;
    
    //             // echo $highbid;
    
    //             $find=mysqli_query($con,"SELECT u_id from bids where bid_amount='$highbid' AND a_id='$a_id'");
    
    //             $data1=mysqli_fetch_assoc($find);
    
    //             $winning_bidder=$data['u_id'];
    
    //             // echo $winning_bidder;
    //         }

    //         $delete_bid=mysqli_query($con,"UPDATE auction SET current_bid='$highbid',wining_bidder='$winning_bidder' where a_id='$a_id' AND wining_bidder='$uid'");
    //             $delete_user=mysqli_query($con,"DELETE from users where u_id='$uid'");

    //             if($delete_bid && $delete_user){
    //                 $delete=true;
    //             }

    //             if($delete == true){

    //                 $mail=new PHPMailer(true);

    //                 $mail->IsSMTP();
                                    
    //                 $mail->Mailer="smtp";
        
    //                 $mail->SMTPDebug =0;
    //                 $mail->SMTPAuth =TRUE;
    //                 $mail->SMTPSecure ='tls';
    //                 $mail->Port =587;
    //                 $mail->Host ="smtp.gmail.com";
    //                 $mail->Username ="mistrymadan699@gmail.com";
    //                 $mail->Password ="qmskesryhgwkihzw";
        
    //                 $mail->SetFrom('mistrymadan699@gmail.com','Auction System');
    //                 $mail->addAddress($email);
    //                                             // $mail->addAddress($email,$name);
        
    //                 $mail->IsHTML(true);
    //                 $mail->Subject ="Your Account is Removed from System";
    //                 $mail->Body ="Your Account is Removed from System";
    //                 $mail->AltBody ="Hello User Your Account is Removed from System for Registering with Incomplete Data....";
    //                 $mail->MsgHTML("<h1>Hello User Your Account is Removed from System for Registering with Incomplete Data....</h1>");
        
    //                 if(!$mail->Send()){
    //                     echo "Error Sending Mail";
    //                 }
    //                 else{
    //                     header('location:../users.php');
    //                 }

    //             }//if delete variable true


    //     }//if sql
    // }
    // else{

    //     $delete_user=mysqli_query($con,"DELETE from users where u_id='$uid'");

    //     if($delete_user){
    //         $delete=true;
    //     }

    //     if($delete == true){

    //         $mail=new PHPMailer(true);

    //                 $mail->IsSMTP();
                                    
    //                 $mail->Mailer="smtp";
        
    //                 $mail->SMTPDebug =0;
    //                 $mail->SMTPAuth =TRUE;
    //                 $mail->SMTPSecure ='tls';
    //                 $mail->Port =587;
    //                 $mail->Host ="smtp.gmail.com";
    //                 $mail->Username ="mistrymadan699@gmail.com";
    //                 $mail->Password ="qmskesryhgwkihzw";
        
    //                 $mail->SetFrom('mistrymadan699@gmail.com','Auction System');
    //                 $mail->addAddress($email);
    //                                             // $mail->addAddress($email,$name);
        
    //                 $mail->IsHTML(true);
    //                 $mail->Subject ="Your Account is Removed from System";
    //                 $mail->Body ="Your Account is Removed from System";
    //                 $mail->AltBody ="Hello User Your Account is Removed from System for Registering with Incomplete Data....";
    //                 $mail->MsgHTML("<h1>Hello User Your Account is Removed from System for Registering with Incomplete Data....</h1>");
        
    //                 if(!$mail->Send()){
    //                     echo "Error Sending Mail";
    //                 }
    //                 else{
    //                     header('location:../users.php');
    //                 }


    //     }

    //     // $sql6=mysqli_query($con,"DELETE from users where u_id='$uid'");
    //     // $sql6=mysqlinmnnnnnnbnJJKKKk_query($con,"DELETE from users where u_id='$uid'");
    // }

    // if(mysqli_num_rows($auction_id) > 0){



        // $auction=mysqli_query($con,"SELECT * from auction where a_id='$aid'");

        // $auction_data=mysqli_fetch_assoc($auction);




        // //if user in wining bid than this condition become true
        // if($auction_data['wining_bidder'] == $uid){

            // $remove_bid=mysqli_query($con,"DELETE from bids where u_id=$uid");

            // if($remove_bid){

                // fetching other highest bidder details
                // $sql3=mysqli_query($con,"SELECT * from bids where a_id='$aid' and u_id='$uid'");

                // if($sql3){

                //     $num=mysqli_num_rows($sql3) > 0;


                //     while($row2=mysqli_fetch_assoc($sql3)){


                //         $bids[]=$row2['bid_amount'];
            
                        // if($row['bid_amount'] < $userbid){
            
                        //     $bid_amount=$row['bid_amount'];
            
                            // $winning_bidder=$row['u_id'];
            
                        //     // echo $winning_bidder;
            
                        //     break;   
                        // }
            
                    // }
                    // // $a=0;
            
                    

                    // echo $highbid;
                    

                    // if($winning_bidder != $uid){

                        // echo $winning_bidder;
            
                        // echo $highbid;
            
                        // echo "jsjjsdk";
            
                        // if($sql4 && $delete){
            
                        //     $sql5=mysqli_query($con,"DELETE from users where u_id='$uid'");
            
                        //     if($sql5){
            
                        //         header('location:../users.php');
            
            
                        //     }else{
            
                        //         echo "Record Not Deleted";
            
                        //     }
            
                        // }else{
                        //     echo "Record Not Deleted";
                        // }
            
        //             }

        //         }
        //         else{

        //             $sql=mysqli_query($con,"SELECT * from auction where u_id='$uid'");

        //             if($sql){
        //                 echo true;
        //             }

        //             $sql4=mysqli_query($con,"UPDATE auction SET current_bid=0,wining_bidder=0 where a_id='$a_id' AND wining_bidder='$uid'");
        //             $delete=mysqli_query($con,"DELETE from products where owner='$uid'");
            
        //             if($sql4 && $delete){
            
                       
        //             }
                    

        //         }

        //     // }
        //     // else{
        //     //     echo "record not deleted";
        //     // }
            
        // }
        // else{



        // }
        
    // }else{

    //  echo jdkdsk;
    //     $auction=mysqli_query($con,"SELECT * from auction where a_id='$aid'");

    //     if($auction){

    //         $auction_data=mysqli_fetch_assoc($auction);

    //         if($auction_data['wining_bidder'] == $uid){
    //             echo "wne";
    //         }
        
    //     }
    // }
    // else{
        // if($row['owner'] == $uid){

        //     $sql6=mysqli_query($con,"DELETE from products where owner='$uid'");

        //     if($sql6){

        //         $delete=mysqli_query($con,"DELETE from users where u_id='$uid'");

        //         if($delete){
        //             header('location:../users.php');
        //         }
        //     }
        // }
        // else if($data['account_status'] == '0'){

        //     $sql6=mysqli_query($con,"DELETE from users where u_id='$uid'");

        //     if($sql6){
        //         header('location:../users.php');
        //     }
        //     // $block=mysqli_query($con,"UPDATE users SET account_status='0' where u_id='$uid'");
        // }
        // elseif($data['account_status' == '1']){

        //     $sql6=mysqli_query($con,"DELETE from users where u_id='$uid'");

        //     if($sql6){
                // $mail=new PHPMailer(true);

                // $mail->IsSMTP();
                                
                // $mail->Mailer="smtp";

                // $mail->SMTPDebug =0;
                // $mail->SMTPAuth =TRUE;
                // $mail->SMTPSecure ='tls';
                // $mail->Port =587;
                // $mail->Host ="smtp.gmail.com";
                // $mail->Username ="mistrymadan699@gmail.com";
                // $mail->Password ="qmskesryhgwkihzw";

                // $mail->SetFrom('mistrymadan699@gmail.com','Auction System');
                // $mail->addAddress($email);
                //                             // $mail->addAddress($email,$name);

                // $mail->IsHTML(true);
                // $mail->Subject ="Account is Removed from System";
                // $mail->Body ="Account is Removed from System";
                // $mail->AltBody ="Hello User Your Account is Removed from System for Registering with Incomplete Data....";
                // $mail->MsgHTML("<h1>Hello User Your Account is Removed from System for Registering with Incomplete Data....</h1>");

                // if(!$mail->Send()){
                //     echo "Error Sending Mail";
                // }
                // else{
                //     $sendmail=true;
                // }
        //     }
        // }
    // }

?>