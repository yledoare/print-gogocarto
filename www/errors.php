<?php

include("functions.php");

if(php_sapi_name() != "cli") 
{
	if(!isset($_POST["zone"])) die("No Zone");
	if(!isset($_POST["title"])) die("No Title");
}
else
{
	$zone="https://transiscope.gogocarto.fr/api/elements.json?bounds=-4.57031%2C47.50236%2C-3.42773%2C48.26857";
	$title="My GoGoCartoPrint";
}

$zone="https://transiscope.gogocarto.fr/api/elements.json?bounds=-4.57031%2C47.50236%2C-3.42773%2C48.26857";
$json=CallCurl($zone);

$i=0;

$transiscope=json_decode($json, true);
echo sizeof($transiscope['data']) . " points ".EndLine().EndLine();
while($i < sizeof($transiscope['data']))
{
	//if (!isset($transiscope['data'][$i]["abstract"])) continue;
	if (!isset($transiscope['data'][$i]["abstract"]))
	{
		echo "No Abstract for ". $transiscope['data'][$i]["name"].EndLine();
		$i++;
		continue;
	}
	if (!isset($transiscope['data'][$i]["address"]["addressLocality"]))
	{
		echo "No addressLocality for ". $transiscope['data'][$i]["name"] . EndLine();
		$i++;
		continue;
	}
	$i++;
}
