<?php

include "db_conn.php";
require "PHPMailerAutoload.php";
require "class.smtp.php";
require "class.phpmailer.php";
if (isset($_REQUEST['email']) && isset($_REQUEST['key']))
{

$email = $_REQUEST['email'];
$key = $_REQUEST['key'];
$verify_email =1;

  
  $sql = "SELECT * FROM users WHERE email = '$email' AND pass_recovery_key = '$key' AND email_verified = '0'";
  $result = mysqli_query($conn,$sql);
  
  $count = mysqli_num_rows($result);
  if($count >=1)
  {
    $sql1 = "UPDATE users  SET email_verified = '1' WHERE email = '$email' AND pass_recovery_key = '$key'";
    if(mysqli_query($conn,$sql1))
      {
            echo '<h3><style="color:#4cab13;text-align:center"> Email verified successful</h3>';
            return;
      }
  
  }
  else{
    $response['message'] = "Invalid information"; 
  }

}

else
 {

$response = array();
$params = json_decode(file_get_contents("php://input"));

if(!empty($params->email) && !empty($params->password) && !empty($params->firstname) && 
  !empty($params->lastname))
{
   $response['api_status']=200;
    $email = strtolower($params->email);
   $firstname = $params->firstname;
   $lastname = $params->lastname;
   $psd = $params->password;
   $password = hash('sha256',$psd);
   $bandname = $params->bandname;
   $access_token = bin2hex(openssl_random_pseudo_bytes(16));
   $key = md5(uniqid(rand(), true));
   
 
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $response['api_status']=403;
      $response['message']='EMAIL address format error'; 
      return;
    }else{ 
       
    $sql = "SELECT * FROM users WHERE email = '$email';";
    $emailDB = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($emailDB);
    
     if($count >=1) 
     {
      
       $response['api_status']=404;
       $response['message']='This email address is already in use';
        
       }
     else
      {
    
       if(!empty($params->bandname))
          {
            $response['api_status']=200;
             $query = "INSERT INTO users(email,firstname,lastname,password,access_token,pass_recovery_key)
                       VALUES('$email','$firstname','$lastname','$password','$access_token','$key');";
             $insrtDB= mysqli_query($conn,$query);
             
          }else
          {
            $response['api_status']=200;
             $query1 = "INSERT INTO users(email,firstname,lastname,password,access_token,pass_recovery_key)
                       VALUES('$email','$firstname','$lastname','$password','$access_token','$key');";
            $insrtDB1 = mysqli_query($conn,$query1); 
            
          }

           // verification mail
 
    $to = $email;
    $subject = "Voise.com-Email verification";
    $messageBody ='<h3>WELCOME TO VOISE!</h3><br>'.'click the link to verify your email address <br>'. 
                    BASE_URL.'signup.php?verify_email=1&key='.$key.'&email='.$email ;
          
       
     $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // authentication enabled
            $mail->IsHTML(true); 
            $mail->SMTPSecure = 'ssl';//turn on to send html email
            // $mail->SMTPDebug = 3;
            $mail->Host = "p3plcpnl0749.prod.phx3.secureserver.net";
            $mail->Port = 465;
            $mail->Username = global_email;
            $send_email = global_email;
            $mail->Password = global_password;
            $mail->SetFrom(global_email, "VOISE-password change");
            $mail->Subject = $subject;
            
            $mail->Body = $messageBody;
            $mail->AddAddress($to);
            
      if ($mail->Send()) {
               $response['api_status'] = 200;
                 $response['message'] = "Email has been sent to your email id";
            } else {
               
                $respose['api_status']= 409;
                 $response['message'] = "Could not send email to your email id";
             }
       }
   }
}

 
else
{
  $response['api_status']=401;
  $response['message']="please fill all the required fields";
    
}
}
echo json_encode($response,JSON_UNESCAPED_SLASHES);

?> 