<?php 
  include "db_conn.php";
  include "validate_access_token.php";
  $i_user=$_SERVER['HTTP_UID'];

  $response = array();
  $params = json_decode(file_get_contents("php://input"));
  
  if(isset($params->playlistname))
    {

      $pname = $params->playlistname;
    
  $sql = "SELECT * FROM playlists WHERE  name = '$pname';";
 
   $result = mysqli_query($conn,$sql);
   
   $count = mysqli_num_rows($result);
  
     if($count>=1)
      {
       $response['api_status']=407;
       $response['message'] = 'With this name playlist already exists,please enter different name';
      }else
        {
       
        $query = "INSERT INTO playlists(i_user,name) VALUES
                  ('$i_user','$pname');";
         $result = mysqli_query($conn,$query);
         $response['api_status']=200;     
         $response['message'] = "playlist created successfully";
      
         }   
      }
        else
     {
      $response['api_status'] = 401;
      $response['message'] = 'fill fields to create playlist';
     }
echo json_encode($response,JSON_UNESCAPED_SLASHES);
?>