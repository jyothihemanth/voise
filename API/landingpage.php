<?php
  include "db_conn.php";
  include "validate_access_token.php";
  $i_user=$_SERVER['HTTP_UID'];
  $token=$_SERVER['HTTP_TOKEN'];

  $response = array();
   $trending_albums = array();
  $params = json_decode(file_get_contents("php://input"));
   
        	$new_albums = 
   "SELECT a.i_album,a.name as album_name,CONCAT(u.firstname,' ',u.lastname) as artist_name FROM albums a,users u where a.i_user = u.i_user AND u.admin_verified = 1 order by a.i_album desc limit 20";

          	$result = mysqli_query($conn,$new_albums);
         	 $new_albums = array();
           $response['new']=array();
           $display_albums['albums'] =array();
            while($row = mysqli_fetch_assoc($result))
            {
              
               $i_album=$row['i_album'];
               $res['i_album']=$row['i_album'];
                $res['album_name'] = $row['album_name'];
                $res['artist_name'] = $row['artist_name'];
               $res['album_cover'] =albums_url .$i_album.".jpg";
               $display_albums['albums'] = $res;
              array_push($response['new'],$display_albums['albums']);
           
            }
       
      $trending = "SELECT s.i_song,s.i_album,a.name as album_name,CONCAT(u.firstname,' ',u.lastname) as artist_name  FROM songs s,albums a,users u WHERE s.i_album=a.i_album AND a.i_user = u.i_user AND  u.admin_verified = 1  AND s.order_number<10 LIMIT 0,20";
       $result=mysqli_query($conn,$trending);
          
              $trends =array();
          $response['trending'] = array();
          $display_albums['albums'] =array();
            while($tre = mysqli_fetch_assoc($result))
            {
                 // $response['api_status'] = 200;
                 $i_song=$tre['i_song'];
                 $i_album=$tre['i_album'];
                 $res['i_song'] = $tre['i_song'];
                 $res['i_album'] = $tre['i_album'];
                 $res['album_cover'] =albums_url .$i_album.".jpg";
                 $res['album_name'] = $tre['album_name'];
                 $res['artist_name'] = $tre['artist_name'];
                 $res['song_link']=SONGS_URL.$i_song.".mp3";
                 $display_albums['albums'] = $res;
              array_push($response['trending'],$display_albums['albums']);
             
            }

 echo json_encode($response,JSON_UNESCAPED_SLASHES);
  

?>

 













            



