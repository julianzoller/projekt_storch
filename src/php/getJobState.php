<?php

function cors() {
  // Allow from any origin
  if (isset($_SERVER['HTTP_ORIGIN'])) {
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
      header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
      header('Access-Control-Allow-Credentials: true');
      header('Access-Control-Max-Age: 86400');    // cache for 1 day
  }

  // Access-Control headers are received during OPTIONS requests
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
          // may also be using PUT, PATCH, HEAD etc
          header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");

      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
          header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");

      exit(0);
  }
}

cors();

$data = json_decode(file_get_contents('php://input'), true);

// Hier sollte eine Verschlüsselung genutzt werden
if($data["pwd"] == "projectStork"){
  $token = $data["token"];


  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://management.azure.com/subscriptions/2fcfec14-21fd-4315-871d-f02b6e4aff1e/resourceGroups/ServiceManagementRG/providers/Microsoft.Media/mediaServices/servicemanagementkonto/transforms/TagsTransform/jobs/APIJob?api-version=2021-11-01',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'Authorization: Bearer ' . $token
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  echo $response;
}
else{
  echo "Authentication failed";
}