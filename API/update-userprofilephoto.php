<?php
include "db_conn.php";
 include "validate_access_token.php";

 
 $i_user=$_SERVER['HTTP_UID'];
 $token=$_SERVER['HTTP_TOKEN'];
$response = array();

// $queryc = "SELECT * FROM users WHERE access_token ='$token' AND i_user='$i_user'";
//   $result1 = mysqli_query($conn,$queryc);
//   $count = mysqli_num_rows($result1);
//  while($row = mysqli_fetch_assoc($result1))
//  {
//    $i_user = $row['i_user'];
//  }

//  if($count>=1)
//    { 

      $file_name="";
      
      if($_FILES['image']["name"])
        $file_name = $_FILES['image']['name'];
      
      if (trim($file_name) != "") 
      {
       $ext = pathinfo($file_name,PATHINFO_EXTENSION);
      $file_name = $i_user . "." . $ext;
    
      $photo_url="http://13.58.8.234/voise/profile_images/".$file_name;
      echo $photo_url;
      $query = "update users set profile_image_link = '" . $photo_url . "' where i_user=$i_user";
      
      mysqli_query($conn,$query);
      $target_path = "../profile_images/";
      $target_path = $target_path . $file_name;
      if($ext = "jpg" && $ext = "png" && $ext = "jpeg"
           && $ext = "gif" )
         {
            $move=move_uploaded_file($_FILES['image']['name'], $target_path);
            if($move){
                   
                    $tmpmove="/var/www/html/voise/profile_images/".$file_name;
                    }
              $sql = "SELECT profile_image_link FROM users WHERE i_user = ‘$i_user’ AND access_token = ‘$access_token’";
            
                $result1 = mysqli_query($conn,$queryc);
                $count = mysqli_num_rows($result1);
                $response['data'] = array();
                while($row = mysqli_fetch_assoc($result1))
                 {
                  $url = $row['profile_image_link'];
                  // $response = $url;
                   array_push($response['data'],$url); 
                 }
         }
         else
         {
         $response['message']="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
     }
   // }else{
   //   echo "invalid user";
   // }
   // else{
   //   echo "required fields are missing";
   // } 
        echo json_encode($response,JSON_UNESCAPED_SLASHES);  
?>
