<?php

$conn = new mysqli("localhost", "root", "1bitmysql", "voise") or die(mysqli_error());


define('BASE_URL', "http://13.58.8.234/voise/api/");

define('SONGS_URL', "http://13.58.8.234/voise/songs/");

define('profile_url', "http://13.58.8.234/voise/profile_images/");

define('albums_url', "http://13.58.8.234/voise/covers/");

define('global_email',"jyothi@onebitconsult.com");

define('global_password',"jyothi123");

define('slider_images',"http://13.58.8.234/voise/api/images/slider/");

?>