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
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => 'grant_type=client_credentials&client_id=672fb9ef-871f-4cee-a565-c074d793f1b9&client_secret=i7nUyHPbabJ~l-..DrTXjDM4W_7t1RhaeK&resource=https%3A%2F%2Fmanagement.azure.com',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/x-www-form-urlencoded',
      'Cookie: esctx=AQABAAAAAAD--DLA3VO7QrddgJg7Wevr4_SGBL0iS5e6ninw3h5l5Q0UEN1RpI1LE26HxkRK2xHLlwkkw3OTlMOyljZuhSpp86LWwKQ9T3m7nD8fZTkz2wLTb63y2sDXzdUKR1Hosi7-PEfSl7q0LO_KwOPMgeXkivpZep3uW1WbwvEqvAt_IZIJbBIR-dCtjTYB4jz9G30gAA; fpc=AgDCcjfe3W1KnjWOH4CxxdjjxoUsAwAAAJuuKtoOAAAA; stsservicecookie=estsfd; x-ms-gateway-slice=estsfd'
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