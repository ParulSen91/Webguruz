<?php

$url='https://api.hubapi.com/contacts/v1/lists/2687/contacts/all?property=member_code_contacts&property=firstname&property=lastname&property=email&property=phone&property=address&property=suburb&property=zip&property=createdate&property=lead_status_comment&property=reporting_lead_status&property=lead_status_details&property=lead_status_comments&property=listed_amount&property=appraisal_type&hapikey=3f6591c7-fbb3-4d6c-904d-93888e0df23a';

    //  Initiate curl
    $ch = curl_init(); 
    // Disable SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Set the url
    curl_setopt($ch, CURLOPT_URL,$url);
    // Execute
    $result=curl_exec($ch);
    // Closing
    curl_close($ch);
    // Will dump a beauty json :3
    $data = json_decode($result,true);
    //print_r(json_encode($data['contacts']));
    //print_r($data['contacts']);
$ii =0;
foreach($data['contacts'] as $contacts){
echo "<pre>";
 $dataproperty[] = $contacts['properties'];
 $vid[] = $contacts['vid'];
//print_r($contacts['properties']);
}

foreach($dataproperty as $key => $product)
   {
foreach($product as $keys => $searched)
   {
$input = preg_quote(strtolower($_GET['s']), '~');
//array_search($_GET['s'],$searched);
//if ( array_search($_GET['s'],$searched) && $key != $dupliket_key){
$searchedL = array_map('strtolower', $searched);
if ( preg_grep('~' . $input . '~', $searchedL) && $key != $dupliket_key){
         echo $key.'----->';
$dupliket_key = $key; 
echo "<pre>";
//print_r(array_replace($contacts['properties'],$dataproperty[$key]));
//array_replace($contacts['properties'],$dataproperty[$key]);

$n_p[]['properties']=$dataproperty[$key];
$vid['vid']= array('vid' => $vid[$key]);
$n_arr[] = array_merge($n_p[$ii], $vid['vid']);
//$nnarr[] = $n_arr;
//print_r($dataproperty[$key]);
//print_r(json_encode($n_arr));
$ii++;
   }

}

}
//$nnarr[] = $n_arr;
print_r($n_arr);
?>
       
