<?php
include_once("/var/www/html/13/dalalstreet13/main/facebooklogin/fbaccess1.php");
$app_id = "483287491731006";
$app_secret = "e3e3a46ab049bc9fdd9e162fb0f798ba";
if($access_token!=NULL) {
     $graph_url = "https://graph.facebook.com/me/permissions?method=delete&access_token=" .$access_token;

     $result = json_decode(file_get_contents($graph_url));
     if($result) {
       session_destroy();
       echo ("You have successfully logged out ! Click <a href=\"http://www.facebook.com/logout.php?next=http://www.pragyan.org/13/dalalstreet13/main/facebooklogin/new.php&access_token=" . $access_token . "\">here</a> to goto your facebook account.");
       //  session_destroy();
	 // echo("User is now logged out.");
     }
} else {
  echo("User already logged out.");
}
//unset ($_SESSION['fb_483287491731006_code']);
//unset ($_SESSION['fb_483287491731006_access_token']);
//unset ($_SESSION['fb_483287491731006_user_id']);

//echo "You have successfully logged out ! Click <a href='http://www.facebook.com'>here</a> to goto your facebook account.";
?>

