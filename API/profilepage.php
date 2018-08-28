<?php
include "db_conn.php";


$response = array();
$params = json_decode(file_get_contents("php://input"));

if(isset($params))
{
	$i_user = $params->i_user;
	$sql = "SELECT i_user,password,email,firstname,lastname,profile_image_link,bandname,twitter_link,facebook_link,reddit_link,instagram_link,youtube_link,cloud_link,slack_link,telegram_link FROM users WHERE i_user='$i_user'";
	$result = mysqli_query($conn,$sql);
	
	
	while($row = mysqli_fetch_assoc($result))
	{
		$response = $row;
	}

echo json_encode($response,JSON_UNESCAPED_SLASHES); 

}
?>