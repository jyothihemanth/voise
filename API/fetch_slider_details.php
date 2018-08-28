<?php
include "db_conn.php";
 $response = array();
  $params = json_decode(file_get_contents("php://input"), true);

  

$sqlCommand = "SELECT * FROM featured_details"; 

$result = mysqli_query($conn,$sqlCommand);
$count = mysqli_num_rows($result);
if($count>=1)
{
     $response['slider_images'] = array();
     while ($row = mysqli_fetch_assoc($result)) 
         { 
          
          $slider_images= $row;
         
          array_push($response['slider_images'],$slider_images);
         }
}
  echo json_encode($response,JSON_UNESCAPED_SLASHES);

?>