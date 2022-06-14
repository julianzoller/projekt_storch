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
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://login.microsoftonline.com/93b48fa4-1e1d-4c49-9afb-74c7d7b8f348/oauth2/token',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_POSTFIELDS => 'grant_type=client_credentials&client_id=c896127a-8e3e-456c-9a55-716d6be582ed&client_secret=5Mg8Q~QxpMyBK7Slk-6JJKIOJ7TDCXyht~hkgbdY&resource=https%3A%2F%2Fstorage.azure.com',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/x-www-form-urlencoded',
      'Cookie: fpc=AgDCcjfe3W1KnjWOH4CxxdiBbSMTAQAAAA_8ONoOAAAA; stsservicecookie=estsfd; x-ms-gateway-slice=estsfd'
    ),
  ));

  $response = curl_exec($curl);
  curl_close($curl);
  if(strpos($response, "error")){
    echo "Authentication failed, wrong credentials or wrong account settings!";
  }
  else{
    echo $response;
  }
}
else{
  echo "Authentication failed";
}