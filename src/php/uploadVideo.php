<?php


cors();
$image = '';
$data = json_decode(file_get_contents('php://input'), true);
echo $data;

if(isset($_FILES['file']['name']))
{
 $file_name = $_FILES['file']['name'];
 $valid_extensions = array("mp4");
 $extension = pathinfo($file_name, PATHINFO_EXTENSION);
 
 if(in_array($extension, $valid_extensions))
 {
	$upload_name = time() . '.' . $extension;
  
  $curl = curl_init();

//CURLOPT_URL aendern
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://servicemanagementstorage.blob.core.windows.net/asset-19c4d96c-8ead-4caa-ab84-ed2992da4fd7/storkVideo.'. $extension .'?sv=2020-08-04&ss=bfqt&srt=sco&sp=rwdlacupix&se=2023-06-03T00:24:34Z&st=2022-06-02T16:24:34Z&spr=https&sig=mOcfWktauhyapYX7y15xOkckhlRKX6cbM7h5PcrmFbE%3D',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_POSTFIELDS => file_get_contents($_FILES['file']['tmp_name']),
  CURLOPT_HTTPHEADER => array(
    'x-ms-blob-type: BlockBlob',
	'Content-Type:video/mp4'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;


}
}

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

