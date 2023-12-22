<?php

include("fpdf/fpdf.php");
include("functions.php");

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

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',32);
$pdf->Cell(40,10,$title);
$pdf->Image('logo.png',10,32,100,100,'','https://www.transiscope.org/');
$pdf->AddPage();

/*
$pdf->SetFont('Arial','B',16);
$pdf->SetFillColor(232,232,232);

$row_height = 10;
$x_axis = 30;
$y_axis = 20;
 */

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
	$name=$transiscope['data'][$i]["name"];
	if($debug == 1)
		echo $transiscope['data'][$i]["name"].EndLine();

	$sourceKey=$transiscope['data'][$i]["sourceKey"];
	if($debug == 1)
		echo " ". $transiscope['data'][$i]["sourceKey"].EndLine();

	$abstract=$transiscope['data'][$i]["abstract"];
	if($debug == 1)
		echo " : ". $transiscope['data'][$i]["abstract"].EndLine();

	$addressLocality=$transiscope['data'][$i]["address"]["addressLocality"];
	if($debug == 1)
		echo " @ ". $transiscope['data'][$i]["address"]["addressLocality"].EndLine();

	if(isset($transiscope['data'][$i]["website"])) $website=$transiscope['data'][$i]["website"];
	if($debug == 1)
		echo $website.EndLine();

	$category="";
	while($j < sizeof($transiscope['data'][$i]["categories"]))
	{
		if($debug == 1)
		echo " - ".$transiscope['data'][$i]["categories"][$j].EndLine();
		$category=$category." ,".$transiscope['data'][$i]["categories"][$j];
		$j++;
	}

	/*
	$line=$i*20;

        $y_axis = $y_axis + $row_height;
        $pdf->SetFillColor(252,252,252);
        $pdf->SetY($y_axis);
        $pdf->SetX(10);
        $pdf->Cell(150,8,utf8_decode($transiscope['data'][$i]["name"]),1,0,'L',1);

	*/

	$i++;
	$good++;

	/*
	if($good % 24 == 0) 
	{
		$pdf->AddPage();
		$y_axis = 0;

	}
	*/
	//if($good > 60) break;
	$pdf->SetLeftMargin(10);
	$pdf->SetFontSize(18);
	$html="$name ($addressLocality)<br><br><br>";
	$pdf->WriteHTML(utf8_decode($html));

	//$pdf->SetLeftMargin(45);
	$pdf->SetFontSize(12);
	$html="$abstract<br><br>";
	$pdf->WriteHTML(utf8_decode($html));

}

/*
$html = 'Vous pouvez maintenant imprimer facilement du texte mélangeant différents styles : <b>gras</b>,
<i>italique</i>, <u>souligné</u>, ou <b><i><u>tous à la fois</u></i></b> !<br><br>Vous pouvez aussi
insérer des liens sous forme textuelle, comme <a href="http://www.fpdf.org">www.fpdf.org</a>, ou bien
sous forme d\'image : cliquez sur le logo.';

$pdf->AddPage();
//$pdf->SetLink($link);
$pdf->SetLeftMargin(45);
$pdf->SetFontSize(14);
for($x=0; $x<10; $x++)
	$pdf->WriteHTML(utf8_decode($html));
 */
if($debug == 0)
  $pdf->Output();
