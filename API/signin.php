<?php

include "db_conn.php";

$response = array();
$params = json_decode(file_get_contents("php://input"));


if (!empty($params->email) && !empty($params->password))
 {
    
    $email = strtolower($params->email);
    
    $password=$params->password;
    $pass = hash('sha256',$password);
   
    $query = "SELECT * FROM users WHERE email='$email' AND  password ='$pass' AND email_verified = '1'";
    $result = mysqli_query($conn,$query);
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
     
      if($count >= 1) 

          { 
            $response['data']=array();
            $data['id'] = $row['i_user'];
            $data['email'] = $row['email'];
            $data['eth_address']=$row['eth_wallet'];
            $response['api_status'] = 200;   
            $response['message']= "Login successfull";
            $sql = "SELECT access_token FROM users WHERE email='$email' AND password='$pass'";
            $result= mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($result);             
            $data['a_tok'] = $row['access_token'];
            array_push($response['data'],$data);

          }
        
      else{
                   $response['api_status'] = 401;
                   $response['message']="Invalid credentials or email not verified";
                               
          }
    
       
  }
  else 
  {
      $response['api_status'] = 400;
     $response['message']="Required fields are missing";
     
  }

      
  echo json_encode($response,JSON_UNESCAPED_SLASHES);    

   ?>