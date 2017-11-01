<?php  // content="text/plain; charset=iso-8859-1"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_pie.php');

$data = array(40,60,21,33,12,33);

$graph = new PieGraph(150,150);
$graph->SetShadow();

$graph->title->Set("'sand' Theme");
$graph->title->SetFont(FF_FONT1,FS_BOLD);

$p1 = new PiePlot($data);
$p1->SetTheme("sand");
$p1->SetCenter(0.5,0.55);
$p1->value->Show(false);
$graph->Add($p1);
$graph->Stroke();

?>


