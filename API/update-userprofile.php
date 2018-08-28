<?php
include "db_conn.php";
include "validate_access_token.php";

$response = array();

$params = json_decode(file_get_contents("php://input"));
$i_user=$_SERVER['HTTP_UID'];
$token=$_SERVER['HTTP_TOKEN'];

   
   
    if(isset($params->firstname) || isset($params->lastname) || isset($params->profile_image_link) || isset($params->bandname) || isset($params->twitter_link) || isset($params->facebook_link) || isset($params->reddit_link) || isset($params->instagram_link) || isset($params->youtube_link) || isset($params->cloud_link) || isset($params->slack_link) || isset($params->telegram_link))
     
      {
             
      
        $firstname = $params->firstname;
        $lastname = $params->lastname;
        $bandname = $params->bandname;
        $twitter_link = $params->twitter_link;
        $facebook_link= $params->facebook_link;
        $reddit_link = $params->reddit_link;
        $instagram_link = $params->instagram_link;
        $youtube_link =$params->youtube_link;
        $cloud_link = $params->cloud_link;
        $slack_link = $params->slack_link;
        $telegram_link = $params->telegram_link;
        
                    
            $queryu = "UPDATE users
                         SET bandname ='$bandname',twitter_link = '$twitter_link',instagram_link = '$instagram_link', youtube_link = '$youtube_link',facebook_link = '$facebook_link', reddit_link = '$reddit_link',cloud_link = '$cloud_link',slack_link = '$slack_link',telegram_link = '$telegram_link'
                         WHERE access_token ='$token' AND i_user = '$i_user'";
                    
                        if(mysqli_query($conn,$queryu))   
                         {
                               $response['api_status'] =200;
                                $response['message'] = "Your profile Updated successfully";
                         } else
                         {
                                   $response['api_status'] = 410;
                                 $response['message']="Sorry!!unable to update your profile";
                          }
                   
                        }

                      

                              

    else
      {
        $response['api_status']=402;
        $response['message']=" Required fields missing";
      }
    
  echo json_encode($response,JSON_UNESCAPED_SLASHES);  

?>
