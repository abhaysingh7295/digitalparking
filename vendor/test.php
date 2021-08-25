 
 

        <?php


function geoLocate($address) {
  try {
    $lat = 0;
    $lng = 0;
    $data_location = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyBQBtfnDTojmSNeI3kVXQVHAMIWNCwNuYI&address=".str_replace(" ", "+", $address)."&sensor=false";
    $data = file_get_contents($data_location);
    usleep(200000);
    $data = json_decode($data);
   // print_r($data);
    if ($data->status=="OK") {
      $lat = $data->results[0]->geometry->location->lat;
      $lng = $data->results[0]->geometry->location->lng;
      if($lat && $lng) {
        return array(
          'status' => true,
          'lat' => $lat, 
          'long' => $lng, 
          'google_place_id' => $data->results[0]->place_id
        );
      }
    } else if($data->status == 'OVER_QUERY_LIMIT') {
      return array(
        'status' => false, 
        'message' => 'Google Amp API OVER_QUERY_LIMIT, Please update your google map api key or try tomorrow'
      );
    } else {
      return array(
        'status' => false, 
        'message' => $data->error_message
      );
    }
  } catch (Exception $e) {
    return array('lat' => null, 'long' => null, 'status' => false);
  }
  
}


print_r(geoLocate('354-356, Siddharth Nagar, Sector 9, Malviya Nagar, Jaipur, Rajasthan 302017, Jaipur, Rajasthan'));

/* AIzaSyBUcJLgbqTW8OTFS2yKV_SWjgm_BzHwVS4
 $address = '354-356, Siddharth Nagar, Sector 9, Malviya Nagar, Jaipur, Rajasthan 302017';

 $geocodeFromAddr = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&sensor=true_or_false&key=AIzaSyA6G1JAoSMIxclYQZdS4lcjyyB-y_jAVxs';
echo  $geocodeFromAddr; 


 $curl = curl_init();
  curl_setopt_array($curl, array(
    //CURLOPT_PORT => "8080",
    CURLOPT_URL => $geocodeFromAddr,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 50,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Cache-Control: no-cache"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);*/




 

 echo '<pre>'; print_r($response);