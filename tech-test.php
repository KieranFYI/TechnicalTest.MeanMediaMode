<?php

define('SRC', dirname(__FILE__) . '/src/');

// Ensure the autoloader is registered
require_once(SRC . 'Kieran/AutoLoader.php');
\Kieran\AutoLoader::SetDirectory(SRC);
spl_autoload_register('\Kieran\AutoLoader::Load');

// Load all the prasers available
\Kieran\ParserFactory::Load();

// Attempt to get the parser for the file requested
$pathToParse = './testdata.csv';
/* iParser */ $parser = \Kieran\ParserFactory::GetParser($pathToParse);

// Parse the file returning an array of SaleRecord
/* SaleRecord[] */ $saleRecords = $parser->Parse($pathToParse);

// Create a new summary model to store the data
$summary = new \Kieran\Models\Summary();
$summary->Total = \Kieran\Math\SalesRecordMath::GetTotal($saleRecords); 
$summary->Mean = round($summary->Total / count($saleRecords), 2);
/* Modal */  $modal = \Kieran\Math\SalesRecordMath::GetModal($saleRecords);
$summary->Modal = $modal->Values;
$summary->Frequency = $modal->Frequency;
$summary->Median = \Kieran\Math\SalesRecordMath::GetMedian($saleRecords);

// Output the object as json
die(json_encode($summary, JSON_PRETTY_PRINT));
