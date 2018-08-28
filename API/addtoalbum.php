<?php 

  include "db_conn.php";
  require "phpmp3.php";
  $response = array();
  $params = json_decode(file_get_contents("php://input"), true);
  $sqlArray = array(); 
   
    if( @$_POST['i_user'] && @$_POST['i_album']  && @$_POST['artist_name'] && @$_POST['genre'] && @$_POST['price'] && @$_POST['order_number'] && @$_POST['duration'] && is_uploaded_file($_FILES["songs"]["tmp_name"]))
    {

      $i_user = $_POST['i_user'];
      $i_album = $_POST['i_album'];
     
      $artist_name = $_POST['artist_name'];
      $genre = $_POST['genre'];
      $order_number = $_POST['order_number'];
       $duration = $_POST['duration'];
       $price = $_POST['price'];
       $tmp_file = $_FILES["songs"]["tmp_name"]; 
       $song_name = $_FILES["songs"]["name"];

        
        $count = count($song_name);
        $upload_dir = "./song/".$song_name;
        $song_link ="./song/".$song_name;
      
        $move=move_uploaded_file($tmp_file, $upload_dir);
        if($move){
          $tmpmove="./song/".$song_name;
        }
        
        $mp3 = new phpmp3($tmpmove);
      
        $mp3 = $mp3 -> extract(0,30);
      
        
        $save=$mp3->save('./trim/'.$song_name);
        if($save)
        {
          $response['api_status'] = 200;
        }
         $song_link_short ="./trim/ " .$tmp_file;
         $upload_dir_short = "./trim/ " .$song_name;
       
          move_uploaded_file($tmp_file,$upload_dir_short);
          for($i = 0;$i<$count;$i++) 
          {
          $sqlArray[] = "('".$i_user."','".$i_album."','".$song_name."','".$artist_name."','".$genre."','".$price."','".$order_number."','".$duration."','".$song_link."',' " .$song_link_short." ' )";
          }
            $sql = " INSERT INTO songs ( i_user,i_album,song_name,artist_name,genre,price,order_number,duration,song_link,song_link_short) values ".implode(',', $sqlArray);
                  if(mysqli_query($conn,$sql))
               {
                   $response['api_status'] = 200;
                   $response['message'] = "songs are added successfully into your album";
       }else
       {
          $response['api_status'] =400;
          $response['message'] = "sorry!!could not add songs into your album";
       }

          

   }
  else
  {
    $response['message'] = "input correct parameters";
  }
 
 
echo json_encode($response,JSON_UNESCAPED_SLASHES);

?> 