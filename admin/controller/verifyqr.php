<?php    
    include "../../config/connect.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require '../../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
    require '../../vendor/autoload.php';

    $uid=$_GET['u_id'];
    $sql=mysqli_query($con,"SELECT * from users where u_id='$uid'");
    $data=mysqli_fetch_assoc($sql);
    $email=$data['email'];
    $verify=$_GET['verify'];

    if($verify == 'true'){

        $update1=mysqli_query($con,"UPDATE users_imgs SET verify='true' where u_id='$uid'");

        if($sql){

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

                $mail->IsHTML(true);
                $mail->Subject ="QRcode Image is Verified";
                $mail->Body ="QRcode Image is Verified";
                $mail->AltBody ="Hello User.... We Have Been Verified Your QRCode Image.Now You Can Recieve Payment For Products With QRcode Scaning.";
                $mail->MsgHTML("<h1>Hello User.... We Have Been Verified Your QRCode Image.Now You Can Recieve Payment For Products With QRcode Scaning.</h1>");

                if(!$mail->Send()){
                    echo "Error Sending Mail";
                }
                else{
                    header("location:../users.php?u_id=$uid");
                }
        }
    }
    else if($verify == 'false'){

        // echo false;

        $update1=mysqli_query($con,"UPDATE users_imgs SET verify='false',qrcode_pic=null where u_id='$uid'");

        if($sql){

            $mail=new PHPMailer(true);


            $mail->IsSMTP();
                
                $mail->Mailer="smtp";

                $mail->SMTPDebug=0;
                $mail->SMTPAuth=TRUE;
                $mail->SMTPSecure='tls';
                $mail->Port=587;
                $mail->Host="smtp.gmail.com";
                $mail->Username="mistrymadan699@gmail.com";
                $mail->Password="qmskesryhgwkihzw";

                $mail->SetFrom('mistrymadan699@gmail.com','Auction System');
                $mail->addAddress($email);

                $mail->IsHTML(true);
                $mail->Subject ="QRcode Image Removed";
                $mail->Body ="QRcode Image Removed";
                // $mail->AltBody ="Hello User.... We Have Been Removed Your QRCode Image.Upload The QRcode Image.";
                $mail->MsgHTML("<h1>Hello User.... We Have Been Removed Your QRCode Image.Upload Your Original QRcode Image with name.</h1>");

                if(!$mail->Send()){
                    echo "Error Sending Mail";
                }
                else{
                    header("location:../users.php?u_id=$uid");
                }
        }
    }

    // $sql=mysqli_query($con,"SELECT * from users where u_id='$uid'");
?>