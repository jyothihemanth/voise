<?php
  include "db_conn.php";
  include "validate_access_token.php";
  $i_user=$_SERVER['HTTP_UID'];
  $response = array();
  $params = json_decode(file_get_contents("php://input"));
  
if(isset($params->i_playlist))
{    
 
     $i_playlist = $params->i_playlist;
    
     $sql = "DELETE FROM playlists WHERE i_playlist = $i_playlist AND i_user = $i_user";
     if(mysqli_query($conn,$sql))
     {
     	$response['message'] = "Your playlist deleted successfully";
     }
     else
     {
     	$response['message'] = "Sorry!! couldn't delete your playlist";
     }
  }   
echo json_encode($response,JSON_UNESCAPED_SLASHES);
?>