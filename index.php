<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "code start execute: ". date('Y-m-d h:i:s:');
require_once 'vendor/autoload.php';

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;
use GuzzleHttp\Client;

// Function to fetch PDF from a given URL asynchronously using Guzzle
function fetchPDFAsync($url, &$pdfContents, $client)
{
    $response = $client->get($url, [
        'verify' => false, // Disable SSL certificate verification
    ]);
    $pdfContents[] = $response->getBody()->getContents();
}

// Function to merge PDFs
function mergePDFs($pdfs, $outputFile)
{
    $pdf = new Fpdi();

    foreach ($pdfs as $pdfContent) {
        $pdf->setSourceFile(StreamReader::createByString($pdfContent));
        $pageCount = $pdf->setSourceFile(StreamReader::createByString($pdfContent));
        for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
            $templateId = $pdf->importPage($pageNumber);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->AddPage($size['orientation'], $size);
            $pdf->useTemplate($templateId);
        }
    }

    $pdf->output($outputFile, 'F');
}

// List of URLs containing PDF files
$urls = [
   
        // Add more URLs as needed
    ];

// Create a Guzzle client for asynchronous requests
$client = new Client();

// Array to store fetched PDF contents
$pdfContents = [];

// Fetch PDFs from URLs asynchronously
foreach ($urls as $url) {
    fetchPDFAsync($url, $pdfContents, $client);
}

// Merge PDFs into a single file
$outputFile = 'merged.pdf';
mergePDFs($pdfContents, $outputFile);
echo "<br>";
echo 'PDFs merged successfully into ' . $outputFile . PHP_EOL;
echo "<br>";
echo "code stopped  execute: ". date('Y-m-d h:i:s:');

