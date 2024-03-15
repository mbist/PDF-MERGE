To understant  the performance, i have utilize parallel processing to 
fetch multiple PDF files concurrently, which can reduce the overall execution time. To achieve parallel processing in PHP is by using multi-threading or asynchronous processing libraries like Guzzle.


1. Please install composre if not or update the composer
2. Then Please install guzzlehttp,tcpdf,fpdi,fpdf buy below command
	composer require guzzlehttp/guzzle tecnickcom/tcpdf setasign/fpdi setasign/fpdf
3. You might be enabled any php extension from php.ini if required.

Below is the result
code start execute: 2024-03-13 04:56:44:
PDFs merged successfully into merged.pdf
code stopped execute: 2024-03-13 04:56:46:
