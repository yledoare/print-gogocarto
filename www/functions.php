<?php

function EndLine()
{
	if(php_sapi_name() == "cli") return ("\n");
	return ("<br>");
}
function CallCurl($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
    if(!$result) die("$url KO");
    curl_close($curl);

    return $result;
}
