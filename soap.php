<?php
include('app/bootstrap.php');

$url = 'http://m2.dev/soap?wsdl&services=customerCustomerRepositoryV1';
// Also tried /soap/V1/
$token = '89fks3o79795sukpvappj3sw990s7bml';
$client = new Zend\Soap\Client($url);
$client->setSoapVersion(SOAP_1_2);
$context = stream_context_create(array('http' => array('header' => 'Authorization: Bearer ' . $token)));
$client->setStreamContext($context);

$data = $client->customerCustomerRepositoryV1getById(array('customerId' => 1));
// Also tried customerCustomerRepositoryV1GetById

var_dump($data);
