<?php
    include "../../config/connect.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require '../../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
    require '../../vendor/autoload.php';

    $complaintid=$_GET['complaint_id'];
    $decline=$_GET['decline'];
    $completed=$_GET['completed'];
    $delete=$_GET['delete'];

    $fetch_complaint=mysqli_query($con,"SELECT * from complaints where complaint_id='$complaintid'");
    $row=mysqli_fetch_assoc($fetch_complaint);
    $uid=$row['u_id'];

    //fetching user email
    $sql=mysqli_query($con,"SELECT email from users where u_id='$uid'");
    $row2=mysqli_fetch_assoc($sql);
    $email=$row2['email'];
    
    if($delete == 'true'){
        $deleteComplaint=mysqli_query($con,"DELETE from complaints where complaint_id='$complaintid'");

        if($deleteComplaint){
            header('location:../complaints.php');
        }
    }
    elseif($decline == 'false'){

        $update=mysqli_query($con,"UPDATE complaints SET status='accepted' where complaint_id='$complaintid'");

        if($update){

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
                    $mail->Subject ="Complaint Accepted";
                    $mail->Body ="Complaint Accepted";
                    $mail->AltBody ="Your Registered Complaint is Accepted.";
                    $mail->MsgHTML("<h3>Your Registered Complaint is Accepted By the System.<br><br>We will take the further actions.</h3>");

                    if(!$mail->Send()){
                        echo "Error Sending Mail";
                    }
                    else{
                        header('location:../complaints.php');
                    }
        }
?>
        <script>
            alert('Try again later...!!!');
            location.href='../complaints.php';
        </script>
<?php

    }
    else if($decline == 'true'){

        $update=mysqli_query($con,"UPDATE complaints SET status='declined' where complaint_id='$complaintid'");

        if($update){

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
                    $mail->Subject ="Complaint Declined";
                    $mail->Body ="Complaint Declined";
                    $mail->AltBody ="Your Registered Complaint is Declined.";
                    $mail->MsgHTML("<h1>Your Registered Complaint is Declined.</h1>");

                    if(!$mail->Send()){
                        echo "Error Sending Mail";
                    }
                    else{
                        header('location:../complaints.php');
                    }
        }
?>
        <script>
            alert('Try again later...!!!');
            location.href='../complaints.php';
        </script>
<?php
    }
    else if($completed == 'true'){

        $update=mysqli_query($con,"UPDATE complaints SET status='completed' where complaint_id='$complaintid'");

        if($update){

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
                    $mail->Subject ="Complaint Completed";
                    $mail->Body ="Complaint Completed";
                    $mail->AltBody ="Your Registered Complaint is observed and Action is taken by the system.";
                    $mail->MsgHTML("<p>Your Registered Complaint is observed and Action is taken by the system.</p><br><br>");

                    if(!$mail->Send()){
                        echo "Error Sending Mail";
                    }
                    else{
                        header('location:../complaints.php');
                    }
        }
?>
        <script>
            alert('Try again later...!!!');
            location.href='../complaints.php';
        </script>
<?php


    }

?>