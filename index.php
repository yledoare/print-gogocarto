<?php

include("functions.php");

$choice="https://transiscope.gogocarto.fr/api/elements.json?bounds=-4.57031%2C47.50236%2C-3.42773%2C48.26857";
$json=CallCurl($choice);

$i=0;
$j=0;
$transiscope=json_decode($json, true);
while($i < sizeof($transiscope['data']))
{
	//if (!isset($transiscope['data'][$i]["abstract"])) continue;
	if (!isset($transiscope['data'][$i]["abstract"]))
	{
		$i++;
		continue;
	}
	if (!isset($transiscope['data'][$i]["address"]["addressLocality"]))
	{
		$i++;
		continue;
	}
	echo $transiscope['data'][$i]["name"]."\n";
	echo " ". $transiscope['data'][$i]["sourceKey"]."\n";
	echo " : ". $transiscope['data'][$i]["abstract"]."\n";
	echo " @ ". $transiscope['data'][$i]["address"]["addressLocality"]."\n";
	if(isset($transiscope['data'][$i]["website"])) echo " / ". $transiscope['data'][$i]["website"]."\n";
	while($j < sizeof($transiscope['data'][$i]["categories"]))
	{
		echo " - ".$transiscope['data'][$i]["categories"][$j]."\n";
		$j++;
	}
	$i++;
}
