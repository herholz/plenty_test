<?php
 
$client = new \GuzzleHttp\Client();
$res = $client->request(
    'POST',
    'https://im2.io/kjtlgmzqks/quality=medium/'.SdkRestApi::getParam('imageUrl'),
    []
);
 
/** @return array */
return (string) $res->getBody();