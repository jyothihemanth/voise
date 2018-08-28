<?php
include "db_conn.php";
   $response[] = array();
   $params = json_decode(file_get_contents("php://input"));


   $sqlCommand = "SELECT * FROM featured_details"; 

$result = mysqli_query($conn,$sqlCommand);
$count = mysqli_num_rows($result);
if($count>=1)
{
    $response['slider_images'] = array();
    $display_slider['slider_images'] = array();
    while ($row = mysqli_fetch_assoc($result)) 
         { 
            
            $slider_images= $row;
            $response['slider_images'] = $row;
             array_push($response['slider_images'],$slider_images);
         }
 
 $dir = slider_images;
$files = glob("$dir*.jpg", GLOB_BRACE);
echo $files;
// $display_slider['slider_images'] = $files;
//  $response['slider_images'] = $display_slider['slider_images'];
//  array_push($response['slider_images'],$display_slider['slider_images']);
}
 
   
 
  echo json_encode($response,JSON_UNESCAPED_SLASHES);  


  ?>