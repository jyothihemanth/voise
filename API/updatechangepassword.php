<?php

include 'db_conn.php';
include "validate_access_token.php";
$i_user=$_SERVER['HTTP_UID'];
$token=$_SERVER['HTTP_TOKEN'];
$response = array();
$params = json_decode(file_get_contents("php://input"));

if(!empty($params->current) && !empty($params->change_pass))
 
 {
     
     $current = $params->current;
     $cpassword = hash('sha256',$params->current);
     $change_pass = $params->change_pass;
     
       
            $sql1 = "SELECT * FROM users WHERE i_user = '$i_user' AND access_token = '$token';";
            $emailDB = mysqli_query($conn,$sql1);
            $count1 = mysqli_num_rows($emailDB);
             while($row = mysqli_fetch_assoc($emailDB))
             {
                $expassword = $row['password'];
             }
             if($count1 >=1) 
              {
                    
                    if($cpassword == $expassword)
                   {
                      
                        $password = hash('sha256',$params->change_pass);
                        
                      $sql = "UPDATE users  SET password = $password WHERE i_user = '$i_user' AND access_token = '$token'";  
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
               else
               {
               $response['api_status']= 402; 
               $response['message']="Sorry!!entered email doesnot exists.Please sighup";
               
               }
        } 
      
        else{

 
             $response['api_status'] = 401;
             $response['message'] = "Please fill all the fields";


        }    


  echo json_encode($response,JSON_UNESCAPED_SLASHES);

  ?>