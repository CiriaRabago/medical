<?php  // content="text/plain; charset=iso-8859-1"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');

$datay=array(12,8,19,3,10,5);

// Create the graph. These two calls are always required
$graph = new Graph(300,200);	
$graph->SetScale("textlin");

// Add a drop shadow
$graph->SetShadow();

// Adjust the margin a bit to make more room for titles
$graph->img->SetMargin(40,30,20,40);

// Create a bar pot
$bplot = new BarPlot($datay);

// Adjust fill color
$bplot->SetFillColor('orange');

// Setup values
$bplot->value->Show();
$bplot->value->SetFormat('%d');
$bplot->value->SetFont(FF_FONT1,FS_BOLD);

// Center the values in the bar
$bplot->SetValuePos('center');

// Make the bar a little bit wider
$bplot->SetWidth(0.7);

$graph->Add($bplot);

// Setup the titles
$graph->title->Set("Centered values for bars");
$graph->xaxis->title->Set("X-title");
$graph->yaxis->title->Set("Y-title");

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// Display the graph
$graph->Stroke();
?>
