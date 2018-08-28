<?php
  $i_user=$_SERVER['HTTP_UID'];
$token=$_SERVER['HTTP_TOKEN'];


if (($token!='') && ($i_user!=''))
{
   $sql = "SELECT * FROM users WHERE access_token ='$token' AND i_user='$i_user';";
   $result = mysqli_query($conn,$sql);
   $count = mysqli_num_rows($result);

   if($count>=1)
    {
      $response['message'] ="Valid request";
       

    }  else
    {
      $response['message'] = "Invalid request";
      echo json_encode($response,JSON_UNESCAPED_SLASHES);
      die;
    }

}else 
{
  $response['message'] = "Invalid request";
      echo json_encode($response,JSON_UNESCAPED_SLASHES);
      die;
}

?>
    