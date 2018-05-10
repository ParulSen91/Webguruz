<?php
$json = file_get_contents('https://api.pipedrive.com/v1/persons?api_token=12dcfbd735dac9c64305fd71aa599734eacbdd43');
$objs = json_decode($json);
//print_r($objs);
//$objs->access_token;
$i=0;
foreach($objs as $obj){
foreach($obj as $data){
echo "==========<br>";
//print_r($data);
echo "ID:- ".$data->id ."<br>";
echo "Name:- ".$data->name ."<br>";
foreach($data->phone as $phone){
echo "Phone:- ". $phone->value ."<br>";
}
foreach($data->email as $email){
echo "Email:- ".$email->value ."<br>";
}

echo "==========";
}
}
?>
