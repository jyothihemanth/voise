<?php
include "db_conn.php";
 include "validate_access_token.php";

$response = array();
$params = json_decode(file_get_contents("php://input"));

if(empty($params->items))
{
$response['api_status']=401;
$response['message']= 'required fields are missing';
}else
{
 
 $items = $params->items;
 
 $sql ="SELECT a.i_album,a.name as album_name,CONCAT(u.firstname,' ',u.lastname) as artist_name FROM albums a,users u WHERE u.i_user = a.i_user AND u.admin_verified = 1 AND a.name LIKE '%$items%'";
   
        $result1 = mysqli_query($conn,$sql);
         $display_albums['albums'] =array();
        $response['albums'] = array();
         while($row1 = mysqli_fetch_assoc($result1))
          {
            $i_album=$row1['i_album'];
            $res['i_album']=$row1['i_album'];
            $res['album_name']=$row1['album_name'];
            $res['artist_name']=$row1['artist_name'];
            $res['album_cover']=albums_url .$i_album.".jpg";
             $display_albums['albums'] = $res;
            array_push($response['albums'],$display_albums['albums']);
          }
        
        $sql2 ="SELECT a.i_album,a.name as album_name,s.i_song,s.name as song_name,CONCAT(u.firstname,' ',u.lastname) as artist_name FROM albums a,songs s,users u WHERE (a.i_album = s.i_album AND s.name LIKE '%$items%') AND (u.i_user = a.i_user AND a.i_user = s.i_user AND u.admin_verified = 1)";
         
          $result2=mysqli_query($conn,$sql2);
          $display_songs['songs'] =array();
          $response['songs'] = array();
        while($row2 = mysqli_fetch_assoc($result2))
        {
          $res['i_album']=$row2['i_album'];
          $res['album_name']= $row2['album_name'];
          $res['i_song']=$row2['i_song'];
          $res['song_name']=$row2['song_name'];
          $res['artist_name']=$row2['artist_name'];
          $res['album_cover']=albums_url .$i_album.".jpg";
          $i_song = $row2['i_song'];
          $purchased = "SELECT * from purchased_songs WHERE i_song = $i_song";
          $result=mysqli_query($conn,$purchased);
          $count2 = mysqli_num_rows($result);
           if($count2>=1)
           {
                 $res['song_link']=SONGS_URL.$i_song.".mp3";
                 

           }else{
                     $res['song_link']=SONGS_URL.$i_song."_short.mp3";
                     
           }

               $display_songs['songs'] = $res;
                 array_push($response['songs'],$display_songs['songs']);

      }

       $sql3 =  "SELECT i_user,CONCAT(firstname,'  ',lastname) as artist_name FROM users WHERE (firstname LIKE '%$items%' OR lastname LIKE '%$items%') AND admin_verified=1";
          
          $result3=mysqli_query($conn,$sql3);
          $count3 = mysqli_num_rows($result3);
           $display_artist['artist'] =array();
          $response['artist'] = array();
        while($row3 = mysqli_fetch_assoc($result3))
        {
             $res['i_user']=$row3['i_user'];
             $i_user = $row3['i_user'];
              $res['artist_name']=$row3['artist_name'];
              $res['profile_url']=profile_url .$i_user.".jpg";
              $display_artist['artist'] = $res;
          array_push($response['artist'], $display_artist['artist']);
       
        }
          

   }  

      echo json_encode($response,JSON_UNESCAPED_SLASHES);  
       ?>


