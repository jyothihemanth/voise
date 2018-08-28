<?php
  include "db_conn.php";
  include "validate_access_token.php";
  $response = array();
  $params = json_decode(file_get_contents("php://input"));
  
if(isset($params->i_playlist) && isset($params->i_song))
{    
 
     $i_playlist = $params->i_playlist;
     $i_song = $params->i_song;
 
     
        $sql = "SELECT order_number FROM playlist_songs WHERE i_playlist = '$i_playlist' ORDER BY i_playlist_song DESC LIMIT 1";
        $result = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result);
       
         if($count == NULL) 
          {
                       
             $order_number = 1;
             $sql1 = "INSERT INTO playlist_songs(i_song,i_playlist,order_number) VALUES('$i_song','$i_playlist','$order_number');";
              
             if(mysqli_query($conn,$sql1))
              {
              
               $response['api_status']=200;
               $response['message'] = "Songs added successfully";
              } 
              else
              {
               $response['message'] = "Sorry!! could not add songs to playlist";
              }
         }else
        {

            while($row = mysqli_fetch_assoc($result))
             {
               $order_number = $row['order_number'];
              
              }
              $order_number = $order_number+1;
           $sql2 = "INSERT INTO playlist_songs(i_song,i_playlist,order_number) VALUES('$i_song','$i_playlist','$order_number')";
       
            if(mysqli_query($conn,$sql2))
              {
            
	    	      $response['api_status']=200;
	    	      $response['message'] = "Songs added successfully";
	            } 

	            else
	           {
	      	    $response['message'] = "Sorry!! could not add songs to playlist";
	            }
        }
	 
	}
  else
  {
     $response['message'] = "Please select one song to add to your playlist";
  }   

echo json_encode($response,JSON_UNESCAPED_SLASHES);  
 ?>



