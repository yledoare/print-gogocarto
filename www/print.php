<?php

include("functions.php");
include("fpdf/fpdf.php");

$debug=0;

$zone="https://transiscope.gogocarto.fr/api/elements.json?bounds=-4.57031%2C47.50236%2C-3.42773%2C48.26857";
$title="My GoGoCartoPrint";

if(php_sapi_name() != "cli") 
{
	if(!isset($_POST["zone"])) die("No Zone");
	if(!isset($_POST["title"])) die("No Title");
	$zone=$_POST["zone"];
	$title=$_POST["title"];
	if(isset($_GET["debug"])) $debug=$_GET["debug"];
}

$json=CallCurl($zone);

$i=0;
$good=0;
$j=0;
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',32);
$pdf->Cell(40,10,$_POST["title"]);
$pdf->SetFont('Arial','B',16);
$pdf->SetFillColor(232,232,232);

$row_height = 10;
$x_axis = 30;
$y_axis = 20;

$transiscope=json_decode($json, true);
	if($debug == 1)
echo sizeof($transiscope['data']) . " points ".EndLine().EndLine();
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

	if($debug == 1)
		echo $transiscope['data'][$i]["name"].EndLine();

	if($debug == 1)
		echo " ". $transiscope['data'][$i]["sourceKey"].EndLine();
	if($debug == 1)
		echo " : ". $transiscope['data'][$i]["abstract"].EndLine();
	if($debug == 1)
		echo " @ ". $transiscope['data'][$i]["address"]["addressLocality"].EndLine();

	if($debug == 1)
		if(isset($transiscope['data'][$i]["website"])) echo " / ". $transiscope['data'][$i]["website"].EndLine();

	while($j < sizeof($transiscope['data'][$i]["categories"]))
	{
		if($debug == 1)
		echo " - ".$transiscope['data'][$i]["categories"][$j].EndLine();
		$j++;
	}

	$line=$i*20;

        $y_axis = $y_axis + $row_height;
        $pdf->SetFillColor(252,252,252);
        $pdf->SetY($y_axis);
        $pdf->SetX(10);
        $pdf->Cell(150,8,utf8_decode($transiscope['data'][$i]["name"]),1,0,'L',1);

	/*
        $pdf->SetFillColor(232,232,232);
        $y_axis = $y_axis + $row_height;
        $pdf->SetX(10);
        $pdf->SetY($y_axis);
        $pdf->Cell(120,40,utf8_decode($transiscope['data'][$i]["abstract"]),1,0,'L',1);
	 */

	$i++;
	$good++;

	if($good % 24 == 0) 
	{
		$pdf->AddPage();
		$y_axis = 0;

	}
        //if($good > 60) break;

}

if($debug == 0)
	$pdf->Output();
