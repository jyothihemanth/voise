<?php
    include "db_conn.php";
    include "validate_access_token.php";

      
   
     $response = array();
     $params = json_decode(file_get_contents("php://input"));
   
       if(isset($params))
         {
         	$i_song = $params->i_song;
         	$i_playlist = $params->i_playlist;

         $sql = "DELETE FROM playlist_songs WHERE i_song = $i_song AND i_playlist = $i_playlist";

          if(mysqli_query($conn,$sql))
          	 {
                $response['api_status'] = 200;
                $response['message'] = "Song removed from your playlist successfully";

          	 }else
          	 {
                $response['api_status'] = 400;
                $response['message'] = "Sorry!! Couldn't remove song from your playlist";
          
          	 }

          }else
          {
          	$response['message'] = "required fields are missing ";
          }
 echo json_encode($response,JSON_UNESCAPED_SLASHES);
    	
?>