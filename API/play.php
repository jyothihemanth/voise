
<?php
 include "db_conn.php";

 include "validate_access_token.php";
 $i_user=$_SERVER['HTTP_UID'];


$response = array();
$params = json_decode(file_get_contents("php://input"));

if(isset($params->i_song))
{
 
	 $i_song = $params->i_song;
          
        $qry = "SELECT * FROM purchased_songs WHERE i_user = '$i_user' AND i_song = '$i_song'";
               
               $res = mysqli_query($conn,$qry);
               $count = mysqli_num_rows($res);
                
               if($count>=1)
               {

                   $song_link = SONGS_URL.$i_song.".mp3";
                   $response['song_link']= $song_link;
               }
               else
               {
                    $song_link = SONGS_URL.$i_song."_short.mp3";
                     $response['song_link']= $song_link;
               }
   }

 echo json_encode($response,JSON_UNESCAPED_SLASHES);
?>




