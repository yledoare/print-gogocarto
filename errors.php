<?php

include("functions.php");

$choice="https://transiscope.gogocarto.fr/api/elements.json?bounds=-4.57031%2C47.50236%2C-3.42773%2C48.26857";
$json=CallCurl($choice);

$i=0;

$transiscope=json_decode($json, true);
echo sizeof($transiscope['data']) . " points \n\n";
while($i < sizeof($transiscope['data']))
{
	//if (!isset($transiscope['data'][$i]["abstract"])) continue;
	if (!isset($transiscope['data'][$i]["abstract"]))
	{
		echo "No Abstract for ". $transiscope['data'][$i]["name"]."\n";
		$i++;
		continue;
	}
	if (!isset($transiscope['data'][$i]["address"]["addressLocality"]))
	{
		echo "No addressLocality for ". $transiscope['data'][$i]["name"] . "\n";
		$i++;
		continue;
	}
	$i++;
}