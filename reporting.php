<?php 
ob_start();
    if(isset($_POST['search']) && !empty($_POST['search'])){
$zname_clean = preg_replace('/\s*/', '', $_POST['search']);
// convert the string to all lowercase
$search = strtolower($zname_clean);
    //header('Access-Control-Allow-Origin: *');
   $url='https://api.hubapi.com/contacts/v1/lists/'.$_POST['code'].'/contacts/all?count=200&property=member_code_contacts&property=firstname&property=lastname&property=email&property=phone&property=address&property=suburb&property=zip&property=createdate&property=lead_status_comment&property=reporting_lead_status&property=lead_status_details&property=lead_status_comments&property=listed_amount&property=appraisal_type&hapikey=3f6591c7-fbb3-4d6c-904d-93888e0df23a';

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
 $dataproperty[] = $contacts['properties'];
 $vid[] = $contacts['vid'];
//print_r($contacts['properties']);
}
foreach($dataproperty as $key => $product)
   {
foreach($product as $keys => $searched)
   {
/*if ( array_search($_POST['search'],$searched) && $key != $dupliket_key){*/
$input = preg_quote(strtolower($_POST['search']), '~');
$searchedL = array_map('strtolower', $searched);
if ( preg_grep('~' . $input . '~', $searchedL) && $key != $dupliket_key){
$dupliket_key = $key; 
$n_p[]['properties']=$dataproperty[$key];
$vid['vid']= array('vid' => $vid[$key]);
$n_arr[] = array_merge($n_p[$ii], $vid['vid']);
//print_r(json_encode($n_arr));
$ii++;
   }

}

}
print_r(json_encode($n_arr));
}
else{
$url='https://api.hubapi.com/contacts/v1/lists/'.$_POST['code'].'/contacts/all?count=200&property=member_code_contacts&property=firstname&property=lastname&property=email&property=phone&property=address&property=suburb&property=zip&property=createdate&property=lead_status_comment&property=reporting_lead_status&property=lead_status_details&property=lead_status_comments&property=listed_amount&property=appraisal_type&hapikey=3f6591c7-fbb3-4d6c-904d-93888e0df23a';

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
    print_r(json_encode($data['contacts']));
    //print_r($data['contacts']);
}


?>
