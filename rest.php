<?php
include('app/bootstrap.php');

$url  = 'http://m2.dev/index.php/rest/V1/exampleRepoData';
$params = array('id' => '1');
$url .= '?' . http_build_query($params);

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$result = curl_exec($ch);
curl_close($ch);

$result = json_decode($result);
var_dump($result);
