<?php
$client = new \GuzzleHttp\Client();
/*$res = $client->request(
    'POST',
    'https://im2.io/kjtlgmzqks/quality=medium/'.SdkRestApi::getParam('imageUrl'),
    []
);*/
$request = new \GuzzleHttp\Psr7\Request('POST',  'https://im2.io/kjtlgmzqks/quality=medium/'.SdkRestApi::getParam('imageUrl'));
$res = $client->send($request, ['timeout' => 0]);

$body = $res->getBody();
$body->rewind();
/** @return array */
return $res->getBody()->getContents();