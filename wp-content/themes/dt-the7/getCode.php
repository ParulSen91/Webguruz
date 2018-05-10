<?php
include('/home/proglasscpanel/webguruz.in/wp-content/themes/dt-the7/google-api-php-client/src/Google_Client.php');
include('/home/proglasscpanel/webguruz.in/wp-content/themes/dt-the7/google-api-php-client/src/contrib/Google_CalendarService.php'); 
session_start();
$client = new Google_Client();
$client->setApplicationName("Google Calendar PHP Starter Application");
// Visit https://code.google.com/apis/console?api=calendar to generate your
// client id, client secret, and to register your redirect uri.
 $scopes = "https://www.googleapis.com/auth/calendar";
 $client->setClientId('886799774079-th1h0g3f59kmj5rmhask39umd2jq3l1h.apps.googleusercontent.com');
 $client->setClientSecret('2UBdIBB44r1HdlMjvsjKN66Z');
 $client->setRedirectUri('https://www.webguruz.in/wp-content/themes/dt-the7/getCode.php');
 $client->setDeveloperKey('AIzaSyDDhvJdpkZsyEDcSfjjtC62Qe8Sy3x9bxU');
 $client->setScopes($scopes);
 $cal = new Google_CalendarService($client);
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
   echo $_SESSION['token'] = $client->getAccessToken();
  echo $_SESSION['code'] = $_GET['code'];
 }
?>
 <script type='text/javascript'>
 alert("sdfgdg");
  window.opener.document.getElementById("submit_btn").click();
 // window.close();
 </script>

