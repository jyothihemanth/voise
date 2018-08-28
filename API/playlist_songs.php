<?php
    include "db_conn.php";
    include "validate_access_token.php";
     $i_user=$_SERVER['HTTP_UID'];

  
       // $conn = new mysqli("localhost", "root", " ", "voise") or die(mysqli_error());
    $response = array();
  $params = json_decode(file_get_contents("php://input"));
  
  if(isset($params))
  {
      // $i_user = $params->i_user;

      $i_playlist = $params->i_playlist;

       $sql = "SELECT name as playlist_name,i_playlist from playlists  where i_playlist = $i_playlist AND i_user = $i_user";
       
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result))
        {
         $playlist_name = $row['playlist_name'];         
        $i_playlist = $row['i_playlist'];
        }
     
        $sql1 = "SELECT i_song FROM playlist_songs WHERE i_playlist =$i_playlist";
      
        $result1 = mysqli_query($conn,$sql1);

        while($row1 = mysqli_fetch_assoc($result1))
        {
         
         $sqlArray[] = $row1['i_song']; 

        } 

           if($sqlArray == null)
             {
                $response['playlist_info'] =array();
                $display_playlist['playlist'] = array();
               //  $response['playlist_name'] = $playlist_name;
               // $response['playlist_name'] = $i_playlist;
                $playlist['playlist_name'] =  $playlist_name;
                $playlist['i_playlist'] =  $i_playlist;
                $display_playlist['playlist'] = $playlist;
                array_push($response['playlist_info'],$display_playlist['playlist']);

             } else{

           $allid = implode(',', $sqlArray);
   
       $sql2 = "SELECT a.i_album,a.name as album_name,s.i_song,s.name as song_name,CONCAT(u.firstname,' ',u.lastname) as artist_name from albums a,songs s,users u where u.i_user = s.i_user AND a.i_album = s.i_album AND s.i_song IN ($allid)";
      
        $result2 = mysqli_query($conn,$sql2);
        $response['playlist_info'] =array();
                $display_playlist['playlist'] = array();
               
                $playlist['playlist_name'] =  $playlist_name;
                $playlist['i_playlist'] =  $i_playlist;
                $display_playlist['playlist'] = $playlist;
                array_push($response['playlist_info'],$display_playlist['playlist']);
        
        $response['songs_list'] =array();
         
         $display_songs['songs_list'] = array();
         
        while($row2=mysqli_fetch_assoc($result2))
        {
           // $res['i_playlist'] = $i_playlist;
           // $res['playlist_name'] = $playlist_name;
          $res['i_album'] = $row2['i_album'];
          $i_album = $row2['i_album'];
          $res['album_name'] = $row2['album_name'];
          $res['album_cover']=albums_url .$i_album.".jpg";
          $res['i_song'] = $row2['i_song'];
          $i_song = $row2['i_song'];
          $res['song_name'] = $row2['song_name'];
          $res['artist_name'] = $row2['artist_name'];
          $purchased = "SELECT * from purchased_songs WHERE i_song = $i_song AND i_user =$i_user";
          $result=mysqli_query($conn,$purchased);
          $count2 = mysqli_num_rows($result);
           if($count2>=1)
           {
                 $res['song_link']=SONGS_URL.$i_song.".mp3";
                 

           }else{
                     $res['song_link']=SONGS_URL.$i_song."_short.mp3";
                     
           }

           
          $display_songs['songs_list'] = $res;
          
                  array_push($response['songs_list'],$display_songs['songs_list']);

        }
    }
         
}
else
{
  $response['message'] = "Required fields are missing";
}

echo json_encode($response,JSON_UNESCAPED_SLASHES);  
?>

