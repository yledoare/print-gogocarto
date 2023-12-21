<?php

function CallCurl($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
    if(!$result) die("KO");
    curl_close($curl);

    return $result;
}
