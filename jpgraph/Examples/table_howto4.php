<?php 
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_canvas.php');
require_once ('jpgraph/jpgraph_table.php');

// Create a canvas graph where the table can be added
$graph = new CanvasGraph(70,50);

// Setup the basic table
$data = array( array(1,2,3,4),array(5,6,7,8));
$table = new GTextTable();
$table->Set($data);

// Merge all cells in row 0
$table->MergeRow(0);

// Set foreground and background color
$table->SetCellFillColor(0,0,'orange@0.7');
$table->SetCellColor(0,0,'darkred');

// Add the table to the graph
$graph->Add($table);

// and send it back to the client
$graph->Stroke();

?>

