<?php
// Original Answer
header('Content-Type: application/json');
$request = file_get_contents('php://input');
if ($request!="" || $request != null ){
   $req_dump = print_r( $request, true );
   $fp = file_put_contents( 'request.log', $req_dump ); 
}


// // Updated Answer
// if($json = json_decode(file_get_contents("php://input"), true)){
//   $data = $json;
// }
// print_r($data);
?>