<?php

include "db_conn.php";

$response = array();
$params = json_decode(file_get_contents("php://input"));

if (isset($_REQUEST['email']) && isset($_REQUEST['key']) && isset($_REQUEST['id']))
 {
 $email = $_REQUEST['email'];
 $i_user = $_REQUEST['id'];
 $key = $_REQUEST['key'];

  $sql1 = "SELECT * FROM users WHERE email = '$email' AND pass_recovery_key ='$key' AND i_user = $i_user";
            $emailDB = mysqli_query($conn,$sql1);                       
            $count1 = mysqli_num_rows($emailDB);
           
             if($count1 >=1) 
              {
                 // echo "valid user";

               }else{
                    echo "This link is already used,try password recovery procedures once again";
                    return;
               }

 }else{
echo "Invalid request";
return;
}

if(isset($_POST['submit']))
{
 
 $password = $_POST['password'];
 $cpassword = $_POST['cpassword'];
 if($password === $cpassword)
                   {
                    	
      	                 $password = hash('sha256',$_REQUEST['cpassword']);
      	                  $key = md5(uniqid(rand(), true));
      	                $access_token = bin2hex(openssl_random_pseudo_bytes(16));
                     	$sql = "UPDATE users  SET password = '$password', access_token = '$access_token', pass_recovery_key = '$key' WHERE email = '$email' AND i_user = '$i_user'";  
                        if($result = mysqli_query($conn,$sql));
                        
                         {
                            $response['api_status']=200;
                            $response['message']="Your password updated successfully";
                          
                         }
                         
                    }
                    else
                    {
      	                    $response['api_status']= 407;
      	                    $response['message']="Password mismatch,please enter same password";
                         	
                    }

}
 
	?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Voise - email verfication </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/fav.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/material-design-iconic-font.min.css">
<!--===============================================================================================-->

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method = "post">
					
					<span class="login100-form-title p-b-26">
						<i class="zmdi "> <img src="images/voise_logo.png" width="auto" height="100px"></i>
					</span>
					<span class="login100-form-title p-b-48">
						Voise
					</span>
					<span class="login100-form-title1 p-b-20" class= "text_subheading">
						Create New Password
					</span>
					<span class="login100-form-title1 p-b-20" style="color:#737272;"><?php  echo $response['message']; ?></span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
						<input class="input100" type="text" name="password" 
						 minlength="6" required>
						<span class="focus-input100" data-placeholder="New Password"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Repeat password" minlength="6" required>
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="cpassword">
						<span class="focus-input100" data-placeholder="Repeat Password"></span>
					</div>
					

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<input type = "submit" id="submit" name="submit" value="submit" class="login100-form-btn" style="background: transparent;font-size:14px;">
								
							
						</div>

					<!--<div class="text-center p-t-115">
						<span class="txt1">
							Don’t have an account?
						</span>

						<a class="txt2" href="#">
							Sign Up
						</a>
					</div>-->
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	

	<script src="js/main.js"></script>

</body>
</html>