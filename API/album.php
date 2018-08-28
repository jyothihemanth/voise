<?php

	include "db_conn.php";
   include "validate_access_token.php";

	$response = array();
	$params = json_decode(file_get_contents("php://input"));

    if(isset($params->i_album))
    {
         $i_album = $params->i_album;
         
       $sql = "SELECT i_album,name as album_name,image_link FROM albums  WHERE  i_album = '$i_album'";
       
	     $db = mysqli_query($conn,$sql);

         $count = mysqli_num_rows($db);
           if($count >= 1)
             {
                   $response['song_list'] = array();
                  
                   

                while($row = mysqli_fetch_assoc($db))
                   {
                         $res['i_album'] = $row['i_album'];
                       $res['album_name'] = $row['album_name'];
                       $res['album_cover']=albums_url .$i_album.".jpg"; 
                       $display_album['album'] = $res;

                      // $display_album['album'] = $row;
                      // $album[]=$display_album;
                    
                   }

           $sql1="SELECT i_song,name as song_name,str_duration FROM songs  WHERE  i_album='$i_album'";
            // echo $sql1;
           $db1= mysqli_query($conn,$sql1);
           $count1 = mysqli_num_rows($db1);
           
           if($count1 >=1)
             {
         $display_songs['songs'] = array(); 
          
          while($row1 = mysqli_fetch_assoc($db1))
                   {
                     $songs['songs_list']=array();
                     $res['i_song']=$row1['i_song'];
                     $res['song_name']=$row1['song_name'];
                     $res['str_duration']=$row1['str_duration'];
                     $i_song=$row1['i_song'];
                      $res['song_link']=SONGS_URL.$i_song.".mp3";

                       $display_songs['songs'] = $res;
                      //array_push($display_songs['songs'],$res);

                      
                   // array_push( $songs['songs_list'], $display_songs['songs']);
                  array_push($response['song_list'],$display_songs['songs']);
                                           
                   }
                     // array_push($response['data'],$display_album['album'],$display_songs['songs'] );
                   
                    $response['album_details'] =   $display_album['album']; 
                     $response['api_status']=200;    
               }
             else
               {
              $response['message'] = "no songs inside this album";
        
               }

            }
  
       }    

              
   echo json_encode($response,JSON_UNESCAPED_SLASHES);

?>


