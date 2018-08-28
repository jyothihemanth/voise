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
  
   $sql ="SELECT a.i_album,a.name,a.image_link,s.i_song            
        FROM  albums a,songs s
        WHERE a.i_album = s.i_album";

        if ($items) $sql = $sql . " and a.name LIKE '%$items%'";
        
        $result1=mysqli_query($conn,$sql);
        $count = mysqli_num_rows($result1);
          $response['albums'] = array();
        while($row1 = mysqli_fetch_assoc($result1))
        {
        
        	$albums= $row1;
         
          array_push($response['albums'],$row1);
       
        }

        $sql2 ="SELECT a.i_album,a.name,a.image_link,s.i_song            
        FROM  albums a,songs s
        WHERE a.i_album = s.i_album";
        if ($items) $sql2 = $sql2 . " and s.name LIKE '%$items%'";
           
          $result2=mysqli_query($conn,$sql2);
        $count = mysqli_num_rows($result2);
        
          $response['songs'] = array();
        while($row2 = mysqli_fetch_assoc($result2))
        {
          $albums= $row2;
         
          array_push($response['songs'],$row2);
       
        }

        // $sql3 ="SELECT a.i_album,a.name,a.image_link,s.i_song            
        // FROM  albums a,songs s
        // WHERE a.i_album = s.i_album";
        // if ($items) $sql3 = $sql3 . " and s.artist_name  LIKE '%$items%'";
          
        //   $result3=mysqli_query($conn,$sql3);
        // $count = mysqli_num_rows($result3);
        
        //   $response['artist'] = array();
        // while($row3 = mysqli_fetch_assoc($result3))
        // {
        
        //   $albums= $row3;
         
        //   array_push($response['artist'],$row3);
       
        // }
        
         $sql4 ="SELECT a.i_album,a.name,a.image_link,s.i_song            
        FROM  albums a,songs s
        WHERE a.i_album = s.i_album";
        if ($items) $sql4 = $sql4 . " and s.genre  LIKE '%$items%'";
           

          $result4=mysqli_query($conn,$sql4);
        $count = mysqli_num_rows($result4);
        
          $response['genre'] = array();
        while($row4 = mysqli_fetch_assoc($result4))
        {
        
          $albums= $row4;
         
          array_push($response['genre'],$row4);
       
        }



      }  

      echo json_encode($response,JSON_UNESCAPED_SLASHES);  
       ?>