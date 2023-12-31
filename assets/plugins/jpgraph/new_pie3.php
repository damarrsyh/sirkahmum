<?php // content="text/plain; charset=utf-8"
require_once('jpgraph.php');
require_once('jpgraph_pie.php');
require_once('jpgraph_pie3d.php');

// Some data
$data = array(25, 25, 25, 25);

// Create the Pie Graph. 
$graph = new PieGraph(350, 250);

$theme_class = new UniversalTheme;
$graph->SetTheme($theme_class);

// Set A title for the plot
$graph->title->Set("Persentase Nominal");

// Create
$p1 = new PiePlot3D($data);
$graph->Add($p1);

$p1->ShowBorder();
$p1->SetColor('black');
$p1->SetSliceColors(array('#1E90FF', '#2E8B57', '#ADFF2F', '#BA55D3'));
$p1->ExplodeSlice(1);
$graph->Stroke();
