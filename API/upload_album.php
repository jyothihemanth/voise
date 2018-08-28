<?php
  include "db_conn.php";

  $response = array();
  $params = json_decode(file_get_contents("php://input"));

  
  if( is_uploaded_file($_FILES["image"]["tmp_name"]) && @$_POST["album_name"] && @$_POST["year"]) 
  {
    
     	$name = $_POST["album_name"];
     	$year = $_POST["year"];
      
    	$datetime = date_create()->format('Y-m-d H:i:s');
      
      $tmp_file = $_FILES["image"]["tmp_name"]; //get file from client
        $img_name = $_FILES["image"]["name"];
        $upload_dir = "/var/voise/covers" .$img_name;
        $img_path ="/var/voise/covers " .$_FILES["image"]["name"];
        
    // $image_link = 'http://13.58.8.234/voise_website/appimages/album1.png';
  	
    
      $sql = "SELECT album_name FROM albums WHERE album_name = '$name';";
      $result = mysqli_query($conn,$sql);
      $count = mysqli_num_rows($result);
      $row = mysqli_fetch_assoc($result);
      
     
        if($count >=1)
         {
            $response['api_status'] = 404;
            $response['message'] = "With this  name album already exists";
         }
         else
         {
         
           $sql="INSERT INTO albums(album_name,year,upload_date,image_link)
                               VALUES ('$name','$year','$datetime','$img_path');";
           
            if(move_uploaded_file($tmp_file, $upload_dir) && mysqli_query($conn,$sql)){
                $response['api_status']=200;
                $response['message']='album  created successfully';
            }

          }
           
        
  }
  else{
   $response['api_status'] = 401;
   $response['message'] = "required fields are missing";
  }

  echo json_encode($response,JSON_UNESCAPED_SLASHES);
?>