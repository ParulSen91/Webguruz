<?php
include('/home/proglasscpanel/webguruz.in/wp-content/themes/dt-the7/google-api-php-client/src/Google_Client.php');
include('/home/proglasscpanel/webguruz.in/wp-content/themes/dt-the7/google-api-php-client/src/contrib/Google_CalendarService.php'); 
session_start();
$client = new Google_Client();
$client->setApplicationName("Google Calendar PHP Starter Application");
// Visit https://code.google.com/apis/console?api=calendar to generate your
// client id, client secret, and to register your redirect uri.
 $scopes = "https://www.googleapis.com/auth/calendar";
 $client->setClientId('815643845335-ri6eacdm3jr9k0qmovue3gvodu2lf6ai.apps.googleusercontent.com');
 $client->setClientSecret('HD2pRRgnap_lxa4c1xcH6u_m');
 $client->setRedirectUri('https://www.webguruz.in/getCode.php');
 $client->setDeveloperKey('AIzaSyArGC0g2prfDurObUZzaM9qWQfh83HNnj4');
 $client->setScopes($scopes);
 $cal = new Google_CalendarService($client);
 echo'<pre>';
 print_r($client);
 echo 'rtrtr'.$client->getAccessToken();
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
   echo $_SESSION['token'] = $client->getAccessToken();
  echo $_SESSION['code'] = $_GET['code'];
 }
?>
 <script type='text/javascript'>
 /*alert("sdfgdg");
  window.opener.document.getElementById("submit_btn").click();*/
 // window.close();
 </script>

