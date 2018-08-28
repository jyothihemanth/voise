<?php
  include "db_conn.php";

  $response = array();
  $params = json_decode(file_get_contents("php://input"));
  

  if(isset($params->follow))
    { 
      
      $i_user = $params->i_user;
   
      $session_i_user = $params->session_i_user;
    
       $sql = "INSERT INTO followers(i_follower,i_following) VALUES ('$i_user', '$session_i_user');"; 

       if(mysqli_query($conn,$sql))  
     
             {
                $total_followers = "SELECT count(i_following) FROM followers WHERE i_follower = '$i_user'";
                $result = mysqli_query($conn,$total_followers); 
                $row = mysqli_fetch_row($result);
                $purchased = (int) $row[0];
              
                  $response = $purchased;
            }
  }

   if(isset($params->unfollow))
    { 
      
      $i_user = $params->i_user;
   
      $session_i_user = $params->session_i_user;
    
       $sql = "DELETE  FROM followers WHERE i_following = '$session_i_user' AND i_follower = '$i_user'"; 

       if(mysqli_query($conn,$sql))  
     
             {
                $total_followers = "SELECT count(i_following) FROM followers WHERE i_follower = '$i_user'";
                $result = mysqli_query($conn,$total_followers); 
                $row = mysqli_fetch_row($result);
                $purchased = (int) $row[0];
              
                  $response = $purchased;
            }
  }

    
echo json_encode($response,JSON_UNESCAPED_SLASHES);
   
?>