<?php
  include "db_conn.php";

  $response = array();
  $params = json_decode(file_get_contents("php://input"));
  
  if(isset($params->like_rating))
  	{ 
  		$i_song = $params->i_song;
      
      mysqli_query($conn,"UPDATE songs 
              SET like_rating = like_rating + 1
              WHERE (i_song = '$i_song') ");
     $result = mysqli_query($conn,"SELECT like_rating FROM songs WHERE i_song = '$i_song'");
       while ($row = mysqli_fetch_array($result))
        {
         $response['like'] = " " .$row['like_rating'];
       }

    }
    else if(isset($params->dislike_rating))
     {
     	$i_song = $params->i_song;
     	mysqli_query($conn,"UPDATE songs 
     		           SET like_rating = like_rating - 1
     		           WHERE (i_song = '$i_song')");
       $result = mysqli_query($conn,"SELECT like_rating FROM songs WHERE i_song = '$i_song'");
       while ($row = mysqli_fetch_array($result))
        {
         $response['like'] = " " .$row['like_rating'];
       }


      }
echo json_encode($response,JSON_UNESCAPED_SLASHES);
   
?>