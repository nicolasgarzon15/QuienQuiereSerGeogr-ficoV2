<?php

error_reporting(0);
//Automatizacion del token de acceso

function getToken()
{

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.getgo.com/oauth/v2/token',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => 'grant_type=refresh_token&refresh_token=eyJraWQiOiJvYXV0aHYyLmxtaS5jb20uMDIxOSIsImFsZyI6IlJTNTEyIn0.eyJzYyI6ImNhbGxzLnYyLmluaXRpYXRlIG1lc3NhZ2luZy52MS53cml0ZSBpZGVudGl0eTpzY2ltLm9yZyBpZGVudGl0eTpzY2ltLm1lIHJlYWx0aW1lLnYyLm5vdGlmaWNhdGlvbnMubWFuYWdlIG1lc3NhZ2luZy52MS5ub3RpZmljYXRpb25zLm1hbmFnZSBjYWxsLWhpc3RvcnkudjEubm90aWZpY2F0aW9ucy5tYW5hZ2Ugc3VwcG9ydDogcHJlc2VuY2UudjEubm90aWZpY2F0aW9ucy5tYW5hZ2UgbWVzc2FnaW5nLnYxLnNlbmQgaWRlbnRpdHk6IG1lc3NhZ2luZy52MS5yZWFkIHdlYnJ0Yy52MS5yZWFkIHdlYnJ0Yy52MS53cml0ZSBjb2xsYWI6IHVzZXJzLnYxLmxpbmVzLnJlYWQgY3IudjEucmVhZCIsImxzIjoiMTFlM2FjODMtZjg4Zi00ZDUzLWEzMmYtNjU0OGNjYWFmODVjIiwib2duIjoicHdkIiwiYXVkIjoiNThjNjc0YzctNDhjYy00ODY3LTljNWUtNjU0MzNkNzFlMDU3Iiwic3ViIjoiMzAwMDAwMDAwMDAwNDQ2MTIzIiwianRpIjoiNjhiZjg2YWEtZmZiZi00ODA1LTgxYWUtMTgwN2M0NjE0ZDEzIiwiZXhwIjoxNjM0OTIyMzM4LCJpYXQiOjE2MzIzMzAzMzgsInR5cCI6InIifQ.N-EIDi-27TAzX0Y-LUwdmp0LxmkwlMS3pAOtaeR90eKyn7gpEy11zqLLbA5AggeBt6-CtluuGrkZ82-qFw2fFHvxgDYAWssRbTRNgd_JYo7FIHh31jF5VyrH9lIcrULE7FbrM598NuwezYwvbtSjfmx0coCJn_G1Q0TjDDPY0mcn9UqGerOYqdRJt1W8-9-5QObkWKrHO-hvQJTHf9FRhtm-xNv9sYi3_FplFgDDtGrZZZQLPN87fxfhnV5JrCwCHy9Sp9Ryw_Zd43OZZSUVbaCMxzSxuiHI5jPTEfh-Y9a5By-hXjn6iokyQ3vWvuaMfq8XELZHMRsL3ZllJyq8Jw',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/x-www-form-urlencoded',
      'Authorization: Basic NThjNjc0YzctNDhjYy00ODY3LTljNWUtNjU0MzNkNzFlMDU3OjdheEtJSDBza056NVV6MEY0U1BWQ1lhOA=='
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  //echo $response;

  //Obtener token de acceso en una variable 
  $item = json_decode($response, true);
  return $item;
  
}



function conectar()
{

$item = getToken();
$token = $item["access_token"];
$organizerKey = $item["organizer_key"];
$accountsKey = $item["account_key"];
$token2 = "Bearer " . $token;
$urlwebinnars = 'https://api.getgo.com/G2W/rest/v2/organizers/'.$organizerKey.'/webinars?fromTime=2021-06-20T00:00:00Z&toTime=2022-09-21T00:00:00Z&page=0&size=90';



  //OBTENER TODOS LOS WEBINARS 
  
  $curl = curl_init();



curl_setopt_array($curl, array(

  CURLOPT_URL => $urlwebinnars,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: ' .$token2
  ),

));



$response2 = curl_exec($curl);



curl_close($curl);
  

$itemweb = json_decode($response2, true);

// echo  $response2;

return $itemweb;



//echo $response2;

}





//Validar web key

function validarWebkey($WebinarKey)
{
  $validacion = false;
  $itemweb = conectar();

  for ($i = 0; $i < sizeof($itemweb["_embedded"]["webinars"]); $i++) {
    if (strcmp($WebinarKey, ($itemweb["_embedded"]["webinars"][$i]["webinarKey"])) === 0) {
      $validacion = true;
    
    }
  }
  if ($validacion == true) {
    return $validacion;
  } else {
    return $validacion;
  }


}






//TRAER DATOS DE LAS SECCIONES

function getSession()
{

  $item = getToken();
  $token = $item["access_token"];
  $organizerKey = $item["organizer_key"];
  $accountsKey = $item["account_key"];
  $token2 = "Bearer " . $token;
  $contents = $_COOKIE["webkey"];
  $urlsession = 'https://api.getgo.com/G2W/rest/v2/organizers/' . $organizerKey . '/' . 'webinars/' . $contents . '/sessions';


  $curl = curl_init();




  curl_setopt_array($curl, array(
    CURLOPT_URL => $urlsession,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'Authorization: ' . $token2
    ),
  ));

  $response2 = curl_exec($curl);

  curl_close($curl);
  //echo $response2;

  $item2 = json_decode($response2, true);

  $sessionKey = $item2["_embedded"]["sessionInfoResources"][(sizeof($item2["_embedded"]["sessionInfoResources"]) - 1)]["sessionKey"];
  if($sessionKey==null){
    return 1;
  }
  else{
    return $sessionKey;
  }
}



//traer asistentes 

function getasistentes()
{
  $item = getToken();
  $token = $item["access_token"];
  $organizerKey = $item["organizer_key"];
  $token2 = "Bearer " . $token;
  $contents = $_COOKIE["webkey"];

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.getgo.com/G2W/rest/v2/organizers/' . $organizerKey . '/webinars' . '/' . $contents . '/registrants',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'Authorization: ' . $token2
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  //echo $response;
  $item = json_decode($response, true);

  return $item;
}
