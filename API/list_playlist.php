<?php
  include "db_conn.php";
    include "validate_access_token.php";
    $i_user=$_SERVER['HTTP_UID'];

     $response = array();
  $params = json_decode(file_get_contents("php://input"));

  
            
        $sql = "SELECT i_playlist, name as playlist_name from playlists where i_user=$i_user";
      $result = mysqli_query($conn,$sql);

            $response['list_playlist']= array();
            while($row = mysqli_fetch_assoc($result))
            {
               
                $list_playlist = $row;
          
                array_push($response['list_playlist'],$row);
                            
            }
               
            echo json_encode($response,JSON_UNESCAPED_SLASHES);
      
      
     

?>


